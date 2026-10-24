<?php

namespace App\Repositories;

use App\Models\Chapter;
use App\Repositories\Interfaces\ChapterRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChapterRepository implements ChapterRepositoryInterface
{
    public function all() {
        return Chapter::all();
    }
    public function find($id) {
        return Chapter::find($id);
    }
    public function findByBookID($bookID) {
        return Chapter::where('book_id', $bookID)->orderBy('number', 'ASC')->get();
    }
    public function insert(array $data) : bool {
        return DB::table('chapters')->insert($data);
    }
    public function update($id, array $data) : int {
        return DB::table('chapters')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('chapters')->where('id', $id)->delete();
    }
}
