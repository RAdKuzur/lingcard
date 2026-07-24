<?php

namespace App\Http\Controllers;

use App\Services\NewsService;

class NewsController extends Controller
{
    private NewsService $newsService;
    public function __construct(
        NewsService $newsService
    )
    {
        $this->newsService = $newsService;
    }

    public function all($code = 'ru')
    {
        $data = $this->newsService->newsByCode($code);
        return response()->json([
            'data' => $data
        ]);
    }
    public function one($id)
    {
        $data = $this->newsService->one($id);
        return response()->json([
            'data' => $data
        ]);
    }
}
