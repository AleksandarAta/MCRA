<?php

namespace App\View\Components\user;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;

class profile extends Component
{
    public $user;
    /**
     * Create a new component instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.profile', [
            'user' => $this->user,
        ]);
    }
}
