<?php

namespace App\Livewire\Users;

use App\Models\Friend;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $user;
    public $status;
    public function mount($user)
    {
        $this->user = $user;
    }

    public function addFriend($userId)
    {
        $this->dispatch("addFriend", $userId)->to(FriendRequest::class);
    }



    public function render()
    {
        return view('livewire.users.profile', [
            'user' => $this->user,
        ]);
    }
}
