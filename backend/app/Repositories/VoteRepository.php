<?php

namespace App\Repositories;

use App\Models\Vote;
use App\Repositories\Interfaces\VoteRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VoteRepository implements VoteRepositoryInterface
{
    public function all() {
        return Vote::all();
    }
    public function find($id) {
        return Vote::find($id);
    }
    public function insert($data) : bool {
        return DB::table('votes')->insert($data);
    }

    public function update($id, $data) : int {
        return DB::table('votes')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('votes')->where('id', $id)->delete();
    }
}
