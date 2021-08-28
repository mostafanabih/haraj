<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = "favorite_advs";

    protected $fillable=[
        'advertiser_id','adv_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function advs()
    {
        return $this->belongsTo(Advs::class, 'adv_id');
    }

}
