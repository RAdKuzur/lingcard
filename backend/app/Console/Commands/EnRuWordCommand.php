<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:en-ru-word-command')]
#[Description('Command description')]
class EnRuWordCommand extends Command
{
    const FILEPATH = [
        'data/en-ru.jsonl'
    ];
    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (self::FILEPATH as $path) {
            $file = fopen(base_path($path), 'r');

            $ruLanguage = DB::table('languages')->where(['code' => 'ru'])->first();
            $enLanguage = DB::table('languages')->where(['code' => 'en'])->first();

            while (($line = fgets($file)) !== false) {
                $word = json_decode($line);
                $wordId = DB::table('words')->insertGetId([
                    'text' => $word->ru,
                    'language_id' => $ruLanguage->id,
                    'level' => $word->level
                ]);

                DB::table('word_translations')->insert([
                    'word_id' => $wordId,
                    'target_language_id' => $enLanguage->id,
                    'translation' => $word->en,
                ]);

                $wordId = DB::table('words')->insertGetId([
                    'text' => $word->en,
                    'language_id' => $enLanguage->id,
                    'level' => $word->level
                ]);

                DB::table('word_translations')->insert([
                    'word_id' => $wordId,
                    'target_language_id' => $ruLanguage->id,
                    'translation' =>  $word->ru,
                ]);
            }
            fclose($file);
        }
    }
}
