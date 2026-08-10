<?php

namespace App\Jobs;

use App\Repositories\VisitRepository;
use GeoIp2\Database\Reader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckLocationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public string $path;
    public string $ip;
    public string $userAgent;

    public $time;
    public function __construct(
        string $path, string $ip, string $userAgent, $time
    )
    {
        $this->path = $path;
        $this->ip = $ip;
        $this->userAgent = $userAgent;
        $this->time = $time;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->ip) {
            $reader = new Reader(base_path('data/geo/GeoLite2-City.mmdb'));
            $record = $reader->city($this->ip);
            (new VisitRepository())->insert([
                'path' => $this->path,
                'ip' => $this->ip,
                'user_agent' => $this->userAgent,
                'time' => $this->time,
                'country' => $record->country->name,
                'code' => $record->country->isoCode,
                'city' => $record->city->name,
            ]);
        }
    }
}
