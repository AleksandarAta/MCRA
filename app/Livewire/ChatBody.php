<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatRoom;
use App\Models\Messeges;
use App\Events\UpdateChat;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChatBody extends Component
{
    public $channel_id;
    public $messages = [];
    public $latest_message;
    public $own_id;
    public $sender_id;
    public $last_id;
    public function mount($channel_id)
    {
        $this->own_id = Auth::id();
        $this->channel_id = $channel_id;
        $this->messages = Messeges::where('chatRoom_id', $channel_id)->get()->toArray();
        $this->last_id = Messeges::where('chatRoom_id', $channel_id)->orderBy('id', 'desc')->value('id');
    }


    #[On('echo-private:chat.{channel_id},UpdateChat')]
    public function receiveMessage($event)
    {
        $this->latest_message = $event;
        $this->last_id++;
    }

    #[On('sendMessage')]
    public function sendMessage($body)
    {
        Messeges::create([
            'chatRoom_id' => $this->channel_id,
            'body' => $body,
            'from' => Auth::id(),
            'read' => false,
        ]);

        broadcast(new UpdateChat($this->channel_id, 'message', $body, Auth::id()))->toOthers();
    }

    public function render()
    {
        return view(
            'livewire.chat-body',
        );
    }
}
