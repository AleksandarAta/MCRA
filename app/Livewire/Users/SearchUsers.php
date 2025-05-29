<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class SearchUsers extends Component
{
    public $search = '';
    public $users;
    public function render()
    {
    if(strlen($this->search) >= 3){ 
        $this->users = User::where('name', 'LIKE' , '%' . $this->search . "%")
        ->orWhere('email', 'LIKE' , '%' . $this->search . "%")
        ->limit(3)->get();
    }
        return view('livewire.users.search-users', [
            'users' => $this->users,
        ]);
    }
}
