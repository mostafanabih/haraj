<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\Notification_;
use App\Packages;
use App\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class subscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Packages::orderBy('duration', 'asc')->orderBy('price', 'asc')->get();
        $subscription = Subscriptions::where('advertiser_id', auth()->id())->first();
        return view('subscriptions.add_subscription')->with(array(
            'subscription' => $subscription,
            'packages' => $packages,
        ));
    }
    public function add_subscription(Request $request)
    {
        $subscription = Subscriptions::updateOrCreate(
            [
                'advertiser_id' => $request->advertiser_id,
            ],
            [
                'advertiser_id' => $request->advertiser_id,
                'package_id' => $request->package_id
            ]
        );
        $action = $subscription->save();

        $notify = new Notification_();
        $notify->content = 'تمت الموافقة على طلب اشتراكك بنجاح';
        $notify->adv_id = 0;
        $notify->advertiser_id = $request->advertiser_id;
        $notify->type = 8;
        $action2 = $notify->save();

        $user_notify = Advertiser::findOrFail($request->advertiser_id);
        if ($user_notify->player_id != null or $user_notify->player_id != '') {
            $tokens = [$user_notify->player_id];
            $content = $notify->content;
            $data = ['type' => $notify->type];
            sendNote($tokens, $content, $data);
        }



        if (!$action or !$action2) {
            return redirect('/add_subscription')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/add_subscription')->with('success', 'تم ارسال طلبك بنجاح وجارى مراجعته');
        }
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
        //
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
        $duration = $request->duration;
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addMonths($duration)->addMinutes(1);

        $subscription = Subscriptions::findOrFail($id);
        $subscription->start_date = $start_date;
        $subscription->end_date = $end_date;
        $action = $subscription->save();

        $advertiser_update = Advertiser::findOrFail($request->advertiser_id)
            ->update(['marked' => 1]);

        if (!$action or !$advertiser_update) {
            return redirect('/register-request')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/register-request')->with('success', 'تم تفعيل الإشتراك بنجاح');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $action = Subscriptions::findOrFail($id);

        $notify = new Notification_();
        $notify->content = 'نعتذر ولكن تم رفض طلب اشتراكك';
        $notify->adv_id = 0;
        $notify->advertiser_id = $action->advertiser_id;
        $notify->type = 9;
        $action2 = $notify->save();

        $user_notify = Advertiser::findOrFail($action->advertiser_id);
        if ($user_notify->player_id != null or $user_notify->player_id != '') {
            $tokens = [$user_notify->player_id];
            $content = $notify->content;
            $data = ['type' => $notify->type];
            sendNote($tokens, $content, $data);
        }

        $action_ = $action->delete();

        if (!$action_ or !$action2) {
            return redirect('/register-request')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/register-request')->with('success', 'تم الحذف بنجاح');
        }
    }
}
