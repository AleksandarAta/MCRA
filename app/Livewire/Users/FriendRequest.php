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
    public $user;
    public $status = '';

    public function mount($user)
    {
        $this->own_id = Auth::id();
        $this->user = $user;
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
        $this->statusCheck();
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
            'accepted' => true,
        ]);

        $notifiedUser = User::findorFail($friend_id);

        $notifiedUser->notify(new AcceptedFriendRequest(Auth::id(), 'accepted'));
        $this->statusCheck();
    }

    #[On('checkStatus')]
    public function statusCheck()
    {

        $userStatus = Friend::where('user_id', Auth::id())->where('friend_id', $this->user->id)->first();
        $friendStatus = Friend::where('user_id', $this->user->id)->where('friend_id', Auth::id())->first();

        if ($userStatus || $friendStatus) {
            if ($userStatus && !$friendStatus) {
                $this->status = "sent";
            } elseif (!$userStatus  && $friendStatus) {
                $this->status = "add";
            } elseif ($userStatus->accepted && $friendStatus->accepted) {
                $this->status  = 'friends';
            }
        } else {
            $this->status = '';
        };
    }




    public function render()
    {
        $this->statusCheck();
        return view('livewire.users.friend-request');
    }
}
