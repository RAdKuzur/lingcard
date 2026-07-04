<?php

namespace App\Services;

use App\Dictionaries\RoleDictionary;
use App\DTO\ProfileDTO;
use App\Helpers\AuthHelper;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function profile()
    {
        $user = AuthHelper::user();
        return (new ProfileDTO(
            username: $user->name,
            role: RoleDictionary::get($user->role),
            baseLanguageId: $user->base_language_id,
            targetLanguageId: $user->target_language_id
        ))->toArray();
    }
}
