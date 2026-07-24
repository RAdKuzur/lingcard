<?php

namespace App\Http\Controllers;

use App\Services\ReactionService;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    private ReactionService $reactionService;
    public function __construct(
        ReactionService $reactionService
    )
    {
        $this->reactionService = $reactionService;
    }

    public function like($newsId) {
        $this->reactionService->like($newsId);
        return response()->json([
            'success' => true
        ]);
    }

    public function dislike($newsId) {
        $this->reactionService->dislike($newsId);
        return response()->json([
            'success' => true
        ]);
    }

    public function unset($newsId) {
        $this->reactionService->unset($newsId);
        return response()->json([
            'success' => true
        ]);
    }
}
