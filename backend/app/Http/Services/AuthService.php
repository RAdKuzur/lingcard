<?php

namespace App\Http\Services;

use App\Http\DTO\AuthUserDTO;
use App\Http\DTO\LoginDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class AuthService
{
    public function login(LoginDTO $loginDTO) : bool {
        if (Auth::attempt($loginDTO->toArray())) {
            request()->session()->regenerate();
            return true;
        }
        return false;
    }

    public function logout(Request $request) {
        if (Auth::check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }

    public function getAuthUserDTO() : array
    {
        return (new AuthUserDTO(
            role: 'Role',
            username: 'Username',
        ))->toArray();
    }
}
