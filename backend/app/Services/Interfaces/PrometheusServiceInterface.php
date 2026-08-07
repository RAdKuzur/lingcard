<?php

namespace App\Services\Interfaces;

interface PrometheusServiceInterface

{
    public function getMetrics(): string;
    public function incHttpTotalRequests() : void;
    public function getHttpTotalRequests() : int;
    public function setHttpLatencyRequests($duration): void;
    public function getHttpLatencyRequests(): float;
    public function getTotalErrors() : int;
}
