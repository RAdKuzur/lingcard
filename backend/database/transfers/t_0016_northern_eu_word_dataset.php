<?php
use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0016_northern_eu_word_dataset';
    public function up() {
        DB::table('languages')->where(['code' => 'da'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'fi'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'pl'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'sv'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'no'])->update(['is_active' => true]);


        $availableCodes = [
            'ru' => ['da', 'fi', 'pl', 'sv', 'no'],
            'da' => ['ru'],
            'fi' => ['ru'],
            'pl' => ['ru'],
            'sv' => ['ru'],
            'no' => ['ru'],
        ];

        foreach ($availableCodes as $code => $languages) {
            $baseLanguage = DB::table('languages')->where('code', $code)->first();

            foreach ($languages as $language) {
                $targetLanguage = DB::table('languages')->where('code', $language)->first();

                DB::table('available_languages')->insert([
                    'base_language_id' => $baseLanguage->id,
                    'target_language_id' => $targetLanguage->id
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
