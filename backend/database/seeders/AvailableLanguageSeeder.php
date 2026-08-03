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
        // ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa']
        $availableCodes = [
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
