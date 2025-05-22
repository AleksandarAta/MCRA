<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ConferenceRoom extends Component
{
    public $userId;

    public function mount()
    {
        $this->userId = Auth::id();
    }


    #[On('echo-private:App.Models.User.{userId},startConferenceCall')]
    public function startCall($event)
    {
        $this->dispatch('startConferenece');
    }

    public function render()
    {
        return view('livewire.conference-room');
    }
}
