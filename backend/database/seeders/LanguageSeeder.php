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
            ['name' => 'Русский', 'code' => 'ru', 'is_active' => true],
            ['name' => 'Қазақша', 'code' => 'kz', 'is_active' => true],
            ['name' => 'English', 'code' => 'en', 'is_active' => true],
            ['name' => 'Español', 'code' => 'es', 'is_active' => true],
            ['name' => 'Français', 'code' => 'fr', 'is_active' => true],
            ['name' => 'Deutsch', 'code' => 'de', 'is_active' => true],
            ['name' => 'Italiano', 'code' => 'it', 'is_active' => false],
            ['name' => 'Português', 'code' => 'pt', 'is_active' => true],
            ['name' => 'Nederlands', 'code' => 'nl', 'is_active' => false],
            ['name' => 'Polski', 'code' => 'pl', 'is_active' => false],
            ['name' => 'Українська', 'code' => 'ua', 'is_active' => false],
            ['name' => '中文', 'code' => 'cn', 'is_active' => true],
            ['name' => '日本語', 'code' => 'jp', 'is_active' => true],
            ['name' => '한국어', 'code' => 'kr', 'is_active' => true],
            ['name' => 'العربية', 'code' => 'sa', 'is_active' => true],
            ['name' => 'हिन्दी', 'code' => 'in', 'is_active' => false],
            ['name' => 'Türkçe', 'code' => 'tr', 'is_active' => false],
            ['name' => 'Tiếng Việt', 'code' => 'vn', 'is_active' => false],
            ['name' => 'ไทย', 'code' => 'th', 'is_active' => false],
            ['name' => 'Bahasa Indonesia', 'code' => 'id', 'is_active' => false],
            ['name' => 'Suomi', 'code' => 'fi', 'is_active' => false],
            ['name' => 'Svenska', 'code' => 'se', 'is_active' => false],
            ['name' => 'Norsk', 'code' => 'no', 'is_active' => false],
            ['name' => 'Dansk', 'code' => 'dk', 'is_active' => false],
            ['name' => 'Čeština', 'code' => 'cz', 'is_active' => false],
            ['name' => 'Magyar', 'code' => 'hu', 'is_active' => false],
            ['name' => 'Română', 'code' => 'ro', 'is_active' => false],
            ['name' => 'Slovenčina', 'code' => 'sk', 'is_active' => false],
            ['name' => 'Ελληνικά', 'code' => 'gr', 'is_active' => false],
            ['name' => 'עברית', 'code' => 'il', 'is_active' => false],
            ['name' => 'فارسی', 'code' => 'ir', 'is_active' => false],
            ['name' => 'اردو', 'code' => 'pk', 'is_active' => false],
            ['name' => 'Монгол', 'code' => 'mn', 'is_active' => false],
            ['name' => 'ქართული', 'code' => 'ge', 'is_active' => false],
            ['name' => 'Հայերեն', 'code' => 'am', 'is_active' => false],
            ['name' => 'Azərbaycan dili', 'code' => 'az', 'is_active' => false],
            ['name' => 'Oʻzbekcha', 'code' => 'uz', 'is_active' => false],
            ['name' => 'Тоҷикӣ', 'code' => 'tj', 'is_active' => false],
            ['name' => 'Кыргызча', 'code' => 'kg', 'is_active' => false],
            ['name' => 'Latviešu', 'code' => 'lv', 'is_active' => false],
            ['name' => 'Lietuvių', 'code' => 'lt', 'is_active' => false],
            ['name' => 'Eesti', 'code' => 'ee', 'is_active' => false],
            ['name' => 'Shqip', 'code' => 'al', 'is_active' => false],
            ['name' => 'Македонски', 'code' => 'mk', 'is_active' => false],
            ['name' => 'Српски', 'code' => 'rs', 'is_active' => false],
            ['name' => 'Hrvatski', 'code' => 'hr', 'is_active' => false],
            ['name' => 'Bosanski', 'code' => 'ba', 'is_active' => false],
        ]);
    }
}
