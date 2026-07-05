<?php

namespace App\Console\Commands;

use App\Dictionaries\LevelDictionary;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:fill-word')]
#[Description('Перенести слова с json в БД')]
class FillWordCommand extends Command
{
    const FILEPATH = [
        'data/1.jsonl',
        'data/2.jsonl',
        'data/3.jsonl',
        'data/4.jsonl',
        'data/5.jsonl',
        'data/6.jsonl',
        'data/7.jsonl',
        'data/8.jsonl',
        'data/9.jsonl',
        'data/10.jsonl',
        'data/11.jsonl',
        'data/12.jsonl',
        'data/13.jsonl',
        'data/14.jsonl',
        'data/15.jsonl',
    ];
    /**
     * Execute the console command.
     */
    public function handle()
    {

        foreach (self::FILEPATH as $path) {
            $file = fopen(base_path($path), 'r');
            DB::table('words')->truncate();
            DB::table('word_translations')->truncate();
            $ruLanguage = DB::table('languages')->where(['code' => 'ru'])->first();
            $kzLanguage = DB::table('languages')->where(['code' => 'kz'])->first();

            while (($line = fgets($file)) !== false) {
                $word = json_decode($line);
                foreach ($word->senses as $sense) {
                    $wordId = DB::table('words')->insertGetId([
                        'text' => $sense->glosses[0],
                        'language_id' => $ruLanguage->id,
                        'level' => LevelDictionary::EASY
                    ]);

                    DB::table('word_translations')->insert([
                        'word_id' => $wordId,
                        'target_language_id' => $kzLanguage->id,
                        'translation' => $word->word,
                    ]);

                    $wordId = DB::table('words')->insertGetId([
                        'text' => $word->word,
                        'language_id' => $kzLanguage->id,
                        'level' => LevelDictionary::EASY
                    ]);

                    DB::table('word_translations')->insert([
                        'word_id' => $wordId,
                        'target_language_id' => $ruLanguage->id,
                        'translation' => $sense->glosses[0],
                    ]);

                }
            }
            fclose($file);
        }
    }
}
