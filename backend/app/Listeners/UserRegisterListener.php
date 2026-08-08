<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Jobs\InitProgressJob;
use App\Jobs\SendEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserRegisterListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        InitProgressJob::dispatch($event->user->base_language_id, $event->user->target_language_id, $event->user->id);
    }
}
