<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainSection extends Model
{
    protected $table = "main_section";

    protected $fillable =[
        'name', 'img'
    ];

    protected function SubSection(){
        return $this->hasMany('App\SubSection','main_id','id');
    }

    protected function InternalSection(){
        return $this->hasManyThrough('InternalSection' ,'SubSection' ,'sub_id','main_id','id','id');
    }
}
