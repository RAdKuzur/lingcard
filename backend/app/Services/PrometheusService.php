<?php

namespace App\Services;

use App\Services\Interfaces\PrometheusServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PrometheusService implements PrometheusServiceInterface
{
    public function getMetrics() : string
    {
        $httpTotalRequests = $this->getHttpTotalRequests();
        $totalErrors = $this->getTotalErrors();
        return
            "http_total_requests " . $httpTotalRequests . "\n" .
            "total_errors " . $totalErrors . "\n";
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
    public function getTotalErrors() : int
    {
        return Cache::get('total_errors') ?? 0;
    }
}
