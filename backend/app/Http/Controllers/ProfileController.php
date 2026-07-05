<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    private UserService $userService;
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function profile()
    {
        $profile = $this->userService->profile();
        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    public function update(ProfileUpdateRequest $request) {
        $dto = $request->toDTO();
        $this->userService->update(AuthHelper::user()->id, $dto);
        return response()->json([
            'success' => true,
        ]);
    }
}
