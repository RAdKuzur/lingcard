<?php

namespace App\Services;

use App\Services\Interfaces\PrometheusServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PrometheusService implements PrometheusServiceInterface
{
    public const int LOG_PERIOD = 10;
    public function getMetrics(): string
    {
        $httpTotalRequests = $this->getHttpTotalRequests();
        $totalErrors = $this->getTotalErrors();
        $averageLatency = $this->getHttpLatencyRequests();
        return implode("\n", [
            "http_total_requests " . $httpTotalRequests,
            "total_errors " . $totalErrors,
            "total_request_latency " . $averageLatency
        ]);
    }
    public function incHttpTotalRequests() : void
    {
        if (Cache::has('http_total_requests')) {
            Cache::increment('http_total_requests');
        }
        else {
            Cache::put('http_total_requests', 1);
        }
    }
    public function getHttpTotalRequests() : int
    {
        return Cache::get('http_total_requests') ?? 0;
    }
    public function setHttpLatencyRequests($duration): void
    {
        $latencyMs = (int)($duration * 100);
        if (Cache::has('http_latency_sum')) {
            Cache::increment('http_latency_sum', $latencyMs);
        } else {
            Cache::put('http_latency_sum', $latencyMs);
        }
    }

    public function getHttpLatencyRequests(): float
    {
        return round(Cache::get('http_latency_sum') / 100, 2) ?? 0;
    }
    public function getTotalErrors() : int
    {
        return Cache::get('total_errors') ?? 0;
    }
}
