<?php

namespace App\Http\Services;

use App\Http\DTO\LoginDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class AuthService
{
    public function login(LoginDTO $loginDTO) {
        if (Auth::attempt($loginDTO->toArray())) {
            request()->session()->regenerate();
        }
    }

    public function logout(Request $request) {
        if (Auth::check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}
