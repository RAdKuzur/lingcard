<?php

namespace Tests\Unit;

use App\Dictionaries\RoleDictionary;
use App\Dictionaries\StatusWordDictionary;
use App\Models\Course;
use App\Models\User;
use App\Repositories\CourseRepository;
use App\Repositories\WordTranslationRepository;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\TestCourseSeeder;
use Database\Seeders\TestUserSeeder;
use Database\Seeders\TestWordSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TrainingTest extends TestCase
{
    use RefreshDatabase;
    public function test_init_courses(): void
    {
        $this->seed(LanguageSeeder::class);
        $this->seed(TestWordSeeder::class);
        $this->seed(TestUserSeeder::class);

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

        $this->assertEquals(count(Course::all()), 5);
    }

    public function test_clear_progress(): void
    {
        $this->seed(LanguageSeeder::class);
        $this->seed(TestWordSeeder::class);
        $this->seed(TestUserSeeder::class);
        $this->seed(TestCourseSeeder::class);
        $user = User::where(['email' => 'drive16052003@gmail.com'])->first();
        (new CourseRepository())->deleteProgress($user->id);
        $this->assertEquals(count(Course::all()), 0);
    }
}
