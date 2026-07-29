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
        $baseFilePath = base_path('data');
        $files = array_diff(scandir($baseFilePath), ['.', '..', 'jsonl']);

        foreach ($files as $file) {
            $fileName = str_replace('.jsonl', '', $file);
            $languages = explode('-', $fileName);

            $firstLanguage = DB::table('languages')->where(['code' => $languages[0]])->first();
            $secondLanguage = DB::table('languages')->where(['code' => $languages[1]])->first();

            $fileDescriptor = fopen($baseFilePath . '/'. $file, 'r');

            while (($line = fgets($fileDescriptor)) !== false) {
                $word = json_decode($line);
                $wordId = DB::table('words')->insertGetId([
                    'text' => $word->{$languages[0]},
                    'language_id' => $firstLanguage->id,
                    'level' => $word->level
                ]);

                DB::table('word_translations')->insert([
                    'word_id' => $wordId,
                    'target_language_id' => $secondLanguage->id,
                    'translation' => $word->{$languages[1]},
                ]);

                $wordId = DB::table('words')->insertGetId([
                    'text' => $word->{$languages[1]},
                    'language_id' => $secondLanguage->id,
                    'level' => $word->level
                ]);

                DB::table('word_translations')->insert([
                    'word_id' => $wordId,
                    'target_language_id' => $firstLanguage->id,
                    'translation' =>  $word->{$languages[0]},
                ]);
            }
            fclose($fileDescriptor);
        }
    }
}
