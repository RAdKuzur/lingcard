<?php

namespace App\Repositories;

use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class VisitRepository
{
    public function create() {
        return DB::table('visits')->insert([
            'path' => request()->path(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'time' => now()
        ]);
    }
}
