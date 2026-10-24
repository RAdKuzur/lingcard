<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository
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
}
