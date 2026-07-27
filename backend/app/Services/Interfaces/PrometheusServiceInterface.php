<?php

namespace App\Services\Interfaces;

interface PrometheusServiceInterface

{
    public function getMetrics(): string;
    public function incHttpTotalRequests() : void;
    public function getHttpTotalRequests() : int;
    public function incTotalErrors() : void;
    public function setHttpDurationRequests($duration): void;
    public function getTotalErrors() : int;
    public function getHttpDurationSum(): float;
    public function getHttpDurationRequests(): float;
}
