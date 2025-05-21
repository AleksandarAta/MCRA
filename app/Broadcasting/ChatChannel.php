<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Log;

class ChatChannel
{

    /**
     * Create a new channel instance.
     */
    public function __construct() {}

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, $channel)
    {

        Log::info("From chaneel: " . $channel);

        $room_ids = ChatRoom::find($channel);
        $room_id = json_decode($room_ids->participants);
        if (in_array($user->id, $room_id)) {
            return true;
        }
    }
}
