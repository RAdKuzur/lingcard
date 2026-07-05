<?php

namespace App\Services;

use App\Dictionaries\LevelDictionary;
use App\Dictionaries\StatusDictionary;
use App\DTO\WordProgressDTO;
use App\DTO\WordTrainingDTO;
use App\Helpers\AuthHelper;
use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Repositories\WordTranslationRepository;

class CourseService
{
    private CourseRepository $courseRepository;
    private WordTranslationRepository $wordTranslationRepository;
    public function __construct(
        CourseRepository $courseRepository,
        WordTranslationRepository $wordTranslationRepository
    )
    {
        $this->courseRepository = $courseRepository;
        $this->wordTranslationRepository = $wordTranslationRepository;
    }

    public function wordsByStatus($status) {
        $data = [];
        $courses = $this->courseRepository->getByStatus($status);
        foreach ($courses as $course) {
            $data[] = (new WordProgressDTO(
                id: $course->id,
                text: $course->wordTranslation->word->text,
                translation: $course->wordTranslation->translation,
                level: LevelDictionary::get($course->wordTranslation->word->level),
                repeatTime: $course->last_time_repeated
            ))->toArray();
        }
        return $data;
    }
    public function clearProgress()
    {
        $user = AuthHelper::user();
        $this->courseRepository->deleteProgress($user->id);
    }

    public function init() {
        $user = AuthHelper::user();
        $wordTranslations = $this->wordTranslationRepository->getByTargetLanguageIdAndBaseLanguageId($user->base_language_id, $user->target_language_id);
        foreach ($wordTranslations as $wordTranslation) {
            $this->courseRepository->insert([
                'word_translation_id' => $wordTranslation->translation_id,
                'repeat' => 0,
                'status' => StatusDictionary::NONE,
                'user_id' => $user->id,
                'last_time_repeated' => now()
            ]);
        }
    }

    public function newWord() {

        $user = AuthHelper::user();
        $course = $this->courseRepository->getOldLearningWords($user->id);
        if($course) {
            $data = (new WordTrainingDTO(
                id: $course->id,
                text: $course->wordTranslation->word->text,
                translation: $course->wordTranslation->translation,
                level: LevelDictionary::get($course->wordTranslation->word->level),
                status: $course->status
            ))->toArray();
            return $data;
        }
        return null;
    }

    public function repeat($id, $status) {
        $course = $this->courseRepository->getById($id);
        if ($status) {
            switch ($course->status) {
                case StatusDictionary::NONE:
                    $this->courseRepository->update($id, [
                        'repeat' => $course->repeat + 1,
                        'status' => StatusDictionary::LEARNED,
                        'last_time_repeated' => now()
                    ]);
                    break;
                case StatusDictionary::LEARNING:
                    $this->courseRepository->update($id, [
                        'repeat' => $course->repeat + 1,
                        'status' => $course->repeat + 1 > Course::REPEAT_TIME ? StatusDictionary::LEARNED : StatusDictionary::LEARNING,
                        'last_time_repeated' => now()
                    ]);
                    break;
                default:
                    break;
            }
        }
        else {
            switch ($course->status) {
                case StatusDictionary::NONE:
                    $this->courseRepository->update($id, [
                        'status' => StatusDictionary::LEARNING,
                        'last_time_repeated' => now()
                    ]);
                    break;
                default:
                    break;
            }
        }
    }

}
