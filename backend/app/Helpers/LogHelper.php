<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class LogHelper
{
    public static function errorLog($trace, $message) {
        return DB::table('log')->insert([
            'message' => $message,
            'trace' => $trace,
            'time' => now()
        ]);
    }

}
