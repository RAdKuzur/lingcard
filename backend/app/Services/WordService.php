<?php

namespace App\Services;

class WordService
{
    public function downloadPackage($code) {
        $basePath = base_path("data/words/base/$code.jsonl");
        if (!file_exists($basePath)) {
            abort(404, 'File not found');
        }
        return response()
        ->download($basePath, $code . '.jsonl', [
            'Content-Type' => 'application/jsonlines',
        ]);
    }
}
