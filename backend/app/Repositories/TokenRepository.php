<?php

namespace App\Repositories;

use App\Models\Token;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenRepository
{
    public function getByRefreshToken($refreshToken) {
        return Token::where('refresh_token', $refreshToken)->first();
    }

    public function createToken($token, $userId){
        return DB::table('tokens')->insert([
            'refresh_token' => $token,
            'user_id' => $userId,
            'expires_at' => date("Y-m-d H:i:s", strtotime("+1440 minutes")),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'is_revoked' => false,
        ]);
    }
    public function isValidJwtToken($token){
        return JWTAuth::setToken($token)->check();
    }

    public function isValidToken($token){

    }
}
