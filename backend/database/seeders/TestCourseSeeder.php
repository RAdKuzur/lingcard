<?php

namespace Database\Seeders;

use App\Dictionaries\StatusWordDictionary;
use App\Models\Course;
use App\Models\User;
use App\Repositories\WordTranslationRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where(['email' => 'drive16052003@gmail.com'])->first();
        $wordTranslations = (new WordTranslationRepository())->getByTargetLanguageIdAndBaseLanguageId($user->base_language_id, $user->target_language_id);
        $insertData = [];
        foreach ($wordTranslations as $index => $wordTranslation) {
            $insertData[] = [
                'word_translation_id' => $wordTranslation->translation_id,
                'repeat' => 0,
                'status' => StatusWordDictionary::NONE,
                'user_id' => $user->id,
                'last_time_repeated' => now()
            ];
            if (!empty($insertData) && $index % 500 === 0) {
                Course::insert($insertData);
                $insertData = [];
            }
        }
        if (!empty($insertData)) {
            Course::insert($insertData);
        }
    }
}
