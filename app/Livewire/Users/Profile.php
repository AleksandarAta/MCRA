<?php

namespace App\Livewire\Users;

use App\Models\Friend;
use App\Models\Commend;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $user;
    public $status;
    public function mount($user)
    {
        $this->user = $user->load('commends');
    }

    public function addFriend($userId)
    {
        $this->dispatch("addFriend", $userId)->to(FriendRequest::class);
    }



    public function render()
    {
        $commends  = Commend::where('user_id', $this->user->id)->with('user')->get();
        return view('livewire.users.profile', [
            'commends' => $commends,
            'user' => $this->user,
        ]);
    }
}
