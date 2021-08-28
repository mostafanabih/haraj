<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvImgs extends Model
{
    protected $table = "adv_imgs";

    protected $fillable = [
        'adv_id', 'img', 'updated_at',
    ];

    protected $hidden= ['created_at' , 'updated_at'];
}
