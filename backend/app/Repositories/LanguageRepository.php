<?php

namespace App\Repositories;

use App\Models\Language;

class LanguageRepository
{
    public function all() {
        return Language::all();
    }
    public function one($id) {
        return Language::find($id);
    }
}
