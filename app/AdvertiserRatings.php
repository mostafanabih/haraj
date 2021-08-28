<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiserRatings extends Model
{
    protected $table = "advertiser_ratings";

    protected $fillable = [
        'rating', 'advertiser_id', 'voter_id',
    ];
}
