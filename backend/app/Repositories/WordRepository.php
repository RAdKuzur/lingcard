<?php

namespace App\Repositories;

use App\Models\Word;
use App\Repositories\Interfaces\WordRepositoryInterface;
use Illuminate\Support\Facades\DB;

class WordRepository implements WordRepositoryInterface
{
    public function all() {
        return Word::all();
    }
    public function find($id) {
        return Word::find($id);
    }
    public function insert($data) : bool {
        return DB::table('words')->insert($data);
    }

    public function update($id, $data) : int {
        return DB::table('words')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('words')->where('id', $id)->delete();
    }
}
