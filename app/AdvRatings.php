<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvRatings extends Model
{
    protected $table = "adv_ratings";

    protected $fillable = [
            'adv_id', 'voter_id', 'rating', 'reply', 'type',
        ];

    public function Rater()
    {
        return $this->belongsTo('App\Advertiser','voter_id' ,'id');
    }
}
