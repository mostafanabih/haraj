<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    protected $tabel = "advertisers";

    protected $fillable = [
        'black_list', 'marked', 'active_code', 'e_mail', 'last_activity','player_id', 'agree', 'special'
    ];

    public function Advs()
    {
        return $this->hasMany(Advs::class);
    }

    public function black_list()
    {
        return $this->hasOne(BlackList::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscriptions::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification_::class);
    }



    public static function can_me($permission = null)
    {
        if(is_null($permission)) return false;
        $permissions_roles = Permission_role::where('admin_id', auth()->id())->select('permission_id')->get();
       // dd($permissions_roles, auth()->user());
        $permission_role = '';
        foreach($permissions_roles as $k){
            $permission_role .= $k->permission_id.',';
        }
        $permission_role_ = explode(',', rtrim($permission_role,","));
        if(auth()->check() and (auth()->user()->type_of_roles == 1 or in_array($permission, $permission_role_))){
            return true;
        }else{
            return false;
        }
    }
}
