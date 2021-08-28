<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    protected $table = "subscriptions";

    protected $fillable = [
        'advertiser_id', 'package_id',
    ];

    public function package()
    {
        return $this->belongsTo(Packages::class);
    }

    public function Advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }


}
