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
            'code' => 'uk',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => '中文',
            'code' => 'zh',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => '日本語',
            'code' => 'ja',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => '한국어',
            'code' => 'ko',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'العربية',
            'code' => 'ar',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'हिन्दी',
            'code' => 'hi',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Türkçe',
            'code' => 'tr',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Tiếng Việt',
            'code' => 'vi',
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
            'code' => 'sv',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Norsk',
            'code' => 'no',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Dansk',
            'code' => 'da',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Čeština',
            'code' => 'cs',
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
            'code' => 'el',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'עברית',
            'code' => 'he',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'فارسی',
            'code' => 'fa',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'اردو',
            'code' => 'ur',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Монгол',
            'code' => 'mn',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'ქართული',
            'code' => 'ka',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Հայերեն',
            'code' => 'hy',
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
            'code' => 'tg',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Кыргызча',
            'code' => 'ky',
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
            'code' => 'et',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Shqip',
            'code' => 'sq',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Македонски',
            'code' => 'mk',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Српски',
            'code' => 'sr',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Hrvatski',
            'code' => 'hr',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Bosanski',
            'code' => 'bs',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Slovenščina',
            'code' => 'sl',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Galego',
            'code' => 'gl',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Euskara',
            'code' => 'eu',
            'is_active' => false
        ]);
        DB::table('languages')->insert([
            'name' => 'Català',
            'code' => 'ca',
            'is_active' => false
        ]);
    }
}
