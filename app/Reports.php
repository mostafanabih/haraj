<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $table = "reports";

    protected $fillable = [
        'advertiser_id', 'adv_id', 'c_r_type', 'c_r_id', 'c_r_voter_id', 'reason_id', 'reporter_id',
    ];

    public function Advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    public function Advs()
    {
        return $this->belongsTo('App\Advs', 'adv_id', 'id');
    }

    public function C_R()
    {
        return $this->belongsTo('App\AdvRatings', 'c_r_id', 'id');
    }

    public function Reporting_Reasons()
    {
        return $this->belongsTo('App\ReportingReasons', 'reason_id', 'id');
    }

    public function Reporter()
    {
        return $this->belongsTo('App\Advertiser', 'reporter_id', 'id');
    }
}
