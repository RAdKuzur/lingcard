<?php

namespace App\Services;

use App\Services\Interfaces\PrometheusServiceInterface;
use Illuminate\Support\Facades\Cache;

class PrometheusService implements PrometheusServiceInterface
{
    public function getMetrics() : string
    {
        $httpTotalRequests = $this->getHttpTotalRequests();
        return "http_total_requests " . $httpTotalRequests . "\n";
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
}
