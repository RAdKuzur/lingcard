<?php

namespace App\Http\Middleware;

use App\Jobs\CheckLocationJob;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        CheckLocationJob::dispatch(request()->path(), $request->header('X-Real-IP'), request()->userAgent(), now());
        return $next($request);
    }
}
