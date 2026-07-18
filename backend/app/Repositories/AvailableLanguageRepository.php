<?php

namespace App\Repositories;

use App\Models\AvailableLanguage;
use App\Repositories\Interfaces\AvailableLanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AvailableLanguageRepository implements AvailableLanguageRepositoryInterface
{
    public function all() {
        return AvailableLanguage::all();
    }
    public function find($id) {
        return AvailableLanguage::find($id);
    }
    public function findByBaseLanguageId($baseLanguageId) {
        return AvailableLanguage::with('targetLanguage')->where(['base_language_id' => $baseLanguageId])->get();
    }
    public function insert($data) : bool {
        return DB::table('available_languages')->insert($data);
    }
    public function update($id , $data) : int {
        return DB::table('available_languages')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('available_languages')->where('id', $id)->delete();
    }

}
