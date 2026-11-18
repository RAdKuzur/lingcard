<?php


use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0004_init_word_am_ge_dataset';
    public function up() {
        DB::table('languages')->where(['code' => 'am'])->update(['is_active' => true]);
        DB::table('languages')->where(['code' => 'ge'])->update(['is_active' => true]);

        $availableCodes = [
            'en' => ['am', 'ge'],
            'ge' => ['en'],
            'am' => ['en'],
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

        Artisan::call("app:transform-jsonl-data-command --base=am --target=en");
        Artisan::call("app:transform-jsonl-data-command --base=en --target=am");
        Artisan::call("app:transform-jsonl-data-command --base=ge --target=en");
        Artisan::call("app:transform-jsonl-data-command --base=en --target=ge");
    }
};
