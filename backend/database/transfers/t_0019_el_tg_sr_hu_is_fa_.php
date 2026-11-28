<?php
use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0019_el_tg_sr_hu_is_fa_word_dataset';
    public function up()
    {
        DB::table('languages')->where(['code' => 'el'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'tg'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'sr'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'hu'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'fa'])->update(['is_active' => true]);
        DB::table('languages')->insert(['name' => 'íslenska', 'code' => 'is', 'is_active' => true]);

        $availableCodes = [
            'ru' => ['el', 'tg', 'sr', 'hu', 'is', 'fa'],
            'el' => ['ru'],
            'tg' => ['ru'],
            'sr' => ['ru'],
            'hu' => ['ru'],
            'is' => ['ru'],
            'fa' => ['ru']
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
