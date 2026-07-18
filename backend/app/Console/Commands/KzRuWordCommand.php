<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:kz-ru-word-command')]
#[Description('Command description')]
class KzRuWordCommand extends Command
{
    const FILEPATH = [
        'data/ru-kz.jsonl'
    ];
    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (self::FILEPATH as $path) {
            $file = fopen(base_path($path), 'r');
            $ruLanguage = DB::table('languages')->where(['code' => 'ru'])->first();
            $kzLanguage = DB::table('languages')->where(['code' => 'kz'])->first();
            while (($line = fgets($file)) !== false) {
                $word = json_decode($line);
                $wordId = DB::table('words')->insertGetId([
                    'text' => $word->ru,
                    'language_id' => $ruLanguage->id,
                    'level' => $word->level
                ]);

                DB::table('word_translations')->insert([
                    'word_id' => $wordId,
                    'target_language_id' => $kzLanguage->id,
                    'translation' => $word->kz,
                ]);

                $wordId = DB::table('words')->insertGetId([
                    'text' => $word->kz,
                    'language_id' => $kzLanguage->id,
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
