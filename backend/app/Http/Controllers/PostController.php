<?php

namespace App\Http\Controllers;

use App\Services\PostService;

class PostController extends Controller
{
    private PostService $postService;
    public function __construct(
        PostService $postService
    )
    {
        $this->postService = $postService;
    }

    public function all($code = 'ru')
    {
        $data = $this->postService->postsByCode($code);
        return response()->json([
            'data' => $data
        ]);
    }
    public function one($id)
    {
        $data = $this->postService->one($id);
        return response()->json([
            'data' => $data
        ]);
    }
}
