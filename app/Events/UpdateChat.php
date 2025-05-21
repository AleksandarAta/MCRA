<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

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
        Log::info('From Event: ' . $this->message . " Type: " . $this->type . " Channel:  " . $this->channel . " Sender :" . $this->sender_id);
        return [
            new PrivateChannel('chat.' . $this->channel),
        ];
    }
    // public function broadcastAs()
    // {
    //     return 'message';
    // }

    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('chat.' . $this->channel),
    //     ];
    // }
}
