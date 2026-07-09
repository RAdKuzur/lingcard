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
        $page = request()->query('page');
        $limit = request()->query('limit');
        $search = request()->query('search');
        $data = $this->wordTranslationService->dictionary($baseTrainingId, $targetLanguageId, $page, $limit, $search);
        return response()->json([
            'success' => true,
            'data' => $data['data'],
            'amountWords' => $data['amountWords']
        ]);
    }
}
