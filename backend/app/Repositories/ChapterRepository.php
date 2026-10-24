<?php

namespace App\Repositories;

use App\Models\Chapter;

class ChapterRepository
{
    public function all() {
        return Chapter::all();
    }

    public function find($id) {
        return Chapter::find($id);
    }
    public function findByBookID($bookID) {
        return Chapter::where('book_id', $bookID)->get();
    }
}
