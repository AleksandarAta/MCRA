<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    /** @use HasFactory<\Database\Factories\ChatRoomFactory> */
    use HasFactory;
    protected $guarded = [];
}
