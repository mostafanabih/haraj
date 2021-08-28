<?php

namespace App\Http\Middleware;

use App\Advertiser;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class Visitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Advertiser::findOrFail(Auth::id())
                ->update(['last_activity' => Carbon::now()]);
        }

        return $next($request);
    }
}
