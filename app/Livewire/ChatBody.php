<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatRoom;
use App\Models\Messeges;
use App\Events\UpdateChat;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ChatBody extends Component
{
    public $channel_id;
    public $messeges;
    public function mount($channel_id)
    {
        $this->channel_id = $channel_id;
        $this->messeges = Messeges::where('chatRoom_id', $channel_id)->get();
    }

    #[On('echo-private:chat.{channel_id}, message')]
    public function recieveMessage($message)
    {
        dd($message);
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
        return view('livewire.chat-body');
    }
}
