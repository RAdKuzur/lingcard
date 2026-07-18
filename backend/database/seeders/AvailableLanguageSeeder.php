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
        $ruLanguage = DB::table('languages')->where('code', 'ru')->first();
        $kzLanguage = DB::table('languages')->where('code', 'kz')->first();
        $enLanguage = DB::table('languages')->where('code', 'en')->first();

        //ru-kz
        DB::table('available_languages')->insert([
            'base_language_id' => $ruLanguage->id,
            'target_language_id' => $kzLanguage->id,
        ]);
        DB::table('available_languages')->insert([
            'base_language_id' => $kzLanguage->id,
            'target_language_id' => $ruLanguage->id,
        ]);

        //en-ru
        DB::table('available_languages')->insert([
            'base_language_id' => $enLanguage->id,
            'target_language_id' => $ruLanguage->id,
        ]);
        DB::table('available_languages')->insert([
            'base_language_id' => $ruLanguage->id,
            'target_language_id' => $enLanguage->id,
        ]);

        //en-kz
        DB::table('available_languages')->insert([
            'base_language_id' => $enLanguage->id,
            'target_language_id' => $kzLanguage->id,
        ]);
        DB::table('available_languages')->insert([
            'base_language_id' => $kzLanguage->id,
            'target_language_id' => $enLanguage->id,
        ]);
    }
}
