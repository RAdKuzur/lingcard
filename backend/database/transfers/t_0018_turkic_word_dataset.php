<?php
use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0018_turkic_word_dataset';
    public function up()
    {
        $turkicCodes = [
            'az'  => 'Azərbaycanca',
            'ba'  => 'Башҡортса',
            'ky'  => 'Кыргызча',
            'tt'  => 'Татарча',
            'tyv' => 'Тыва дыл',
            'tr'  => 'Türkçe',
            'tk'  => 'Türkmençe',
            'ug'  => 'ئۇيغۇرچە',
            'cv'  => 'Чӑвашла',
            'sah' => 'Саха тыла',
        ];

        foreach ($turkicCodes as $code => $name) {
            $exists = DB::table('languages')->where('code', $code)->first();
            if ($exists) {
                DB::table('languages')->where('code', $code)->update(['is_active' => true]);
            } else {
                DB::table('languages')->insert([
                    'name'      => $name,
                    'code'      => $code,
                    'is_active' => true,
                ]);
            }
        }

        // Схема "звезда": ru <-> каждый тюркский, тюркские между собой НЕ связаны
        $availableCodes = [
            'ru' => array_keys($turkicCodes), // ru -> все 10 тюркских
        ];
        foreach (array_keys($turkicCodes) as $code) {
            $availableCodes[$code] = ['ru']; // каждый тюркский -> только ru
        }

        foreach ($availableCodes as $code => $languages) {
            $baseLanguage = DB::table('languages')->where('code', $code)->first();

            foreach ($languages as $language) {
                $targetLanguage = DB::table('languages')->where('code', $language)->first();

                DB::table('available_languages')->insert([
                    'base_language_id'   => $baseLanguage->id,
                    'target_language_id' => $targetLanguage->id,
                ]);
            }
        }

        foreach ($availableCodes as $code => $languages) {
            foreach ($languages as $language) {
                Artisan::call("app:transform-jsonl-data-command --base={$code} --target={$language}");
            }
        }
    }
};
