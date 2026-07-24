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
    public function findReaction($userId, $newsId) {
        return Reaction::where(['user_id' => $userId])
            ->where(['news_id' => $newsId])
            ->first();
    }
    public function deleteReaction($userId, $newsId, $status)
    {
        return DB::table('reactions')
            ->where(['user_id' => $userId])
            ->where(['news_id' => $newsId])
            ->where(['status' => $status])
            ->delete();
    }

    public function isLiked($userId, $newsId) : bool
    {
        return DB::table('reactions')
            ->where(['user_id' => $userId])
            ->where(['news_id' => $newsId])
            ->where(['status' => StatusReactionDictionary::LIKE])
            ->exists();
    }

    public function isDisliked($userId, $newsId) : bool
    {
        return DB::table('reactions')
            ->where(['user_id' => $userId])
            ->where(['news_id' => $newsId])
            ->where(['status' => StatusReactionDictionary::DISLIKE])
            ->exists();
    }
}
