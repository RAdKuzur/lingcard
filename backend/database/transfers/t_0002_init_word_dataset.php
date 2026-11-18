<?php


use Illuminate\Support\Facades\Artisan;

return new class {
    public const string NAME = 't_0002_init_word_dataset';
    public function up() {
        $codes = [
            'ru' => ['kz', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'kz' => ['ru', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'en' => ['ru', 'kz', 'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'fr' => ['ru', 'kz', 'en' ,'cn', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'cn' => ['ru', 'kz', 'en' ,'fr', 'de', 'es', 'jp', 'kr', 'pt', 'sa'],
            'de' => ['ru', 'kz', 'en' ,'fr', 'cn', 'es', 'jp', 'kr', 'pt', 'sa'],
            'es' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'jp', 'kr', 'pt', 'sa'],
            'jp' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'es', 'kr', 'pt', 'sa'],
            'kr' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'pt', 'sa'],
            'pt' => ['ru', 'kz', 'en' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'sa'],
            'sa' => ['ru', 'kz' ,'fr', 'cn', 'de', 'es', 'jp', 'kr', 'pt']
        ];
        foreach ($codes as $code => $languages) {
            foreach ($languages as $language) {
                Artisan::call("app:transform-jsonl-data-command --base={$code} --target={$language}");
            }
        }
    }
};
