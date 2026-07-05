<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\CourseService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    private UserService $userService;
    private CourseService $courseService;
    public function __construct(
        UserService $userService,
        CourseService $courseService
    )
    {
        $this->userService = $userService;
        $this->courseService = $courseService;
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
        $this->courseService->clearProgress();
        $dto = $request->toDTO();
        $this->userService->update(AuthHelper::user()->id, $dto);
        $this->courseService->init();
        return response()->json([
            'success' => true,
        ]);
    }
}
