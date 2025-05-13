<?php

namespace App\Livewire\Blogs\Admin;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

    public $order_by= 'id';
    public $order_type = 'asc';

    public function togglePublish($blogId) {
        $blog = Blog::findOrFail($blogId);

        if(!$blog->publish){
            $blog->publish = true;
        }
        else {
         $blog->publish = false;
        }

        $blog->save(); 
    }
        public function orderBy($order){

            if($this->order_by != $order){
                $this->order_by = $order;
                $this->order_type = 'asc';
            }else {
                if($this->order_type == 'asc')
                    $this->order_type = 'desc';
                else {
                    $this->order_type = 'asc';
                }
            }

        }


    public function render()
    {

        $blogs = Blog::with('user')->orderBy($this->order_by , $this->order_type)->paginate(10);


        return view('livewire.blogs.admin.index', [
          'blogs' => $blogs,
    ]);
    }
}
