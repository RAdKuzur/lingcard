<?php

namespace App\Listeners;

use App\Events\UserRegistered;
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
        $subject = 'Регистрация пользователя. LingCard.';
        $text = '';
        $html = "Поздравляю, {$event->name}! Вы зарегистрировались на LingCard, надеюсь Вы получите удовольствие в ходе изучение новых языков!";
        SendEmailJob::dispatch($event->email, $subject, $text, $html);
    }
}
