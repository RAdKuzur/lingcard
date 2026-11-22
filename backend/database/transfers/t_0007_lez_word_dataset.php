<?php
use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0007_lez_word_dataset';
    public function up() {
        DB::table('languages')->insert([
            'name' => 'Лезги чӏал',
            'code' => 'lez',
            'is_active' => true
        ]);

        $availableCodes = [
            'ru' => ['lez'],
            'lez' => ['ru'],
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

        Artisan::call("app:transform-jsonl-data-command --base=ru --target=lez");
        Artisan::call("app:transform-jsonl-data-command --base=lez --target=ru");
    }
};
