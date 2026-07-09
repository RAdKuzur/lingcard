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
        $page = request()->query('page');
        $limit = request()->query('limit');
        $search = request()->query('search');
        $data = $this->courseService->wordsByStatus($status, $page, $limit, $search);

        return response()->json([
            'success' => true,
            'data' => $data['data'],
            'amountWords' => $data['amountWords']
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
        $status = $this->courseService->init();
        return response()->json([
            'success' => true,
            'data' => [
                'status' => $status
            ]
        ]);
    }
}
