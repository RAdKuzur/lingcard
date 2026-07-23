<?php

namespace Database\Seeders;

use App\Dictionaries\StatusWordDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->truncate();
        $user = DB::table('users')->first();
        $wordTranslations = DB::table('word_translations')->get();
        foreach ($wordTranslations as $wordTranslation) {
            DB::table('courses')->insert([
                'word_translation_id' => $wordTranslation->id,
                'user_id' => $user->id,
                'status' => StatusWordDictionary::NONE,
                'repeat' => 0,
                'last_time_repeated' => now()
            ]);
        }
    }
}
