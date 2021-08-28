<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiserFavourite extends Model
{
    protected $table = "advertiser_favourite";

    protected $fillable = [
        'advertiser_id', 'favourite_advertiser',
    ];
}
