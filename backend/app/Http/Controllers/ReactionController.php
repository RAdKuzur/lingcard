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

    public function like($postId) {
        $this->reactionService->like($postId);
        return response()->json([
            'success' => true
        ]);
    }

    public function dislike($postId) {
        $this->reactionService->dislike($postId);
        return response()->json([
            'success' => true
        ]);
    }

    public function unset($postId) {
        $this->reactionService->unset($postId);
        return response()->json([
            'success' => true
        ]);
    }
}
