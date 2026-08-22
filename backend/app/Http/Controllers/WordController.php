<?php

namespace App\Http\Controllers;

use App\Services\WordService;

class WordController extends Controller
{
    public WordService $wordService;
    public function __construct(
        WordService $wordService
    )
    {
        $this->wordService = $wordService;
    }
    public function package($code) {
        return $this->wordService->downloadPackage($code);
    }
}
