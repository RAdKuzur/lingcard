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

    public function login(LoginRequest $request)
    {
        if($tokens = $this->authService->login($request->toDTO())) {
            $user = $this->authService->getAuthUserDTO($request->toDTO());
            return response()->json([
                'success' => true,
                'user' => $user
            ])
            ->cookie(
                'access_token',
                $tokens['access_token'],
                (int)env("ACCESS_TOKEN_TIME_EXPIRE"),
            )
            ->cookie(
                'refresh_token',
                $tokens['refresh_token'],
                (int)env("REFRESH_TOKEN_TIME_EXPIRE"),
            );
        }
        return response()->json([
            'success' => false
        ], 401);

    }

    public function logout(Request $request) {
        $this->authService->logout($request);
        return response()->json([
            'successful logout'
        ])
        ->cookie(
            'access_token',
            null,
            0,
        )
        ->cookie(
            'refresh_token',
            null,
            0,
        );
    }

    public function refresh()
    {

    }
}
