<?php

namespace App\Services;

use App\Dictionaries\RoleDictionary;
use App\DTO\AuthUserDTO;
use App\DTO\LoginDTO;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class AuthService
{
    private UserRepository $userRepository;
    private TokenRepository $tokenRepository;
    public function __construct(
        UserRepository $userRepository,
        TokenRepository $tokenRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function login(LoginDTO $loginDTO) {
        $user = $this->userRepository->getUserByCredentials(
            email: $loginDTO->email,
            password: $loginDTO->password
        );
        if ($user) {
            $refreshToken = JWTAuth::claims([
                'time' => now()
            ])->fromUser($user);
            $accessToken = JWTAuth::claims([
                'username' => $user->name,
                'time' => now()
            ])->fromUser($user);
            $this->tokenRepository->createToken($refreshToken, $user->id);
            return [
                'refresh_token' => $refreshToken,
                'access_token' => $accessToken,
            ];
        }
        return false;
    }

    public function logout(Request $request) {
        $refreshToken = $request->cookie('refresh_token');
        if ($refreshToken) {
            $token = $this->tokenRepository->getByRefreshToken($refreshToken);
            if ($token) {
                $this->tokenRepository->delete($token->id);
            }
        }
    }

    public function getAuthUserDTO(LoginDTO $loginDTO) : array
    {
        $user = $this->userRepository->getUserByCredentials(
            email: $loginDTO->email,
            password: $loginDTO->password
        );
        return (new AuthUserDTO(
            role: RoleDictionary::get($user->role),
            username: $user->name,
        ))->toArray();
    }
    public function refresh($request)
    {
        $refreshToken = $request->cookie('refresh_token');
        if ($refreshToken) {
            $token = $this->tokenRepository->getByRefreshToken($refreshToken);
            if ($token) {
                $newRefreshToken = JWTAuth::claims([
                    'time' => now()
                ])->fromUser($token->user);
                $accessToken = JWTAuth::claims([
                    'username' => $token->user->name,
                    'time' => now()
                ])->fromUser($token->user);

                $this->tokenRepository->createToken($newRefreshToken, $token->user->id);
                //$this->tokenRepository->delete($token->id);

                return [
                    'refresh_token' => $newRefreshToken,
                    'access_token' => $accessToken,
                ];
            }
        }
        return false;
    }
}
