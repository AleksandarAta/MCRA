<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $guarded = [];
    public function firend()
    {
        return $this->belongsTo(User::class, 'friends', 'friend_id');
    }
}
