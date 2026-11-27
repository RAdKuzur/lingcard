<?php


use App\Dictionaries\RoleDictionary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class {
    public const string NAME = 't_0003_init_user_dataset';
    public function up() {
        DB::table('users')->insert([
            'email' => 'drive16052003@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'LingCard',
            'base_language_id' => DB::table('languages')->where('code', 'ru')->first()->id,
            'target_language_id' => DB::table('languages')->where('code', 'kk')->first()->id,
            'role' => RoleDictionary::ADMIN,
            'is_banned' => false
        ]);
    }
};
