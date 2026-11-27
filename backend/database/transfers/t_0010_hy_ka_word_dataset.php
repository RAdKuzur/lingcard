<?php
use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0010_hy_ka_word_dataset';
    public function up() {
        DB::table('languages')->where(['code' => 'hy'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'ka'])->update(['is_active' => true]);

        $availableCodes = [
            'ru' => ['hy', 'ka'],
            'hy' => ['ru'],
            'ka' => ['ru'],
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

        Artisan::call("app:transform-jsonl-data-command --base=ka --target=ru");
        Artisan::call("app:transform-jsonl-data-command --base=ru --target=ka");

        Artisan::call("app:transform-jsonl-data-command --base=hy --target=ru");
        Artisan::call("app:transform-jsonl-data-command --base=ru --target=hy");
    }
};
