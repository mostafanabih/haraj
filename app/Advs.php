<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Advs extends Model
{
    protected $table = "advs";

    protected $hidden = ['created_at', 'updated_at'];
    
    // public $timestamps = false;

    protected $fillable = [
        'views',
    ];

//    public function getCreatedAtAttribute($value)
//    {
//        // application's timezone
//        $timezone =  Config::get('app.timezone');
//
////        return Carbon::createFromTimestamp(strtotime($value))
////            ->timezone($timezone)->toDateTimeString();
//        return Carbon::parse($value, $timezone)
//            ->timezone($timezone);
//    }
//    public function getUpdatedAtAttribute($value)
//    {
//        // application's timezone
//        $timezone =  Config::get('app.timezone');
//
////        return Carbon::createFromTimestamp(strtotime($value))
////            ->timezone($timezone)->toDateTimeString();
//        return Carbon::parse($value, $timezone)
//            ->timezone($timezone);
//    }

    public function newQuery()
    {
        return parent::newQuery()->whereHas('City');
    }

    public function Adv_Img()
    {
        return $this->hasMany('App\AdvImgs', 'adv_id');
    }

    public function City()
    {
        return $this->belongsTo('App\City', 'city', 'id');
    }

    public function Advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }
}
