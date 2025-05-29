<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\On;

class DeleteModal extends Component
{
    public $model_to_delete = "";
    public $model_status = 'hidden';
    public $model_id;

    #[On('deleteComment')]
    public function deleteComment($commentId)
    {
        $this->model_to_delete = 'comment';
        $this->model_status = 'show';
        $this->model_id = $commentId;
    }

    public function confirmDeleteComment($commentId)
    {
        $comment = Comment::findOrfail($commentId);
        $comment->delete();
        $this->hide();
        $this->dispatch('refresh');
    }

    public function hide()
    {
        $this->model_to_delete = '';
        $this->model_status = 'hidden';
        $this->model_id = '';
    }


    public function render()
    {
        return view('livewire.delete-modal');
    }
}
