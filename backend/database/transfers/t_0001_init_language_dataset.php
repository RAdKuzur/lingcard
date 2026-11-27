
<?php

use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0001_init_language_dataset';

    public function up()
    {
        DB::table('languages')->insert([
            ['name' => 'Русский', 'code' => 'ru', 'is_active' => true],
            ['name' => 'Қазақша', 'code' => 'kk', 'is_active' => true],
            ['name' => 'English', 'code' => 'en', 'is_active' => true],
            ['name' => 'Español', 'code' => 'es', 'is_active' => true],
            ['name' => 'Français', 'code' => 'fr', 'is_active' => true],
            ['name' => 'Deutsch', 'code' => 'de', 'is_active' => true],
            ['name' => 'Italiano', 'code' => 'it', 'is_active' => false],
            ['name' => 'Português', 'code' => 'pt', 'is_active' => true],
            ['name' => 'Nederlands', 'code' => 'nl', 'is_active' => false],
            ['name' => 'Polski', 'code' => 'pl', 'is_active' => false],
            ['name' => 'Українська', 'code' => 'uk', 'is_active' => false],
            ['name' => '中文', 'code' => 'zh', 'is_active' => true],
            ['name' => '日本語', 'code' => 'ja', 'is_active' => true],
            ['name' => '한국어', 'code' => 'ko', 'is_active' => true],
            ['name' => 'العربية', 'code' => 'ar', 'is_active' => true],
            ['name' => 'हिन्दी', 'code' => 'hi', 'is_active' => false],
            ['name' => 'Türkçe', 'code' => 'tr', 'is_active' => false],
            ['name' => 'Tiếng Việt', 'code' => 'vi', 'is_active' => false],
            ['name' => 'ไทย', 'code' => 'th', 'is_active' => false],
            ['name' => 'Bahasa Indonesia', 'code' => 'id', 'is_active' => false],
            ['name' => 'Suomi', 'code' => 'fi', 'is_active' => false],
            ['name' => 'Svenska', 'code' => 'sv', 'is_active' => false],
            ['name' => 'Norsk', 'code' => 'no', 'is_active' => false],
            ['name' => 'Dansk', 'code' => 'da', 'is_active' => false],
            ['name' => 'Čeština', 'code' => 'cs', 'is_active' => false],
            ['name' => 'Magyar', 'code' => 'hu', 'is_active' => false],
            ['name' => 'Română', 'code' => 'ro', 'is_active' => false],
            ['name' => 'Slovenčina', 'code' => 'sk', 'is_active' => false],
            ['name' => 'Ελληνικά', 'code' => 'el', 'is_active' => false],
            ['name' => 'עברית', 'code' => 'he', 'is_active' => false],
            ['name' => 'فارسی', 'code' => 'fa', 'is_active' => false],
            ['name' => 'اردو', 'code' => 'ur', 'is_active' => false],
            ['name' => 'Монгол', 'code' => 'mn', 'is_active' => false],
            ['name' => 'ქართული', 'code' => 'ka', 'is_active' => false],
            ['name' => 'Հայերեն', 'code' => 'hy', 'is_active' => false],
            ['name' => 'Azərbaycan dili', 'code' => 'az', 'is_active' => false],
            ['name' => 'Oʻzbekcha', 'code' => 'uz', 'is_active' => false],
            ['name' => 'Тоҷикӣ', 'code' => 'tg', 'is_active' => false],
            ['name' => 'Кыргызча', 'code' => 'ky', 'is_active' => false],
            ['name' => 'Latviešu', 'code' => 'lv', 'is_active' => false],
            ['name' => 'Lietuvių', 'code' => 'lt', 'is_active' => false],
            ['name' => 'Eesti', 'code' => 'et', 'is_active' => false],
            ['name' => 'Shqip', 'code' => 'sq', 'is_active' => false],
            ['name' => 'Македонски', 'code' => 'mk', 'is_active' => false],
            ['name' => 'Српски', 'code' => 'sr', 'is_active' => false],
            ['name' => 'Hrvatski', 'code' => 'hr', 'is_active' => false],
            ['name' => 'Bosanski', 'code' => 'bs', 'is_active' => false],
        ]);

        $availableCodes = [
            'ru' => ['kk', 'en', 'fr', 'zh', 'de', 'es', 'ja', 'ko', 'pt', 'ar'],
            'kk' => ['ru', 'en', 'fr', 'zh', 'de', 'es', 'ja', 'ko', 'pt', 'ar'],
            'en' => ['ru', 'kk', 'fr', 'zh', 'de', 'es', 'ja', 'ko', 'pt', 'ar'],
            'fr' => ['ru', 'kk', 'en', 'zh', 'de', 'es', 'ja', 'ko', 'pt', 'ar'],
            'zh' => ['ru', 'kk', 'en', 'fr', 'de', 'es', 'ja', 'ko', 'pt', 'ar'],
            'de' => ['ru', 'kk', 'en', 'fr', 'zh', 'es', 'ja', 'ko', 'pt', 'ar'],
            'es' => ['ru', 'kk', 'en', 'fr', 'zh', 'de', 'ja', 'ko', 'pt', 'ar'],
            'ja' => ['ru', 'kk', 'en', 'fr', 'zh', 'de', 'es', 'ko', 'pt', 'ar'],
            'ko' => ['ru', 'kk', 'en', 'fr', 'zh', 'de', 'es', 'ja', 'pt', 'ar'],
            'pt' => ['ru', 'kk', 'en', 'fr', 'zh', 'de', 'es', 'ja', 'ko', 'ar'],
            'ar' => ['ru', 'kk', 'fr', 'zh', 'de', 'es', 'ja', 'ko', 'pt'],
        ];
        foreach ($availableCodes as $code => $languages) {
            $baseLanguage = DB::table('languages')
                ->where('code', $code)
                ->first();

            foreach ($languages as $language) {
                $targetLanguage = DB::table('languages')
                    ->where('code', $language)
                    ->first();
                DB::table('available_languages')->insert([
                    'base_language_id' => $baseLanguage->id,
                    'target_language_id' => $targetLanguage->id,
                ]);
            }
        }
    }
};
