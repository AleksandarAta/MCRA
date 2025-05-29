<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messeges extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class, "chatRoom_id");
    }
}
