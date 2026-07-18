<?php

namespace Database\Seeders;

use App\Dictionaries\LevelDictionary;
use App\Dictionaries\RoleDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('words')->truncate();
        DB::table('word_translations')->truncate();
        DB::table('courses')->truncate();
        Artisan::call('app:kz-ru-word-command');
        Artisan::call('app:en-ru-word-command');
        Artisan::call('app:en-kz-word-command');
    }
}
