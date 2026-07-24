<?php

namespace App\Repositories;

use App\Dictionaries\StatusNewsDictionary;
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
    public function findApprovedNewsByLangId($langId) {
        return News::where(['language_id' => $langId])
            ->where(['status' => StatusNewsDictionary::APPROVED])
            ->orderBy('date', 'asc')->get();
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
    public function incrementViewsCount($id)
    {
        return DB::table('news')->where('id', $id)->increment('views_count');
    }
    public function incrementLikesCount($id)
    {
        return DB::table('news')->where('id', $id)->increment('likes_count');
    }
    public function incrementDislikesCount($id)
    {
        return DB::table('news')->where('id', $id)->increment('dislikes_count');
    }
    public function decrementLikesCount($id)
    {
        return DB::table('news')->where('id', $id)->decrement('likes_count');
    }
    public function decrementDislikesCount($id)
    {
        return DB::table('news')->where('id', $id)->decrement('dislikes_count');
    }
}

