<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification_ extends Model
{
    protected $table = "notification";

    protected $fillable = [
        'content', 'reading', 'advertiser_id', 'adv_id', 'type', 'created_at', 'updated_at',
    ];

    public function Advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

}
