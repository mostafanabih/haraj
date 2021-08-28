<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';

    protected $fillable = [
        'id',
        'channel_id',
        'sender_id',
        'message',
        'photo_name',
        'video_name',
    ];


    public function advertiser(){
        return $this->belongsTo('App\Advertiser','sender_id','id');
    }

}
