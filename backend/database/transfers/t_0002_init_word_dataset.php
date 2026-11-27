<?php


use Illuminate\Support\Facades\Artisan;

return new class {
    public const string NAME = 't_0002_init_word_dataset';
    public function up() {
        $codes = [
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
        foreach ($codes as $code => $languages) {
            foreach ($languages as $language) {
                Artisan::call("app:transform-jsonl-data-command --base={$code} --target={$language}");
            }
        }
    }
};
