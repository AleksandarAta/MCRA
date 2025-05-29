<?php

namespace App\Livewire;

use App\Events\sendIceCandidates;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\startConferenceCall;
use Illuminate\Support\Facades\Log;
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

    #[On('echo-private:App.Models.User.{userId},handleAwnser')]
    public function handleAwnser($event)
    {

        $this->dispatch('startCall', $event);
    }


    #[On('sendOffer')]
    public function startConference($type, $sdp, $peerId)
    {

        $selectedUsers = User::whereIn('id', $this->selectedUsers)->get();
        foreach ($selectedUsers as $user) {
            broadcast(new startConferenceCall($user->id, $type, $sdp, $this->userId, $peerId))->toOthers();
        }
    }

    #[On('sendIceCanidadtestoAnwserer')]
    public function sendIceCandidates($peerId, $candidate)
    {
        $selectedUsers = User::whereIn('id', $this->selectedUsers)->get();
        if ($candidate) {
            foreach ($selectedUsers as $user) {
                broadcast(new sendIceCandidates($user->id, [
                    'peerId' => $peerId,
                    'candidate' => $candidate,
                ]))->toOthers();
            }
        }
    }
    public function initConf()
    {
        $this->dispatch('initConf', $this->selectedUsers);
    }



    public function render()
    {
        return view('livewire.conference-call');
    }
}
