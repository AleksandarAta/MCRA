<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Friend;
use Livewire\Component;
use App\Models\ChatRoom;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{

    public $open;
    public $lastMessage;
    public $friend;
    public $body;
    #[On('startChat')]
    public function startChat($friend_id, $name)
    {

        $this->friend = User::where('id', $friend_id)->first();

        $this->open = collect($this->open);
        $participants = [$friend_id, Auth::id()];

        $all_chat_rooms = ChatRoom::whereJsonContains('participants', $participants)->first();

        if ($all_chat_rooms == null) {
            $participants = json_encode($participants);

            $all_chat_rooms =  ChatRoom::create([
                'participants' => $participants
            ]);
        }
        $room_ids = $all_chat_rooms->id;
        if (!$this->open->contains('friend_id', $friend_id) && count($this->open) < 3) {
            $this->open->push([
                'name' => $name,
                'friend_id' => $friend_id,
                'room_id' => $room_ids,
            ]);
        }
    }
    #[On('sendMessage')]
    public function sendMessage()
    {
        $this->dispatch('sendMessage', $this->body)->to(ChatBody::class);

        $this->body = '';
    }
    public function render()
    {
        if ($this->open != null) {
            foreach ($this->open as $op) {
                dump($op);
            }
        }
        return view('livewire.chat');
    }
}
