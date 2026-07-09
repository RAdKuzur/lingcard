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
            ->select('word_translations.*', 'word_translations.id as translation_id')
            ->get();
    }
    public function getPaginateByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId, $page = 1, $limit = 10, $search = '') {
        return WordTranslation::with('word')
            ->join('words', 'word_translations.word_id', '=', 'words.id')
            ->where('word_translations.target_language_id', $targetLanguageId)
            ->where('words.language_id', $baseLanguageId)
            ->where('words.text', 'LIKE', '%' . $search . '%')
            ->select('word_translations.*', 'word_translations.id as translation_id')
            ->paginate($limit, ['*'], 'page', $page);
    }
    public function countByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId, $search = '') {
        return WordTranslation::with('word')
            ->join('words', 'word_translations.word_id', '=', 'words.id')
            ->where('word_translations.target_language_id', $targetLanguageId)
            ->where('words.language_id', $baseLanguageId)
            ->where('words.text', 'LIKE', '%' . $search . '%')
            ->select('word_translations.*', 'word_translations.id as translation_id')
            ->count();
    }
}
