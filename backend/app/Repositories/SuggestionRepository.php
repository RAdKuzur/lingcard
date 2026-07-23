<?php

namespace App\Repositories;

use App\Models\Suggestion;
use App\Repositories\Interfaces\SuggestionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SuggestionRepository implements SuggestionRepositoryInterface
{
    public function all() {
        return Suggestion::all();
    }
    public function find($id) {
        return Suggestion::find($id);
    }
    public function insert($data) : bool {
        return DB::table('suggestions')->insert($data);
    }
    public function update($id , $data) : int {
        return DB::table('suggestions')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('suggestions')->where('id', $id)->delete();
    }

}
