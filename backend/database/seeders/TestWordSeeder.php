<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Word;
use App\Models\WordTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $language1 = Language::where('code', 'en')->first();
        $language2 = Language::where('code', 'ru')->first();
        $words = [
            0 => ['en' => 'car', 'ru' => 'машина'],
            1 => ['en' => 'house', 'ru' => 'дом'],
            2 => ['en' => 'book', 'ru' => 'книга'],
            3 => ['en' => 'apple', 'ru' => 'яблоко'],
            4 => ['en' => 'water', 'ru' => 'вода']
        ];

        foreach ($words as $word) {
            $word1 = Word::create([
                'text' => $word['en'],
                'transcription' => null,
                'language_id' => $language1->id,
                'level' => 1,
            ]);
            WordTranslation::create([
                'word_id' => $word1->id,
                'target_language_id' => $language2->id,
                'translation' => $word['ru'],
            ]);

            $word2 = Word::create([
                'text' => $word['ru'],
                'transcription' => null,
                'language_id' => $language2->id,
                'level' => 1,
            ]);
            WordTranslation::create([
                'word_id' => $word2->id,
                'target_language_id' => $language1->id,
                'translation' => $word['en'],
            ]);
        }
    }
}
