<?php

namespace App\Repositories;

use App\Models\Word;

class WordRepository
{
    public function getAll() {
        return Word::all();
    }
}
