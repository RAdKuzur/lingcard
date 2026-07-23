<?php

namespace App\Services;

use App\Dictionaries\RoleDictionary;
use App\DTO\AuthUserDTO;
use App\DTO\LoginDTO;
use App\DTO\RegisterDTO;
use App\Events\UserRegistered;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\TokenRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private UserRepositoryInterface $userRepository;
    private TokenRepositoryInterface $tokenRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
        TokenRepositoryInterface $tokenRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function login(LoginDTO $loginDTO) : array|bool
    {
        $user = $this->userRepository->getUserByCredentials(
            email: $loginDTO->email,
            password: $loginDTO->password
        );
        if ($user) {
            DB::beginTransaction();
            try {
                $refreshToken = JWTAuth::claims([
                    'time' => now()
                ])->fromUser($user);
                $accessToken = JWTAuth::claims([
                    'username' => $user->name,
                    'time' => now()
                ])->fromUser($user);
                $this->tokenRepository->createToken($refreshToken, $user->id);
                DB::commit();
                return [
                    'refresh_token' => $refreshToken,
                    'access_token' => $accessToken,
                ];
            }
            catch (\Exception $e) {
                DB::rollBack();
                LogHelper::errorLog($e->getTrace(), $e->getMessage());
                return [
                    'refresh_token' => null,
                    'access_token' => null,
                ];
            }
        }
        return false;
    }

    public function register(RegisterDTO $registerDTO) : bool
    {
        if ($this->userRepository->unique($registerDTO->email, $registerDTO->name)) {
            DB::beginTransaction();
            try {
                $this->userRepository->insert($registerDTO->toArray());
                //UserRegistered::dispatch($registerDTO->email, $registerDTO->name);
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollBack();
                LogHelper::errorLog($e->getTrace(), $e->getMessage());
            }
            return true;
        }
        return false;
    }

    public function logout(Request $request) : void
    {
        $refreshToken = $request->cookie('refresh_token');
        DB::beginTransaction();
        try {
            if ($refreshToken) {
                $token = $this->tokenRepository->getByRefreshToken($refreshToken);
                if ($token) {
                    $this->tokenRepository->delete($token->id);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
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
    public function refresh($request) : array|bool
    {
        $refreshToken = $request->cookie('refresh_token');
        if ($refreshToken) {
            $token = $this->tokenRepository->getByRefreshToken($refreshToken);
            if ($token && !$token->user->is_banned) {
                DB::beginTransaction();
                try {
                    $newRefreshToken = JWTAuth::claims([
                        'time' => now()
                    ])->fromUser($token->user);
                    $accessToken = JWTAuth::claims([
                        'username' => $token->user->name,
                        'time' => now()
                    ])->fromUser($token->user);

                    $this->tokenRepository->createToken($newRefreshToken, $token->user->id);
                    $this->tokenRepository->delete($token->id);
                    DB::commit();
                    return [
                        'refresh_token' => $newRefreshToken,
                        'access_token' => $accessToken,
                    ];
                }
                catch (\Exception $e) {
                    DB::rollBack();
                    LogHelper::errorLog($e->getTrace(), $e->getMessage());
                    return [
                        'refresh_token' => null,
                        'access_token' => null,
                    ];
                }
            }
        }
        return false;
    }

    public function user() : array
    {
        $user = AuthHelper::user();
        $dto = (new AuthUserDTO(
            role: RoleDictionary::get($user?->role),
            username: $user?->name,
        ))->toArray();
        return $dto;
    }
}
