<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    protected $table = "followers";

    protected $fillable=[
        'advertiser_id','follower_id'
    ];

    public function advertiser(){
        return $this->hasOne('App\Advertiser', 'id', 'follower_id');
    }
}
