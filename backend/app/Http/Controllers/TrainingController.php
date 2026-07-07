<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingRequest;
use App\Services\CourseService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    private CourseService $courseService;
    public function __construct(
        CourseService $courseService
    )
    {
        $this->courseService = $courseService;
    }

    public function newWord() {
        $data = $this->courseService->newWord();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function repeatWord(TrainingRequest $request, $id) {

        $this->courseService->repeat($id, $request->toStatus());
        return response()->json([
            'success' => true
        ]);
    }

    public function teachable()
    {
        $trainingStatus = $this->courseService->status();
        return response()->json([
            'success' => true,
            'data' => [
                'language' => $trainingStatus['language'],
                'training' => $trainingStatus['training']
            ]
        ]);
    }
}
