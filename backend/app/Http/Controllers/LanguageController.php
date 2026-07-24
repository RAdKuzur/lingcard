<?php

namespace App\Http\Controllers;

use App\Services\LanguageService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    private LanguageService $languageService;
    public function __construct(
        LanguageService $languageService
    )
    {
        $this->languageService = $languageService;
    }
    public function all() {
        $languages = $this->languageService->all();
        return response()->json([
            'success' => true,
            'data' => $languages
        ]);
    }
    public function allActive() {
        $languages = $this->languageService->allActive();
        return response()->json([
            'success' => true,
            'data' => $languages
        ]);
    }

    public function exceptLanguage($id) {
        $languages = $this->languageService->exceptLanguage($id);
        return response()->json([
            'success' => true,
            'data' => $languages
        ]);
    }
}
