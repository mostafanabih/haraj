<?php

namespace App\Providers;

use App\Advertiser;
use Carbon\Carbon;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Validator::extend('ksa_phone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', $value);
        });

        if(Auth::check()){
            // last activity
            Advertiser::findOrFail(Auth::id())
                ->update(['last_activity' => Carbon::now()]);

            $code = auth()->user()->mobile;
            $check = preg_match('/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', $code);

            if (!$check) {
                session()->put('update_phone', '1');
            }else{
                if(session()->has('update_phone')){
                    session()->forget('update_phone');
                }
            }
        }
        
           
        $api_check = request()->segment(1);

        if ($api_check == "api") {
          $this->app['request']->server->set('HTTPS', false);

        }



        Carbon::setLocale('ar');
        // date_default_timezone_set('Asia/Riyadh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once __DIR__ . '/../Helpers/Helper.php';
    }
}
