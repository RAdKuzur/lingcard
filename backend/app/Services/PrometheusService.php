<?php

namespace App\Services;

use App\Services\Interfaces\PrometheusServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PrometheusService implements PrometheusServiceInterface
{
    public function getMetrics(): string
    {
        $httpTotalRequests = $this->getHttpTotalRequests();
        $totalErrors = $this->getTotalErrors();
        $durationSum = $this->getHttpDurationSum();
        $avgDuration = $httpTotalRequests > 0 ? $durationSum / $httpTotalRequests : 0;
        return implode("\n", [
            "http_total_requests " . $httpTotalRequests,
            "total_errors " . $totalErrors,
            "http_duration_avg_ms " . number_format($avgDuration, 2, '.', ''),
            "http_duration_sum_ms " . number_format($durationSum, 2, '.', ''),
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
    public function incTotalErrors() : void
    {
        if (Cache::has('total_errors')) {
            Cache::increment('total_errors');
        }
        else {
            Cache::put('total_errors', 1);
        }
    }
    public function setHttpDurationRequests($duration): void
    {
        Cache::increment('http_duration_sum', (int)($duration * 100));
    }
    public function getTotalErrors() : int
    {
        return Cache::get('total_errors') ?? 0;
    }
    public function getHttpDurationSum(): float
    {
        return Cache::get('http_duration_sum', 0) / 100;
    }
    public function getHttpDurationRequests(): float
    {
        $sum = $this->getHttpDurationSum();
        $count = $this->getHttpTotalRequests();

        return $count > 0 ? $sum / $count : 0;
    }
}
