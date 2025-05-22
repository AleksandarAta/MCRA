<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Events\startConferenceCall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ConferenceCall extends Component
{
    public $users;
    public $selectedUsers = [];
    public function mount($users)
    {
        $this->users = $users;
    }
    public function startConference()
    {

        $selectedUsers = User::whereIn('id', $this->selectedUsers)->get();
        $selectedUsers->push(Auth::user());

        foreach ($selectedUsers as $user) {
            broadcast(new startConferenceCall($user->id));
        }
    }

    public function render()
    {
        return view('livewire.conference-call');
    }
}
