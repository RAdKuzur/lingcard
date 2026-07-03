<?php

namespace Database\Seeders;

use App\Dictionaries\LevelDictionary;
use App\Dictionaries\RoleDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordSeeder extends Seeder
{

    const WORDS = [
        ['car', 'машина'],
        ['door', 'дверь'],
        ['house', 'дом'],
        ['tree', 'дерево'],
        ['water', 'вода'],
        ['fire', 'огонь'],
        ['sun', 'солнце'],
        ['moon', 'луна'],
        ['star', 'звезда'],
        ['flower', 'цветок'],
        ['book', 'книга'],
        ['table', 'стол'],
        ['chair', 'стул'],
        ['window', 'окно'],
        ['garden', 'сад'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('words')->truncate();
        foreach (self::WORDS as $word) {
            DB::table('words')->insert([
                'text' => $word[0],
                'language_id' => 1,
                'level' => LevelDictionary::EASY
            ]);

            $row = DB::table('words')->where('text', $word[0])->first();
            DB::table('word_translations')->insert([
                'word_id' => $row->id,
                'target_language_id' => 2,
                'translation' => $word[1],
            ]);
        }
    }
}
