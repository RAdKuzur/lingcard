<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuggestionRequest;
use App\Services\SuggestionService;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    private SuggestionService $suggestionService;
    public function __construct(
        SuggestionService $suggestionService
    )
    {
        $this->suggestionService = $suggestionService;
    }

    public function create(SuggestionRequest $request) {
        $dto = $request->toDTO();
        $this->suggestionService->create($dto);
        return response()->json([
            'success' => true
        ]);
    }
}
