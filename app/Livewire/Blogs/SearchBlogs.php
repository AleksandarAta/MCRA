<?php

namespace App\Livewire\Blogs;

use App\Models\Blog;
use Livewire\Component;


class SearchBlogs extends Component
{
    public $search = '';
    public $blogs;
    public function render()
    {
        if (strlen($this->search) >= 3) {
            $this->blogs = Blog::where('title', 'LIKE', '%' . $this->search . "%")
                ->orWhere('keywords', 'LIKE', '%' . $this->search . "%")
                ->orWhere('body', 'LIKE', '%' . $this->search . "%")
                ->orWhere('keywords', 'LIKE', '%' . $this->search . "%")
                ->OrWhereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })->limit(3)->get();
        }

        return view('livewire.blogs.search-blogs', [
            'blogs' => $this->blogs,
        ]);
    }
}
