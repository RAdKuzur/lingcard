<?php
use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0008_baltic_word_dataset';
    public function up() {
        DB::table('languages')->where(['code' => 'ee'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'lv'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'lt'])->update(['is_active' => true]);

        $availableCodes = [
            'ru' => ['ee', 'lv', 'lt'],
            'ee' => ['ru'],
            'lv' => ['ru'],
            'lt' => ['ru']
        ];

        foreach ($availableCodes as $code => $languages) {
            $baseLanguage = DB::table('languages')->where('code', $code)->first();
            foreach ($languages as $language) {
                $targetLanguage = DB::table('languages')->where('code', $language)->first();
                DB::table('available_languages')->insert([
                    'base_language_id' =>  $baseLanguage->id,
                    'target_language_id' => $targetLanguage->id
                ]);
            }
        }

        Artisan::call("app:transform-jsonl-data-command --base=ee --target=ru");
        Artisan::call("app:transform-jsonl-data-command --base=ru --target=ee");

        Artisan::call("app:transform-jsonl-data-command --base=lv --target=ru");
        Artisan::call("app:transform-jsonl-data-command --base=ru --target=lv");

        Artisan::call("app:transform-jsonl-data-command --base=lt --target=ru");
        Artisan::call("app:transform-jsonl-data-command --base=ru --target=lt");
    }
};
