<?php

namespace App\Repositories;

use App\Dictionaries\StatusPostDictionary;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{
    public function all() {
        return Post::all();
    }
    public function allSorted() {
        return Post::orderBy('date', 'asc')->get();
    }
    public function find($id) {
        return Post::find($id);
    }
    public function findByLangId($langId) {
        return Post::where(['language_id' => $langId])->orderBy('date', 'asc')->get();
    }
    public function findApprovedPostsByLangId($langId) {
        return Post::where(['language_id' => $langId])
            ->where(['status' => StatusPostDictionary::APPROVED])
            ->orderBy('date', 'asc')->get();
    }
    public function insert($data) : bool {
        return DB::table('posts')->insert($data);
    }
    public function update($id , $data) : int {
        return DB::table('posts')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('posts')->where('id', $id)->delete();
    }
    public function incrementViewsCount($id)
    {
        return DB::table('posts')->where('id', $id)->increment('views_count');
    }
    public function incrementLikesCount($id)
    {
        return DB::table('posts')->where('id', $id)->increment('likes_count');
    }
    public function incrementDislikesCount($id)
    {
        return DB::table('posts')->where('id', $id)->increment('dislikes_count');
    }
    public function decrementLikesCount($id)
    {
        return DB::table('posts')->where('id', $id)->decrement('likes_count');
    }
    public function decrementDislikesCount($id)
    {
        return DB::table('posts')->where('id', $id)->decrement('dislikes_count');
    }
}

