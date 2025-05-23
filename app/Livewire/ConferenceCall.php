<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\startConferenceCall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ConferenceCall extends Component
{
    public $users;
    public $userId;
    public $selectedUsers = [];

    public function mount($users)
    {
        $this->userId = Auth::id();
        $this->users = $users;
    }

    #[On('echo-private:App.Models.User.{userId},startConferenceCall')]
    public function startCall($event)
    {
        $this->dispatch('startCall', $event);
    }


    #[On('startConference')]
    public function startConference($type, $sdp)
    {
        $selectedUsers = User::whereIn('id', $this->selectedUsers)->get();

        foreach ($selectedUsers as $user) {
            broadcast(new startConferenceCall($user->id, $type, $sdp, $this->userId))->toOthers();
        }
    }



    public function render()
    {
        return view('livewire.conference-call');
    }
}
