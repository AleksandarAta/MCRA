<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Livewire\Chat;
use App\Models\Friend;
use Livewire\Component;
use App\Models\ChatRoom;
use App\Models\Messeges;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class FriendList extends Component
{

    public $here;
    public $user;
    public $friends_list;
    public $userList;
    public $messages;
    public function mount()
    {
        // $this->user = Auth::user();

        $this->user = Auth::id();
        $this->userList = collect();
        $this->friends_list = Friend::where('user_id', $this->user)->get();

        $here = collect($this->here);
        $this->friends_list = $this->friends_list->map(function ($friend) {
            return User::findOrFail($friend->friend_id);
        });
        foreach ($this->friends_list as $friend) {
            $participants = [$friend->id, $this->user];

            $rooms_ids = ChatRoom::whereJsonContains('participants', $participants)->first();

            if ($rooms_ids) {
                $room_id = $rooms_ids->id;
                $this->messages = Messeges::where('from', $friend->id)->where('chatRoom_id', $room_id)->get();
            } else {
                $this->messages = '';
            }

            if ($here->contains('id', $friend->id)) {
                $status = 'online';
            } else {
                $status = 'offline';
            }
            $this->userList->push([
                'email' => $friend->email,
                'profile_photo_path' => $friend->profile_photo_path,
                'name' => $friend->name,
                'id' => $friend->id,
                'status' => $friend->status,
            ]);
        }
    }

    #[On('echo-presence:global,here')]
    public function here($here)
    {
        $this->here = collect($here);

        $new_user_list = collect();
        foreach ($this->userList as $user) {
            if ($this->here->contains('id', $user['id'])) {
                $status = 'online';
            } else {
                $status = 'offline';
            }
            $new_user_list->push([
                'email' => $user['email'],
                'profile_photo_path' => $user['profile_photo_path'],
                'id' => $user['id'],
                'name' => $user['name'],
                'status' => $status,
            ]);
        }
        $this->userList = $new_user_list;
    }

    #[On('echo-presence:global,joining')]
    public function joining($joining)
    {
        $this->here->push($joining);
        $new_user_list = collect();
        foreach ($this->userList as $user) {
            if ($this->here->contains('id', $user['id'])) {
                $status = 'online';
            } else {
                $status = 'offline';
            }
            $new_user_list->push([
                'email' => $user['email'],
                'profile_photo_path' => $user['profile_photo_path'],
                'id' => $user['id'],
                'name' => $user['name'],
                'status' => $status,
            ]);
        }
        $this->userList = $new_user_list;
    }
    #[On('echo-presence:global,leaving')]
    public function leaving($leaving)
    {
        $this->here = collect($this->here);
        $id = $leaving['id'];
        $name = $leaving['name'];
        $this->here = $this->here->reject(function ($value) use ($id, $name) {
            if ($value['id'] == $id && $value['name'] == $name) {
                return true;
            } else {
                return false;
            }
        });

        $this->userList = collect($this->userList);

        $new_user_list = [];
        $new_user_list = collect($new_user_list);

        foreach ($this->userList as $friend) {

            if ($this->here->contains('id', $friend['id'])) {
                $status = "online";
            } else {
                $status = "offline";
            }

            $new_user_list->push([
                'email' => $friend['email'],
                'profile_photo_path' => $friend['profile_photo_path'],
                'id'  => $friend['id'],
                'name' => $friend['name'],
                'status' => $status,
            ]);
        }
        $this->userList = $new_user_list;
    }

    public function render()
    {

        return view('livewire.users.friend-list');
    }
}
