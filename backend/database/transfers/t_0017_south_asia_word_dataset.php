<?php
use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0017_south_asia_word_dataset';
    public function up() {
        DB::table('languages')->where(['code' => 'th'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'vi'])->update(['is_active' => true]);
        DB::table('languages')->insert(['name' => 'বাংলা', 'code' => 'bn', 'is_active' => true]);

        $availableCodes = [
            'ru' => ['bn', 'th', 'vi'],
            'bn' => ['ru'],
            'th' => ['ru'],
            'vi' => ['ru'],
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
