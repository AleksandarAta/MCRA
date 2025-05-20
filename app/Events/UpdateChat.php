<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel, $type, $message, $sender_id;

    /**
     * Create a new event instance.
     */
    public function __construct($channel, $type, $message, $sender_id)
    {
        $this->channel = $channel;
        $this->type = $type;
        $this->message = $message;
        $this->sender_id = $sender_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [new PrivateChannel('chat.' . $this->channel)];
    }
    public function broadcastAs()
    {
        return 'message';
    }
}
