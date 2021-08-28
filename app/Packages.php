<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = "packages";

    public function subscription()
    {
        return $this->hasMany(Subscriptions::class);
    }

}
