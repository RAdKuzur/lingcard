<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CommentRepository implements CommentRepositoryInterface
{
    public function all() {
        return Comment::all();
    }
    public function find($id) {
        return Comment::find($id);
    }
    public function insert($data) : bool {
        return DB::table('comments')->insert($data);
    }
    public function update($id, $data) : int {
        return DB::table('comments')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('comments')->where('id', $id)->delete();
    }

    public function getComments($postId) {
        return Comment::where('post_id', $postId)
            ->orderBy('is_fixed', 'desc')
            ->orderBy('time', 'desc')
            ->get();
    }
}
