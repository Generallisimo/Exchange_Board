<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MarketStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $users;
    public $isOnline;
    /**
     * Create a new event instance.
     */
    public function __construct($users, $isOnline = false)
    {
        $this->users = $users;
        $this->isOnline = $isOnline;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('board-change');
    }

    public function broadcastAs(){

        return 'board-change';
    }

    public function broadcastWith()
    {
        return [
            'users' => $this->users,
            'isOnline' => $this->isOnline
        ];
    }
}
