<?php

namespace App\Services;

use App\Dictionaries\RoleDictionary;
use App\Dictionaries\StatusDictionary;
use App\DTO\ProfileDTO;
use App\DTO\ProfileUpdateDTO;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private CourseRepositoryInterface $courseRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
        CourseRepositoryInterface $courseRepository
    ) {
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
    }

    public function profile() : array
    {
        $user = AuthHelper::user();

        return (new ProfileDTO(
            username: $user->name,
            role: RoleDictionary::get($user->role),
            baseLanguageId: $user->base_language_id,
            targetLanguageId: $user->target_language_id,
            noneWords: $this->courseRepository->countUserStats($user->id, StatusDictionary::NONE),
            learningWords: $this->courseRepository->countUserStats($user->id, StatusDictionary::LEARNING),
            learnedWords: $this->courseRepository->countUserStats($user->id, StatusDictionary::LEARNED),
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
