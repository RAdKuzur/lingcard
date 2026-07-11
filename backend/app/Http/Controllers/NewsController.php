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

    public function all()
    {
        $data = $this->newsService->all();
        return response()->json([
            'data' => $data
        ]);
    }
}
