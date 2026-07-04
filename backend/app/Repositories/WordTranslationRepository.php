<?php

namespace App\Repositories;

use App\Models\WordTranslation;

class WordTranslationRepository
{
    public function getAll() {
        return WordTranslation::all();
    }
    public function getAllWithWords() {
        return WordTranslation::with('word')->get();
    }

    public function getByTargetLanguageIdAndBaseLanguageId( $baseLanguageId, $targetLanguageId) {
        return WordTranslation::with('word')
            ->join('words', 'word_translations.word_id', '=', 'words.id')
            ->where('word_translations.target_language_id', $targetLanguageId)
            ->where('words.language_id', $baseLanguageId)
            ->get();
    }
}
