<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookRepository implements BookRepositoryInterface
{
    public function all() {
        return Book::all();
    }
    public function allWithRelations() {
        return Book::with('author')->with('language')->get();
    }
    public function find($id) {
        return Book::find($id);
    }
    public function insert(array $data) : bool {
        return DB::table('books')->insert($data);
    }
    public function update($id, array $data) : int {
        return DB::table('books')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('books')->where('id', $id)->delete();
    }
}
