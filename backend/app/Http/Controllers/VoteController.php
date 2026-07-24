<?php

namespace App\Http\Controllers;

use App\Services\VoteService;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    private VoteService $voteService;
    public function __construct(
        VoteService $voteService
    )
    {
        $this->voteService = $voteService;
    }
    public function all()
    {
        $data = $this->voteService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function one($id)
    {
        $data = $this->voteService->one($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function vote($voteOptionId) {
        $this->voteService->vote($voteOptionId);
        return response()->json([
            'success' => true
        ]);
    }
    public function cancelVote($voteOptionId) {
        $this->voteService->cancelVote($voteOptionId);
        return response()->json([
            'success' => true
        ]);
    }
}
