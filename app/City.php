<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";


    public function newQuery(){
        return parent::newQuery()->whereHas('Area');
    }

    public function Advs()
    {
        return $this->hasMany('App\Advs', 'city', 'id');
    }
    public function Area()
    {
        return $this->belongsTo('App\Area', 'area_id', 'id');
    }
}
