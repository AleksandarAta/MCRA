<?php

namespace App\Livewire\Comment;

use App\Models\Comment;
use Livewire\Component;
use App\Notifications\BlogComment;
use Illuminate\Support\Facades\Auth;

class CreateComment extends Component
{

    public $blog_id;
    public $user_id;
    public $body;
    public $notifiedUser;
    public $slug;
    public function mount($blog)
    {
        $this->blog_id = $blog->id;
        $this->user_id = Auth::id();
        $this->notifiedUser =  $blog->user;
        $this->slug = $blog->slug;
    }

    public function rules()
    {
        return ([
            'user_id' => 'required',
            'blog_id' => 'required',
            'body' => 'required|string|max:120'
        ]);
    }

    public function submit()
    {
        $this->validate();

        Comment::create([
            'user_id' => $this->user_id,
            'blog_id' => $this->blog_id,
            'body' => $this->body,
        ]);


        $this->notifiedUser->notify(new BlogComment('commented', Auth::id(), $this->slug));

        return redirect()->route('blogs.show', $this->slug);
    }


    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
