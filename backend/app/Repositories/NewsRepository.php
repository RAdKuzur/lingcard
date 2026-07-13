<?php

namespace App\Repositories;

use App\Models\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class NewsRepository implements NewsRepositoryInterface
{
    public function all() {
        return News::all();
    }
    public function allSorted() {
        return News::orderBy('date', 'asc')->get();
    }
    public function find($id) {
        return News::find($id);
    }
    public function findByLangId($langId) {
        return News::where(['language_id' => $langId])->orderBy('date', 'asc')->get();
    }
    public function insert($data) : bool {
        return DB::table('news')->insert($data);
    }
    public function update($id , $data) : int {
        return DB::table('news')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('news')->where('id', $id)->delete();
    }
}
