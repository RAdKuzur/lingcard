<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications.{username}', function (User $user, $username) {
    return $user->name === $username;
});
