<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    protected $table = "black_list";

    public function Advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }
}
