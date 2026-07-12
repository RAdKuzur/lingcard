<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WordRepeated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private User $user;
    /**
     * Create a new event instance.
     */
    public function __construct(
        User $user
    )
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('notifications'),
        ];
    }
    public function broadcastAs(): string
    {
        return 'words.repeated.' . $this->user->name;
    }
    public function broadcastWith(): array {
        return [
            'message' => 'Поздравляю! Вы выучили слово!'
        ];
    }
}
