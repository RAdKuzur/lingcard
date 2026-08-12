<?php

namespace App\Services;

use App\Dictionaries\RoleDictionary;
use App\Dictionaries\StatusWordDictionary;
use App\DTO\ProfileDTO;
use App\DTO\ProfileUpdateDTO;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WordTranslationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private CourseRepositoryInterface $courseRepository;
    private WordTranslationRepositoryInterface $wordTranslationRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
        CourseRepositoryInterface $courseRepository,
        WordTranslationRepositoryInterface $wordTranslationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->wordTranslationRepository = $wordTranslationRepository;
    }

    public function profile() : array
    {
        $user = AuthHelper::user();
        $courses = $this->courseRepository->getCoursesByStatus($user->id, [StatusWordDictionary::LEARNING, StatusWordDictionary::LEARNED]);
        $wordTranslations = $this->wordTranslationRepository->getNewWords($user->base_language_id, $user->target_language_id, array_column($courses->toArray(), 'word_translation_id'));
        return (new ProfileDTO(
            username: $user->name,
            role: RoleDictionary::get($user->role),
            baseLanguageId: $user->base_language_id,
            targetLanguageId: $user->target_language_id,
            noneWords: count($wordTranslations),
            learningWords: $this->courseRepository->countUserStats($user->id, StatusWordDictionary::LEARNING),
            learnedWords: $this->courseRepository->countUserStats($user->id, StatusWordDictionary::LEARNED),
        ))->toArray();
    }

    public function update($id, ProfileUpdateDTO $dto) : void
    {
        DB::beginTransaction();
        try {
            $this->userRepository->update($id, $dto->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }

    }
}
