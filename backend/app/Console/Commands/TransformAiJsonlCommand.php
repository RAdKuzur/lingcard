<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:transform-ai-jsonl-command')]
#[Description('Command description')]
class TransformAiJsonlCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseLanguages = ['jp', 'de', 'kr', 'ru', 'kz', 'en' ,'fr', 'es', 'pt', 'sa'];
        $targetLanguages = [
            'ru' => ['kz', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'kz' => ['ru', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'en' => ['ru', 'kz', 'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'fr' => ['ru', 'kz', 'en' ,'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'cn' => ['ru', 'kz', 'en' ,'fr', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'de' => ['ru', 'kz', 'en' ,'fr', 'cn', 'es', 'jp', 'kr', 'pt', 'sa'],
            'es' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'jp', 'kr', 'pt', 'sa'],
            'jp' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'es', 'kr', 'pt', 'sa'],
            'kr' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'pt', 'sa'],
            'pt' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'sa'],
            'sa' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt']
        ];
        foreach ($baseLanguages as $baseLanguage) {
            foreach ($targetLanguages[$baseLanguage] as $targetLanguage) {
                $fileManual = fopen(base_path("data/words/$baseLanguage/$targetLanguage.jsonl"), "r"); //-- файл, переведённый в ручную
                $fileAIFiltered = fopen(base_path("data/filtered/$baseLanguage/$targetLanguage.jsonl"), "w"); //-- файл, переведённый AI, но с транскрипциями и уровнем
                if (file_exists(base_path("data/ai/$targetLanguage/$baseLanguage.jsonl"))) {
                    $fileAI = fopen(base_path("data/ai/$targetLanguage/$baseLanguage.jsonl"), "r"); //-- файл, переведённый AI
                    $wordOriginalData = [];

                    while (($line = fgets($fileManual)) !== false) {
                        $word = json_decode($line);
                        $wordOriginalData[$word->{$baseLanguage}] = [
                            $targetLanguage => $word->{$targetLanguage},
                            'level' => $word->level,
                            'transcription' => $word->transcription ?? null,
                        ];
                    }

                    while (($line = fgets($fileAI)) !== false) {
                        $wordAI = json_decode($line);
                        if ($wordOriginalData[$wordAI->{$baseLanguage}]) {
                            $data = [
                                $baseLanguage => $wordAI->{$baseLanguage},
                                $targetLanguage =>$wordOriginalData[$wordAI->{$baseLanguage}][$targetLanguage],
                                'level' => $wordOriginalData[$wordAI->{$baseLanguage}]['level'],
                                'transcription' => $wordOriginalData[$wordAI->{$baseLanguage}]['transcription']
                            ];
                            fwrite($fileAIFiltered, json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL);
                        }
                        else {
                            //ничего нет, отдыхаем
                        }
                    }
                    fclose($fileAI);
                }
                else {
                    while (($line = fgets($fileManual)) !== false) {
                        $word = json_decode($line);
                        $data = [
                            $baseLanguage => $word->{$baseLanguage},
                            $targetLanguage =>$word->{$targetLanguage},
                            'level' => $word->level ?? null,
                            'transcription' => $word->transcription ?? null,
                        ];
                        fwrite($fileAIFiltered, json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL);
                    }
                }
                fclose($fileManual);
                fclose($fileAIFiltered);
            }
        }
    }
}
