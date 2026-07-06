<?php

namespace App\Repositories;

use App\Models\Token;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenRepository
{
    public function getByRefreshToken($refreshToken) : Token|null {
        return Token::where('refresh_token', $refreshToken)->first();
    }

    public function createToken($token, $userId){
        $ttl = env('REFRESH_TOKEN_TIME_EXPIRE', 1440);
        return DB::table('tokens')->insert([
            'refresh_token' => $token,
            'user_id' => $userId,
            'expires_at' => date("Y-m-d H:i:s", strtotime("+{$ttl} minutes")),
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

    public function delete($id)
    {
        return DB::table('tokens')->where('id', $id)->delete();
    }
}
