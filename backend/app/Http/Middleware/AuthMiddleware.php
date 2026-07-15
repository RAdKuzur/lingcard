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
    private VisitRepository $visitRepository;
    public function __construct(
        TokenRepository $tokenRepository,
        VisitRepository $visitRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
        $this->visitRepository = $visitRepository;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = $request->cookie('access_token');
        $refreshToken = $request->cookie('refresh_token');
        $this->visitRepository->insert([
            'path' => request()->path(),
            'ip' => $request->header('X-Real-IP'),
            'user_agent' => request()->userAgent(),
            'time' => now()
        ]);
        if($refreshToken && $accessToken && $this->tokenRepository->isValidJwtToken($accessToken)) {
            return $next($request);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
