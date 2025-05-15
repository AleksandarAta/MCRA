<?php

namespace App\Livewire\Users;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications;
    public $userId;
    public $status;
    public $notificaationNumber = 0;
    public function mount()
    {

        $this->userId = Auth::id();
        $this->notifications = collect();
        $user = Auth::user();

        $notifications = Auth::user()->unreadNotifications;
        if ($notifications->count()) {
            $this->notificaationNumber = $notifications->count();
            foreach ($notifications as $notification) {

                $name = User::select('id', 'name')->where('id', $notification->data['user'])->first();
                $this->notifications->push([
                    'name' => $name,
                    'event' => $notification->data['event'],
                    'friend_id' =>  $notification->data['user'],
                    'id' => $notification->id,
                ]);
            }
        };
    }
    #[On('echo-notification:App.Models.User.{userId}, notification')]
    public function gotNotification($notification)
    {
        $this->notificaationNumber++;

        $name = User::select('id', 'name')->where('id', $notification['user'])->first();
        $this->notifications->push([
            'name' => $name,
            'event' => $notification['event'],
            'friend_id' =>  $notification['user'],
            'id' => $notification['id'],
        ]);
    }

    public function readNotifications()
    {
        $user = Auth::user();

        $user->unreadNotifications->each(function ($notification) {
            $notification->read_at = Carbon::now();
            $notification->save();
        });

        $this->notificaationNumber = 0;
    }

    public function render()
    {
        return view('livewire.users.notifications');
    }
}
