<?php

namespace App\Http\Middleware;

use App\Repositories\TokenRepository;
use App\Repositories\VisitRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

    private TokenRepository $tokenRepository;
    public function __construct(
        TokenRepository $tokenRepository,
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
