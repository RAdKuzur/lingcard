<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
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

        if($this->authService->login($request->toDTO())) {
            $user = $this->authService->getAuthUserDTO();
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }
        return response()->json([
            'success' => false
        ], 401);

    }

    public function logout(Request $request) {
        $this->authService->logout($request);
        return response()->json([
            'successful logout'
        ]);
    }
}
