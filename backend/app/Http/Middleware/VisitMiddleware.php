<?php

namespace App\Http\Middleware;

use App\Repositories\Interfaces\VisitRepositoryInterface;
use App\Services\Interfaces\PrometheusServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitMiddleware
{
    private VisitRepositoryInterface $visitRepository;
    private PrometheusServiceInterface $prometheusService;
    public function __construct(
        VisitRepositoryInterface $visitRepository,
        PrometheusServiceInterface $prometheusService
    )
    {
        $this->visitRepository = $visitRepository;
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
        $this->visitRepository->insert([
            'path' => request()->path(),
            'ip' => $request->header('X-Real-IP') ?? 'test_ip',
            'user_agent' => request()->userAgent(),
            'time' => now()
        ]);
        $startTime = microtime(true) * 1000;
        $response = $next($request);
        $duration = (microtime(true) * 1000) - $startTime;
        $this->prometheusService->setHttpDurationRequests($duration);
        return $response;
    }
}
