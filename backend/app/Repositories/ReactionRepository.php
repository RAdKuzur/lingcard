<?php

namespace App\Repositories;

use App\Dictionaries\StatusReactionDictionary;
use App\Models\Reaction;
use App\Repositories\Interfaces\ReactionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReactionRepository implements ReactionRepositoryInterface
{
    public function all() {
        return Reaction::all();
    }
    public function find($id) {
        return Reaction::find($id);
    }
    public function insert($data) : bool {
        return DB::table('reactions')->insert($data);
    }
    public function update($id , $data) : int {
        return DB::table('reactions')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('reactions')->where('id', $id)->delete();
    }
    public function findReaction($userId, $postId) {
        return Reaction::where(['user_id' => $userId])
            ->where(['post_id' => $postId])
            ->first();
    }
    public function deleteReaction($userId, $postId, $status)
    {
        return DB::table('reactions')
            ->where(['user_id' => $userId])
            ->where(['post_id' => $postId])
            ->where(['status' => $status])
            ->delete();
    }

    public function isLiked($userId, $postId) : bool
    {
        return DB::table('reactions')
            ->where(['user_id' => $userId])
            ->where(['post_id' => $postId])
            ->where(['status' => StatusReactionDictionary::LIKE])
            ->exists();
    }

    public function isDisliked($userId, $postId) : bool
    {
        return DB::table('reactions')
            ->where(['user_id' => $userId])
            ->where(['post_id' => $postId])
            ->where(['status' => StatusReactionDictionary::DISLIKE])
            ->exists();
    }
    public function countLikes($postId)
    {
        return DB::table('reactions')
            ->where(['post_id' => $postId])
            ->where(['status' => StatusReactionDictionary::LIKE])
            ->count();
    }
    public function countDislikes($postId)
    {
        return DB::table('reactions')
            ->where(['post_id' => $postId])
            ->where(['status' => StatusReactionDictionary::DISLIKE])
            ->count();
    }
}
