<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class startConferenceCall implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $type;
    public $offer;
    public $sender_id;
    public $peerId;


    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $type, $offer, $sender_id, $peerId)
    {
        $this->user_id = $user_id;
        $this->type = $type;
        $this->offer = $offer;
        $this->sender_id = $sender_id;
        $this->peerId = $peerId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->user_id),
        ];
    }
}
