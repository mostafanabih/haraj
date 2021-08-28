<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiserContacts extends Model
{
    protected $table = "advertiser_contacts";

    protected $fillable = [
        'reading',
    ];

    public function FromAdvertiser()
    {
        return $this->belongsTo('App\Advertiser', 'from_id', 'id');
    }

    public function ToAdvertiser()
    {
        return $this->belongsTo('App\Advertiser', 'to_id', 'id');
    }

}
