<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function register(RegisterRequest $request)
    {
        $dto = $request->toDTO();
        $status = $this->authService->register($dto);
        return response()->json([
            'data' => [
                'status' => $status
            ]
        ]);
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

    public function refresh(Request $request)
    {
        if ($tokens = $this->authService->refresh($request)) {
            return response()->json([
                'success' => true
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
        };
        return response()->json([
            'success' => false
        ], 401);
    }

    public function user()
    {
        $user = $this->authService->user();
        return response()->json([
            'data' => $user
        ]);
    }

    public function broadcast(Request $request)
    {
        $user = AuthHelper::user();
        if(!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        Auth::login($user);
        return \Illuminate\Support\Facades\Broadcast::auth($request);
    }
}
