<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailableLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('available_languages')->truncate();
        $availableCodes = [
            'ru' => ['en', 'kz' , 'fr'],
            'kz' => ['en', 'ru' , 'fr'],
            'en' => ['ru', 'kz' , 'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'fr' => ['en', 'kz' , 'ru'],
            'cn' => ['en'],
            'de' => ['en'],
            'es' => ['en'],
            'jp' => ['en'],
            'kr' => ['en'],
            'pt' => ['en'],
            'sa' => ['en']
        ];
        foreach ($availableCodes as $code => $languages) {
            $baseLanguage = DB::table('languages')->where('code', $code)->first();
            foreach ($languages as $language) {
                $targetLanguage = DB::table('languages')->where('code', $language)->first();
                DB::table('available_languages')->insert([
                    'base_language_id' =>  $baseLanguage->id,
                    'target_language_id' => $targetLanguage->id
                ]);
            }
        }
    }
}
