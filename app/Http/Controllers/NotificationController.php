<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\Advs;
use App\Notification_;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /** ajax functions  >>  on change */
    public function adv_search(Request $request)
    {
        $advs_ = Advs::find($request->adv_id);
        if ($advs_) {
            $data = '<span class="text-success">' . 'الإعلان : (' . $advs_->title . ')' . '</span>
            <input type="hidden" name="advertiser_id" value="' . $advs_->advertiser_id . '">';
        } else {
            $data = '<span class="text-danger">رقم الإعلان الذى أدخلته غير صحيح</span>';
        }

        return response()->json($data);
    }

    public function get_advertiser_notification()
    {
        $advertisers = Advertiser::where('black_list', 0)->get();
        return view('dashboard.notification.add_advertiser_notification')->with(array(
            'advertisers' => $advertisers,
        ));
    }

    public function add_advertiser_notification(Request $request)
    {
        if ($request->type == 1) {
            $this->validate($request, [
                'content_' => 'required',
                'advertiser' => 'required',
                'type' => 'required',
            ]);

            $notify = new Notification_();
            $notify->content = $request->content_;
            $notify->adv_id = 0;
            $notify->advertiser_id = $request->advertiser;
            $notify->type = 0;
            $action = $notify->save();

            $user_notify = Advertiser::findOrFail($request->advertiser);
            if ($user_notify->player_id != null or $user_notify->player_id != '') {
                $tokens = [$user_notify->player_id];
                $content = $notify->content;
                $data = ['type' => $notify->type];
                sendNote($tokens, $content, $data);
            }
        }
        else {
            $this->validate($request, [
                'content_' => 'required',
                'type' => 'required',
            ]);
            $advertisers = Advertiser::where('black_list', 0)->get();
            foreach ($advertisers as $advertiser) {
                $notify = new Notification_();
                $notify->content = $request->content_;
                $notify->adv_id = 0;
                $notify->advertiser_id = $advertiser->id;
                $notify->type = 0;
                $action = $notify->save();

                if ($advertiser->player_id != null or $advertiser->player_id != '') {
                    $tokens = [$advertiser->player_id];
                    $content = $notify->content;
                    $data = ['type' => $notify->type];
                    sendNote($tokens, $content, $data);
                }
            }
        }
        if (!$action) {
            return redirect('/notification')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/notification')->with('success', 'تم إرسال الإشعار بنجاح');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notification = Notification_::orderBy('updated_at', 'desc')->paginate(25);
        return view('dashboard.notification.notification')->with(array(
            'notification' => $notification,
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.notification.add_notification');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->type == 1) {
            $this->validate($request, [
                'content_' => 'required',
                'adv_id' => 'required',
                'type' => 'required',
            ]);

            $notify = new Notification_();
            $notify->content = $request->content_;
            $notify->adv_id = $request->adv_id;
            $notify->advertiser_id = $request->advertiser_id;
            $notify->type = 0;
            $action = $notify->save();

            $user_notify = Advertiser::findOrFail($request->advertiser_id);
            if ($user_notify->player_id != null or $user_notify->player_id != '') {
                $tokens = [$user_notify->player_id];
                $content = $notify->content;
                $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
                sendNote($tokens, $content, $data);
            }

            if (!$action) {
                return redirect('/notification')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
            } else {
                return redirect('/notification')->with('success', 'تم إرسال الإشعار بنجاح');
            }
        } else {
            $this->validate($request, [
                'content_' => 'required',
                'type' => 'required',
            ]);
            $advertisers = Advertiser::where('black_list', 0)->get();
            foreach ($advertisers as $advertiser) {
                $notify = new Notification_();
                $notify->content = $request->content_;
                $notify->adv_id = 0;
                $notify->advertiser_id = $advertiser->id;
                $notify->type = 0;
                $notify->save();

                $user_notify = Advertiser::findOrFail($advertiser->id);
                if ($user_notify->player_id != null or $user_notify->player_id != '') {
                    $tokens = [$user_notify->player_id];
                    $content = $notify->content;
                    $data = ['type' => $notify->type];
                    sendNote($tokens, $content, $data);
                }


            }
            return redirect('/notification')->with('success', 'تم إرسال الإشعار بنجاح');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = Notification_::findOrFail($id);
        $adv = Advs::findOrFail($notification->adv_id);
        return view('dashboard.notification.update_notification')->with(array(
            'notification' => $notification,
            'adv' => $adv,
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content_' => 'required',
            'adv_id' => 'required',
        ]);

        $notify = Notification_::findOrFail($id);
        $notify->content = $request->content_;
        $notify->adv_id = $request->adv_id;
        $notify->advertiser_id = $request->advertiser_id;
        $notify->reading = 0;
        $action = $notify->save();

        if (!$action) {
            return redirect('/notification')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/notification')->with('success', 'تم تعديل الإشعار و إرساله بنجاح');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $action = Notification_::findOrFail($id)->delete();

        if (!$action) {
            return redirect('/notification')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/notification')->with('success', 'تم حذف الإشعار بنجاح');
        }
    }
}
