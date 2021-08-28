<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSection extends Model
{
    protected $table = "sub_section";

    protected $fillable = [
        'name', 'img', 'main_id',
    ];

    protected function MainSection()
    {
        return $this->belongsTo('App\MainSection', 'main_id', 'id');
    }
    protected function InternalSection(){
        return $this->hasMany('App\InternalSection','sub_id','id');
    }
}
