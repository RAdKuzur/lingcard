<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LogHelper
{
    public static function errorLog($trace, $message) {

        /** для метрик */
        if (Cache::has('total_errors')) {
            Cache::increment('total_errors');
        }
        else {
            Cache::put('total_errors', 1);
        }

        return DB::table('error_logs')->insert([
            'message' => $message,
            'trace' => json_encode($trace),
            'time' => now()
        ]);
    }

}
