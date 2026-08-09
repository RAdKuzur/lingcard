<?php

namespace App\Repositories;

use App\Models\Voice;
use App\Repositories\Interfaces\VoiceRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VoiceRepository implements VoiceRepositoryInterface
{
    public function all() {
        return Voice::all();
    }
    public function find($id) {
        return Voice::find($id);
    }
    public function insert($data) : bool {
        return DB::table('voices')->insert($data);
    }

    public function update($id, $data) : int {
        return DB::table('voices')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('voices')->where('id', $id)->delete();
    }
    public function countVoices($voteOptionId) : int
    {
        return DB::table('voices')->where('vote_option_id', $voteOptionId)->count();
    }
    public function deleteVoice($userId, $voteOptionId)
    {
        return DB::table('voices')->where('user_id', $userId)->where('vote_option_id', $voteOptionId)->delete();
    }
    public function deleteUserVoices($userId, array $voteOptionIds) {
        return DB::table('voices')->where('user_id', $userId)->whereIn('vote_option_id', $voteOptionIds)->delete();
    }
    public function findUserVoices($userId, array $voteOptionIds) {
        return DB::table('voices')->where('user_id', $userId)->whereIn('vote_option_id', $voteOptionIds)->first();
    }
    public function getCountVoices($voteId) : int {
        return DB::table('voices')
            ->join('vote_options', 'vote_options.id', '=', 'voices.vote_option_id')
            ->join('votes', 'votes.id', '=', 'vote_options.vote_id')
            ->where('votes.id', $voteId)
            ->count();
    }

}
