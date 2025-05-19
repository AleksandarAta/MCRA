<?php

namespace App\Livewire\Blogs;

use Livewire\Component;
use Livewire\Attributes\On;

class ShowBlog extends Component
{
    public $blog;
    public $comments;

    #[On('refresh')]
    public function refresh() {}

    public function mount($blog, $comments)
    {
        $this->blog = $blog;
        $this->comments = $comments;
    }
    public function render()
    {
        return view('livewire.blogs.show-blog', [
            'blog' => $this->blog,
            'comments' => $this->comments,

        ]);
    }
}
