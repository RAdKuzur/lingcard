<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;
    public function __construct(
        AuthService $authService
    )
    {
        $this->authService = $authService;
    }

    public function csrf() {
        return response()->json([
            'Set CSRF Token'
        ]);
    }
    public function login(LoginRequest $request)
    {
        $this->authService->login($request->toDTO());
        return response()->json([
            'successful login'
        ]);
    }

    public function logout(Request $request) {
        $this->authService->logout($request);
        return response()->json([
            'successful logout'
        ]);
    }
}
