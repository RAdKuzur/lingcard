<?php

namespace App\Http\Middleware;

use App\Repositories\VisitRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitMiddleware
{
    private VisitRepository $visitRepository;
    public function __construct(
        VisitRepository $visitRepository
    )
    {
        $this->visitRepository = $visitRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->visitRepository->insert([
            'path' => request()->path(),
            'ip' => $request->header('X-Real-IP'),
            'user_agent' => request()->userAgent(),
            'time' => now()
        ]);
        return $next($request);
    }
}
