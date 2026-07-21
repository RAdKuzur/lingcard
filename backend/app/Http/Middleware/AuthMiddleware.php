<?php

namespace App\Http\Middleware;

use App\Repositories\Interfaces\TokenRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

    private TokenRepositoryInterface $tokenRepository;
    public function __construct(
        TokenRepositoryInterface $tokenRepository,
    )
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = $request->cookie('access_token');
        $refreshToken = $request->cookie('refresh_token');
        if($refreshToken && $accessToken && $this->tokenRepository->isValidJwtToken($accessToken)) {
            return $next($request);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
