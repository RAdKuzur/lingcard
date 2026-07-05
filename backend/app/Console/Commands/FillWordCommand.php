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
    /**
     * Execute the console command.
     */
    public function handle()
    {



        $file = fopen(base_path('data/test.json'), 'r');
        DB::table('words')->truncate();
        DB::table('word_translations')->truncate();
        $ruLanguage = DB::table('languages')->where(['code' => 'ru'])->first();
        $kzLanguage = DB::table('languages')->where(['code' => 'kz'])->first();

        while (($line = fgets($file)) !== false) {
            $word = json_decode($line);
            foreach ($word->senses as $sense) {
                echo $word->word . ' ' . $sense->glosses[0] . PHP_EOL;

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
