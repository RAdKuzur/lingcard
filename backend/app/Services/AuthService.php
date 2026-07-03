<?php

namespace App\Services;

use App\DTO\AuthUserDTO;
use App\DTO\LoginDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
