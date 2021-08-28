<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatChannel extends Model
{
    protected $table = 'chat_channels';

    protected $fillable = [
        'user_id','friend_id','user_active','friend_active'
    ];
}
