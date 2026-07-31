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
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseFilePath = base_path('data/words');
        $languages = array_diff(scandir($baseFilePath), ['.', '..', 'base']);
        foreach ($languages as $language) {

            $firstLanguage = DB::table('languages')->where(['code' => $language])->first();
            $baseLanguages = array_diff(scandir($baseFilePath . '/' . $language), ['.', '..']);

            foreach ($baseLanguages as $baseLanguage) {
                $targetLanguage = str_replace('.jsonl', '', $baseLanguage);
                $secondLanguage = DB::table('languages')->where(['code' => $targetLanguage])->first();
                $fileDescriptor = fopen($baseFilePath. '/' .$language . '/' . $baseLanguage , 'r');
                echo "Загружаю языковой пакет $firstLanguage->code -  $secondLanguage->code\n";
                while (($line = fgets($fileDescriptor)) !== false) {
                    $word = json_decode($line);
                    $wordId = DB::table('words')->insertGetId([
                        'text' => $word->{$language},
                        'language_id' => $firstLanguage->id,
                        'level' => $word->level
                    ]);

                    DB::table('word_translations')->insert([
                        'word_id' => $wordId,
                        'target_language_id' => $secondLanguage->id,
                        'translation' => $word->{$targetLanguage},
                    ]);
                }

                fclose($fileDescriptor);

            }
        }
    }
}
