<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:transform-jsonl-data-command')]
#[Description('Command description')]
class TransformJsonlDataCommand extends Command
{
    public function handle()
    {
        $baseFilePath = base_path('data/words');
        $languages = array_diff(scandir($baseFilePath), ['.', '..', 'base']);

        $languagesCache = [];
        foreach (DB::table('languages')->get() as $language) {
            $languagesCache[$language->code] = $language;
        }

        foreach ($languages as $language) {
            $firstLanguage = $languagesCache[$language] ?? null;
            if (!$firstLanguage) {
                echo "Язык {$language} не найден в БД\n";
                continue;
            }

            $baseLanguages = array_diff(scandir($baseFilePath . '/' . $language), ['.', '..']);

            foreach ($baseLanguages as $baseLanguage) {
                $targetLanguage = str_replace('.jsonl', '', $baseLanguage);
                $secondLanguage = $languagesCache[$targetLanguage] ?? null;

                if (!$secondLanguage) {
                    echo "Язык {$targetLanguage} не найден в БД\n";
                    continue;
                }

                $filePath = $baseFilePath . '/' . $language . '/' . $baseLanguage;
                echo "Загружаю языковой пакет {$firstLanguage->code} - {$secondLanguage->code}\n";

                $this->processFileWithBatchInsert($filePath, $firstLanguage, $secondLanguage, $language, $targetLanguage);
            }
        }
    }

    private function processFileWithBatchInsert($filePath, $firstLanguage, $secondLanguage, $sourceField, $targetField)
    {
        $batchSize = 1000;
        $wordsBatch = [];
        $translationsBatch = [];
        $wordTranslationsMap = [];

        $fileDescriptor = fopen($filePath, 'r');
        if (!$fileDescriptor) {
            echo "Не удалось открыть файл: {$filePath}\n";
            return;
        }

        $lineNumber = 0;
        while (($line = fgets($fileDescriptor)) !== false) {
            $lineNumber++;
            $word = json_decode($line);

            if (!$word || !isset($word->{$sourceField})) {
                echo "Ошибка в строке {$lineNumber}\n";
                continue;
            }

            $wordsBatch[] = [
                'text' => $word->{$sourceField},
                'transcription' => $word->transcription ?? null,
                'language_id' => $firstLanguage->id,
                'level' => $word->level ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $translation = $word->{$targetField} ?? '';
            $wordTranslationsMap[] = [
                'translation' => $translation,
                'target_language_id' => $secondLanguage->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($wordsBatch) >= $batchSize) {
                $this->insertBatch($wordsBatch, $wordTranslationsMap);
                $wordsBatch = [];
                $wordTranslationsMap = [];
            }
        }

        if (!empty($wordsBatch)) {
            $this->insertBatch($wordsBatch, $wordTranslationsMap);
        }

        fclose($fileDescriptor);
    }

    private function insertBatch($wordsBatch, $translationsBatch)
    {
        try {
            DB::transaction(function () use ($wordsBatch, $translationsBatch) {

                DB::table('words')->insert($wordsBatch);

                $lastIds = DB::table('words')
                    ->orderBy('id', 'desc')
                    ->limit(count($wordsBatch))
                    ->pluck('id')
                    ->reverse()
                    ->values();

                $translationsWithWordIds = [];
                foreach ($translationsBatch as $index => $translation) {
                    $translation['word_id'] = $lastIds[$index] ?? null;
                    if ($translation['word_id']) {
                        $translationsWithWordIds[] = $translation;
                    }
                }

                if (!empty($translationsWithWordIds)) {
                    DB::table('word_translations')->insert($translationsWithWordIds);
                }
            });
        } catch (\Exception $e) {
            echo "Ошибка при пакетной вставке: " . $e->getMessage() . "\n";
        }
    }
}
