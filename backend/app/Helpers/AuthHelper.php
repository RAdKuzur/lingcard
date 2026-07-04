<?php

namespace App\Helpers;

use App\Models\Token;
use App\Models\User;

class AuthHelper
{
    public static function user() : User|null {
        $refreshToken = request()->cookie('refresh_token');
        $token = Token::where([
            'refresh_token' => $refreshToken,
        ])->first();
        if($refreshToken && $token) {
            return $token->user;
        }
        return null;
    }
}
