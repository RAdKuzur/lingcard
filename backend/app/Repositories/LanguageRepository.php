<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function all() {
        return Language::all();
    }
    public function find($id) {
        return Language::find($id);
    }
    public function insert($data) : bool {
        return DB::table('languages')->insert($data);
    }
    public function update($id, $data) : int {
        return DB::table('languages')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('languages')->where('id', $id)->delete();
    }
}
