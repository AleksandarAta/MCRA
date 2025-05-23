<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\startConferenceCall;
use Illuminate\Support\Facades\Auth;

class ConferenceRoom extends Component
{
    public $userId;
    public $sendAwnserTo;
    public function mount()
    {
        $this->userId = Auth::id();
    }


    #[On('echo-private:App.Models.User.{userId},startConferenceCall')]
    public function startCall($event)
    {
        $this->dispatch('startConferenece', $event);
        $this->sendAwnserTo = $event['sender_id'];
    }

    #[On('sendAwnser')]
    public function sendAwnser($type, $sdp)
    {
        broadcast(new startConferenceCall($this->sendAwnserTo, $type, $sdp, Auth::id()))->toOthers();
    }

    public function render()
    {
        return view('livewire.conference-room');
    }
}
