<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\handleAwnser;
use App\Events\startConferenceCall;
use Illuminate\Support\Facades\Log;
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
    public function sendAwnser($type, $sdp, $peerId,)
    {
        broadcast(new handleAwnser($this->sendAwnserTo, $type, $sdp, Auth::id(), $peerId))->toOthers();
    }

    #[On('sendIceCanidadtesToOfferer')]
    public function sendIceCandidates($peerId, $candidate)
    {
        $this->dispatch("receiveIceCandidatesOfferer", $peerId, $candidate);
    }
    #[On('echo-private:App.Models.User.{userId},sendIceCandidates')]
    public function handle($data)
    {


        $peerId = $data['data']['peerId'];
        $candidate = $data['data']['candidate'];

        Log::info('peerId : ' . $peerId);
        Log::info($candidate);


        $this->dispatch('receiveIceCandidatesAnwserer', $data);
    }

    public function render()
    {
        return view('livewire.conference-room');
    }
}
