<?php

namespace App\Http\Controllers;

use App\Services\WordTranslationService;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    private WordTranslationService $wordTranslationService;
    public function __construct(
        WordTranslationService $wordTranslationService
    )
    {
        $this->wordTranslationService = $wordTranslationService;
    }

    public function translate($baseTrainingId, $targetLanguageId) {

        $data = $this->wordTranslationService->dictionary($baseTrainingId, $targetLanguageId);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
