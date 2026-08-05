<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Promise\PromiseInterface;

#[Signature('app:transform-jsonl-command')]
#[Description('Command description')]
class TransformJsonlCommand extends Command
{
    private $concurrency = 1;
    private $batchSize = 30;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseLanguage = 'cn';
        $languages = ['ru', 'kz', 'jp'];
        foreach ($languages as $language) {
            $baseFilePath = base_path("data/words/$baseLanguage/$language.jsonl");
            $createdFilePath = base_path("data/ai/$baseLanguage/$language.jsonl");

            $file = fopen($baseFilePath, "r");
            $file2 = fopen($createdFilePath, "w+");

            $index = 0;
            $batch = [];
            $allBatches = [];

            while (($line = fgets($file)) !== false) {
                $line = trim($line);
                if (empty($line)) continue;

                $word = json_decode($line, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo "Ошибка JSON в строке $index: " . json_last_error_msg() . "\n";
                    fwrite($file2, $line . "\n");
                    $index++;
                    continue;
                }

                $batch[] = $word;
                $index++;

                if (count($batch) >= $this->batchSize) {
                    $allBatches[] = $batch;
                    $batch = [];
                }
            }

            if (!empty($batch)) {
                $allBatches[] = $batch;
            }

            fclose($file);

            echo "Всего батчей: " . count($allBatches) . "\n";
            echo "Всего слов: $index\n";
            echo "Начинаем параллельную обработку...\n\n";

            $batchesChunks = array_chunk($allBatches, $this->concurrency);
            $totalChunks = count($batchesChunks);
            $currentChunk = 0;

            foreach ($batchesChunks as $batchChunk) {
                $currentChunk++;
                echo "⏳ Обработка чанка $currentChunk из $totalChunks (батчей: " . count($batchChunk) . ")\n";

                $this->processBatchesParallel($batchChunk, $baseLanguage, $language, $file2);

                echo "✅ Чанк $currentChunk обработан\n\n";
            }

            fclose($file2);

            echo "🎉 Готово! Обработано $index записей.\n";
        }

    }

    /**
     * Параллельная обработка нескольких батчей
     */
    private function processBatchesParallel(array $batches, string $baseLanguage, string $targetLanguage, $outputFile)
    {
        $promises = [];

        foreach ($batches as $batchId => $batch) {
            $prompt = $this->buildPrompt($batch, $baseLanguage, $targetLanguage);
            $wordCount = count($batch);

            echo "  📤 Отправка батча #$batchId (слов: $wordCount)...\n";

            $promises[$batchId] = Http::async()
                ->timeout(120)
                ->retry(3, 1000)
                ->post('http://localhost:1234/v1/chat/completions', [
                    'model' => 'qwen3-4b',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a professional translator and language expert. Correct translation errors and remove duplicates. Return ONLY valid JSON array.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.1,
                    'max_tokens' => 2000,
                ]);
        }

        try {
            $responses = Utils::settle($promises)->wait();

            foreach ($responses as $batchId => $response) {
                $this->handleResponse($response, $batches[$batchId], $outputFile, $batchId);
            }

        } catch (\Exception $e) {
            echo "❌ Критическая ошибка при параллельной обработке: " . $e->getMessage() . "\n";

            // В случае ошибки записываем исходные данные
            foreach ($batches as $batch) {
                foreach ($batch as $word) {
                    fwrite($outputFile, json_encode($word, JSON_UNESCAPED_UNICODE) . "\n");
                }
            }
        }
    }

    /**
     * Обработка одного ответа от AI
     */
    private function handleResponse($response, array $batch, $outputFile, int $batchId)
    {
        if ($response['state'] === 'rejected') {
            $error = $response['reason'] ?? 'Unknown error';
            echo "  ❌ Батч #$batchId провалился: " . $error . "\n";

            foreach ($batch as $word) {
                fwrite($outputFile, json_encode($word, JSON_UNESCAPED_UNICODE) . "\n");
            }
            return;
        }

        try {
            $httpResponse = $response['value'];

            if (!$httpResponse->successful()) {
                throw new \Exception("HTTP error: " . $httpResponse->status());
            }

            $result = $httpResponse->json();
            $aiResponse = $result['choices'][0]['message']['content'] ?? '';

            $cleanedResponse = $this->extractJson($aiResponse);
            $correctedBatch = json_decode($cleanedResponse, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON response: " . json_last_error_msg() . "\nResponse: " . $aiResponse);
            }

            if (count($correctedBatch) !== count($batch)) {
                echo "  ⚠️ Батч #$batchId: количество слов не совпадает (оригинал: " . count($batch) . ", получено: " . count($correctedBatch) . ")\n";
            }

            foreach ($correctedBatch as $correctedWord) {
                fwrite($outputFile, json_encode($correctedWord, JSON_UNESCAPED_UNICODE) . "\n");
            }

            echo "  ✅ Батч #$batchId обработан успешно (слов: " . count($correctedBatch) . ")\n";

        } catch (\Exception $e) {
            echo "  ❌ Батч #$batchId ошибка: " . $e->getMessage() . "\n";
            foreach ($batch as $word) {
                fwrite($outputFile, json_encode($word, JSON_UNESCAPED_UNICODE) . "\n");
            }
        }
    }

    /**
     * Формирование промпта для AI
     */
    private function buildPrompt(array $batch, string $baseLanguage, string $targetLanguage): string
    {
        // Убираем transcription и level из данных перед отправкой
        $cleanBatch = array_map(function($word) use ($baseLanguage, $targetLanguage) {
            return [
                $baseLanguage => $word[$baseLanguage],
                $targetLanguage => $word[$targetLanguage]
            ];
        }, $batch);

        $wordsJson = json_encode($cleanBatch, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return <<<PROMPT
I have a list of words for language learning. Each word has the following structure:
- "$baseLanguage": the base word in source language (THIS IS CORRECT, DO NOT CHANGE IT)
- "$targetLanguage": the translation in target language (THIS MAY HAVE ERRORS, FIX IT)

Task:
1. Correct translation errors in the "$targetLanguage" field
2. Remove duplicate translations (keep only one correct translation)
3. Make sure translations are accurate and idiomatic
4. Keep the original "$baseLanguage" field EXACTLY as provided
5. Return ONLY the fields "$baseLanguage" and "$targetLanguage" in the response
6. Remove any other fields like transcription, level, etc.

IMPORTANT: Return ONLY valid JSON array with the corrected words. Keep only these fields: $baseLanguage, $targetLanguage

Original words:
$wordsJson

Corrected words (JSON array only):
PROMPT;
    }

    /**
     * Извлечение JSON из ответа AI
     */
    private function extractJson(string $response): string
    {
        $response = preg_replace('/```json\s*/', '', $response);
        $response = preg_replace('/```\s*/', '', $response);

        if (preg_match('/\[\s*\{.*\}\s*\]/s', $response, $matches)) {
            return $matches[0];
        }

        if (preg_match('/\{\s*".*"\s*:.*\}/s', $response, $matches)) {
            return '[' . $matches[0] . ']';
        }
        return $response;
    }
}
