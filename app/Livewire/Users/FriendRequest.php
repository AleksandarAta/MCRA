<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Friend;
use App\Notifications\AcceptedFriendRequest;
use App\Notifications\FriendRequestNotification;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class FriendRequest extends Component
{
    public $own_id;

    public function mount()
    {
        $this->own_id = Auth::id();
    }

    #[On('addFriend')]
    public function addFriend($userId)
    {
        Friend::create([
            'user_id' => $this->own_id,
            'friend_id' => $userId,
            'accepted' => false,
        ]);

        $user = User::FindOrFail($userId);
        $user->notify(new FriendRequestNotification(Auth::id(), 'send'));
    }

    #[On('acceptFriend')]
    public function acceptFriend($friend_id)
    {
        $firend = Friend::where('friend_id', Auth::id())->where('user_id', $friend_id)->first();
        $firend->accepted = true;
        $firend->save();

        Friend::create([
            'user_id' => $this->own_id,
            'friend_id' => $friend_id,
            'accepted' => false,
        ]);


        $notifiedUser = User::findorFail($friend_id);

        $notifiedUser->notify(new AcceptedFriendRequest(Auth::id(), 'accepted'));
    }



    public function render()
    {
        return view('livewire.users.friend-request');
    }
}
