<?php

namespace App\Repositories;

use App\Models\WordTranslation;
use App\Repositories\Interfaces\WordTranslationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class WordTranslationRepository implements WordTranslationRepositoryInterface
{
    public function all() {
        return WordTranslation::all();
    }
    public function find($id) {
        return WordTranslation::find($id);
    }
    public function insert($data) : bool {
        return DB::table('word_translations')->insert($data);
    }

    public function update($id, $data) : int {
        return DB::table('word_translations')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('word_translations')->where('id', $id)->delete();
    }
    public function getAllWithWords() {
        return WordTranslation::with('word')->get();
    }

    public function getByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId) {
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
