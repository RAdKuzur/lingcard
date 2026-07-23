<?php

namespace App\Http\Controllers;

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
}
