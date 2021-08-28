<?php

namespace App\Http\Controllers;

use App\Notification_;
use Illuminate\Http\Request;

class AdvertiserNotifyController extends Controller
{
    public static function get_notify($advertiser_id){
        $notify = Notification_::where('advertiser_id', $advertiser_id)
            ->where('reading', 0)
            ->orderBy('updated_at', 'desc')
            ->get();
        return $notify->count();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notify = Notification_::where('advertiser_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $notifys = Notification_::where('advertiser_id', auth()->id())
            ->where('reading', 0)->get();
        if($notifys->count() > 0){$notifys->each->update(['reading' => 1]);}

        return view('home.notify')->with('notify', $notify);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification_::findOrFail($id);
        $notification->update(['reading' => 1]);
        if($notification->type == 1){
            return redirect('/messages');
        }
        elseif($notification->type == 2){
            return redirect('adv/'.$notification->adv_id);
        }
        elseif($notification->type == 3){
            return redirect('adv/'.$notification->adv_id);
        }
        elseif($notification->type == 4){
            return redirect('adv/'.$notification->adv_id);
        }
        elseif($notification->type == 5){
            return redirect('reply/'.$notification->adv_id);
        }
        elseif($notification->type == 6){
            return redirect('/home');
        }
        elseif($notification->type == 7){
            return redirect('/home');
        }
        elseif($notification->type == 8){
            return redirect('/add_subscription');
        }
        elseif($notification->type == 9){
            return redirect('/add_subscription');
        }
        else{
            return view('dashboard.notification.show_notification')->with(array(
                'notification' => $notification,
            ));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
