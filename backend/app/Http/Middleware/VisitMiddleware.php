<?php

namespace App\Http\Middleware;

use App\Repositories\Interfaces\VisitRepositoryInterface;
use App\Services\Interfaces\PrometheusServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitMiddleware
{
    private PrometheusServiceInterface $prometheusService;
    public function __construct(
        PrometheusServiceInterface $prometheusService
    )
    {
        $this->prometheusService = $prometheusService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->prometheusService->incHttpTotalRequests();
        $startTime = microtime(true) * 1000;
        $response = $next($request);
        $duration = (microtime(true) * 1000) - $startTime;
        $this->prometheusService->setHttpLatencyRequests($duration);
        return $response;
    }
}
