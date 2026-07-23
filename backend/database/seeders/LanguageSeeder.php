<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->truncate();
        DB::table('languages')->insert([
            'name' => 'Русский',
            'code' => 'ru',
            'is_active' => true
        ]);
        DB::table('languages')->insert([
            'name' => 'Қазақша',
            'code' => 'kz',
            'is_active' => true
        ]);
        DB::table('languages')->insert([
            'name' => 'English',
            'code' => 'en',
            'is_active' => true
        ]);

        DB::table('languages')->insert([
            'name' => 'Español',
            'code' => 'es',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Français',
            'code' => 'fr',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Deutsch',
            'code' => 'de',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Italiano',
            'code' => 'it',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Português',
            'code' => 'pt',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Nederlands',
            'code' => 'nl',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Polski',
            'code' => 'pl',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Українська',
            'code' => 'ua',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => '中文',
            'code' => 'cn',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => '日本語',
            'code' => 'jp',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => '한국어',
            'code' => 'kr',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'العربية',
            'code' => 'sa',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'हिन्दी',
            'code' => 'in',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Türkçe',
            'code' => 'tr',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Tiếng Việt',
            'code' => 'vn',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'ไทย',
            'code' => 'th',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Bahasa Indonesia',
            'code' => 'id',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Suomi',
            'code' => 'fi',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Svenska',
            'code' => 'se',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Norsk',
            'code' => 'no',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Dansk',
            'code' => 'dk',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Čeština',
            'code' => 'cz',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Magyar',
            'code' => 'hu',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Română',
            'code' => 'ro',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Slovenčina',
            'code' => 'sk',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Ελληνικά',
            'code' => 'gr',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'עברית',
            'code' => 'il',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'فارسی',
            'code' => 'ir',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'اردو',
            'code' => 'pk',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Монгол',
            'code' => 'mn',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'ქართული',
            'code' => 'ge',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Հայերեն',
            'code' => 'am',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Azərbaycan dili',
            'code' => 'az',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Oʻzbekcha',
            'code' => 'uz',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Тоҷикӣ',
            'code' => 'tj',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Кыргызча',
            'code' => 'kg',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Latviešu',
            'code' => 'lv',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Lietuvių',
            'code' => 'lt',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Eesti',
            'code' => 'ee',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Shqip',
            'code' => 'al',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Македонски',
            'code' => 'mk',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Српски',
            'code' => 'rs',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Hrvatski',
            'code' => 'hr',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Bosanski',
            'code' => 'ba',
            'is_active' => false
        ]);
    }
}
