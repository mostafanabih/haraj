<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalSection extends Model
{
    protected $table = "internal_section";

    protected $fillable=[
        'name', 'main_id', 'sub_id', 'img',
    ];


    protected function SubSection()
    {
        return $this->belongsTo('App\SubSection', 'sub_id', 'id');
    }
    protected function MainSection(){

        return $this->belongsTo('App\MainSection','sub_id','id');
    }
}
