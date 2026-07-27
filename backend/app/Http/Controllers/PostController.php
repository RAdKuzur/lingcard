<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
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

    public function createComment(CommentRequest $request, $postId)
    {
        $this->postService->createComment($request->toDTO(), $postId);
        return response()->json([
            'success' => true
        ]);
    }
    public function create(PostRequest $request)
    {
        $dto = $request->toDTO();
        $this->postService->create($dto);
        return response()->json([
            'success' => true
        ]);
    }
}
