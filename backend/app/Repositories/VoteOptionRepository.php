<?php

namespace App\Repositories;

use App\Models\VoteOption;
use App\Repositories\Interfaces\VoteOptionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VoteOptionRepository implements VoteOptionRepositoryInterface
{
    public function all() {
        return VoteOption::all();
    }
    public function find($id) {
        return VoteOption::find($id);
    }
    public function insert($data) : bool {
        return DB::table('vote_options')->insert($data);
    }

    public function update($id, $data) : int {
        return DB::table('vote_options')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('vote_options')->where('id', $id)->delete();
    }

    public function findByVoteId($id)
    {
        return VoteOption::where(['vote_id' => $id])->get();
    }
}
