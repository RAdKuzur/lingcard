<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    private CourseService $courseService;
    public function __construct(
        CourseService $courseService
    )
    {
        $this->courseService = $courseService;
    }

    public function progress($status) {
        $data = $this->courseService->wordsByStatus($status);
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function clearProgress() {
        $this->courseService->clearProgress();
        $this->courseService->init();
        return response()->json([
            'success' => true
        ]);
    }

    public function initProgress() {
        $this->courseService->init();
        return response()->json([
            'success' => true
        ]);
    }
}
