<?php


use App\Dictionaries\StatusPostDictionary;
use Illuminate\Support\Facades\DB;

return new class {
    public const string NAME = 't_0006_init_book_dataset';
    public function up() {
        Artisan::call("app:transform-books-command --name=abai_kara_sozder");
    }
};
