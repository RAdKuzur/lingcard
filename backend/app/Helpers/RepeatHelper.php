<?php

namespace App\Helpers;

class RepeatHelper
{
    public static function repeat($repeat)
    {
        return match ($repeat) {
            0 => date("Y-m-d H:i:s", strtotime("+30 minutes")),
            1 => date("Y-m-d H:i:s", strtotime("+4 hours")),
            2 => date("Y-m-d H:i:s", strtotime("+1 days")),
            3 => date("Y-m-d H:i:s", strtotime("+3 days")),
            4 => date("Y-m-d H:i:s", strtotime("+7 days")),
            5 => date("Y-m-d H:i:s", strtotime("+30 days")),
            6 => date("Y-m-d H:i:s", strtotime("+60 days")),
            default => date("Y-m-d H:i:s", strtotime("+90 days")),
        };
    }
}
