<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\PrometheusServiceInterface;

class TelemetryController extends Controller
{
    private PrometheusServiceInterface $prometheusService;
    public function __construct(
        PrometheusServiceInterface $prometheusService
    )
    {
        $this->prometheusService = $prometheusService;
    }

    public function metrics()
    {
        $metrics = $this->prometheusService->getMetrics();
        return response($metrics, 200)
            ->header('Content-Type', 'text/plain; version=0.0.4');
    }
}
