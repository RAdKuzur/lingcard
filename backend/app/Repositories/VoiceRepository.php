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
}
