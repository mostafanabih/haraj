<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\AdvertiserContacts;
use App\AdvertiserRatings;
use App\Advs;
use App\Area;
use App\City;
use App\Followers;
use App\Notification_;
use App\Haraj_One_Info;
use App\Subscriptions;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use mody\smsprovider\Facades\SMSProvider;

class HomeController extends Controller
{
    /** static functions */
    public static function get_messages(){
        $messages = AdvertiserContacts::where('to_id', auth()->id())
            ->where('parent_id', 0)->where('reading', 0)->get();
        return $messages->count();
    }

    public static function get_advertiser_rating($advertiser_id)
    {
        $rating_sum = AdvertiserRatings::where('advertiser_id', $advertiser_id)->sum('rating');
        $advertiser_num = AdvertiserRatings::where('advertiser_id', $advertiser_id)->get();
        if ($advertiser_num->count() == 0) {
            $num_formate = number_format($rating_sum, 1);
        } else {
            $num_formate = number_format($rating_sum / $advertiser_num->count(), 1);
        }
        return $num_formate;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertiser = Advertiser::findOrFail(auth()->id());
        $followers = Followers::where('advertiser_id', auth()->id())->get();
        $ratings = AdvertiserRatings::where('advertiser_id', auth()->id())->get();

        $area = Area::all();
        $cities = City::where('area_id', $advertiser->area)->get();
//        $advs = Advs::where('advertiser_id', auth()->id())
//            ->orderBy('created_at', 'desc')
//            ->paginate(10);
        return view('home.home')
            ->with(array(
                'advertiser' => $advertiser,
//                'advs' => $advs,
                'followers' => $followers,
                'ratings' => $ratings,
                'area' => $area,
                'cities' => $cities,
            ));
    }

    public function messages()
    {
        $messages = AdvertiserContacts::where('parent_id', 0)
            ->where(function ($q){
                $q->where('from_id', auth()->id());
                $q->orWhere('to_id', auth()->id());
            })->paginate(10);

        $active_messages = AdvertiserContacts::where('to_id', auth()->id())
            ->where('parent_id', 0)->where('reading', 0)->get();
        if(count($active_messages) > 0){
            foreach($active_messages as $active){
                $active->update(['reading' => 1]);
                $notifys = Notification_::where('adv_id', $active->id)->where('type', 1)->where('reading', 0)->get();
                if($notifys->count() > 0){$notifys->each->update(['reading' => 1]);}
            }
        }


        return view('home.my_messages')
            ->with(array(
                'messages' => $messages,
            ));
    }

    public function messagesDelete(Request $request)
    {
        $msg = AdvertiserContacts::where('id', $request->msg_id)
            ->orWhere('parent_id', $request->msg_id)->get();

        if(count($msg) > 0){
            foreach($msg as $m){
                $notify = Notification_::where(function ($q1) use ($m){
                    $q1->where('advertiser_id', $m->to_id);
                    $q1->orWhere('advertiser_id', $m->from_id);
                })->where(function ($q2){
                    $q2->where('type', 1);
                    $q2->orWhere('type', 5);
                })->get();

                if(count($notify) > 0){$notify->each->delete();}
            }
        }

        $msg->each->delete();


        if (!$msg) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم الحذف بنجاح');
        }
    }

    public function get_reply($id){
        $main_msg = AdvertiserContacts::findOrFail($id);

        $msgs = AdvertiserContacts::where(function ($q1) use ($id){
            $q1->where('id', $id);
            $q1->orWhere('parent_id', $id);
        })->orderBy('id', 'asc')->get();

        $active_messages = AdvertiserContacts::where('parent_id', $id)
            ->where('reading', 0)->get();
        if(count($active_messages) > 0){
            foreach($active_messages as $active){
                if($active->to_id == auth()->id()){
                    $notifys = Notification_::where('adv_id', $active->parent_id)
                        ->where('advertiser_id', $active->to_id)
                        ->where('type', 5)->where('reading', 0)->get();
                    if($notifys->count() > 0){$notifys->each->update(['reading' => 1]);}
                    $active->update(['reading' => 1]);
                }
            }
        }

        return view('home.reply')->with(array(
            'main_msg' => $main_msg,
            'msgs' => $msgs
        ));
    }

    public function send_reply(Request $request){
        $data = array(
            'msg' => $request->msg,
            'name' => $request->name,
        );

        Mail::send('mail.msg_reply', $data, function($message) use ($request){
            $message->from($request->advertiser_email, $request->advertiser_name);
            $message->to($request->e_mail, $request->name)
                ->subject($request->adv_title);
        });

        return redirect('/messages')->with('success', 'تم الرد على الرسالة بنجاح');
//        if(!$action) {
//            return redirect('/contact_us')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
//        } else {
//            return redirect('/contact_us')->with('success', 'تم الرد على الرسالة بنجاح');
//        }
    }


    public function doLogin(Request $request)
    {
        $messages = [
            'name.required' => 'يرجي ادخال البريد الالكتروني او الهاتف',
            'pass.required' => 'الرقم السري مطلوب',
        ];
        $this->validate($request, [
            'name' => 'required',
            'pass' => 'required',
        ], $messages);

        $user = User::where(function ($q) use ($request) {
            $q->where('e_mail', $request->name);
            $q->orWhere('mobile', $request->name);
        })->where('black_list', 0)
            ->where('agree', 1)
            ->first();

        if ($user) {
            $user_pass = $user->password;
            $typed = $request->pass;
            $remember_me = $request->remember_me;

            if (Hash::check($typed, $user_pass)) {
                if ($user->active_code == null) {

                    if(is_numeric($request->name)){
                        $cardients = ['mobile'=>$request->name,'password'=>$request->pass];
                    }
                    elseif (filter_var($request->name, FILTER_VALIDATE_EMAIL)) {
                        $cardients = ['e_mail' => $request->name, 'password'=>$request->pass];
                    }
                    else{
                        $cardients = ['name' => $request->name, 'password'=>$request->pass];
                    }

                    if(Auth::attempt($cardients, $remember_me)){
                        Auth::login($user);

                        // last activity
//                    Advertiser::findOrFail($user->id)
//                        ->update(['last_activity' => Carbon::now()]);

                        $code = auth()->user()->mobile;

                        $check = preg_match('/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', $code);

                        if(! $check){
                            session()->put('update_phone', '1');
                        }
                        // roles
                        if ($user->roles == 1) {
                            return redirect('/dashboard');
                        } else {
                            if ($user->marked == 1) {
                                $subscription = Subscriptions::where('advertiser_id', $user->id)->first();
                                $today = Carbon::now();
                                if ($today->gt($subscription->end_date)) {
                                    $user->update(['marked' => 0]);
                                    $subscription->delete();
                                } else {
                                    return redirect('/home');
                                }
                                return redirect('/add_subscription');
                            } else {
                                return redirect('/home');
                            }
                        }
                    }




                } else {
                    return back()->with([
                        'resend' => 'الحساب غير مفعل',
                        'msg1' => $user->id
                    ]);
                }

            } else {
                return back()->with(['error' => 'كلمة المرور أو البريد الإلكترونى غير صحيح']);
            }
        } else {
            return back()->with(['error' => 'لا يوجد حساب مطابق']);
        }

        /*
              $check = Auth::attempt(['mobile' => $request->name, 'password' => $request->pass]);
              if ($check) {
                  $user = User::where('mobile', $request->name)->first();
                  Auth::login($user);
                  return redirect('/home');
              }
              else {
                  $check2 = Auth::attempt(['e_mail' => $request->name, 'password' => $request->pass]);
                  if ($check2) {
                      $user = User::where('e_mail', $request->name)->first();
                      Auth::login($user);
                      return redirect('/home');
                  } else {
                      return route('login');
                  }
              }
      */

    }

    public function doRegister(Request $request)
    {
        $messages = [
            'name.unique' => 'هذا الاسم مستخدم من قبل',
            'mobile.unique' => 'هذا الجوال مستعمل من قبل',
            'pass.min' => 'يجب إدخال كلمة المرور كحد أدنى 6 حروف أو أرقام',
            'pass.confirmed' => 'تأكيد كلمة المرور غير مشابه لكلمة المرور',
            'e_mail.unique' => 'هذا البريد الإلكترونى مستعمل من قبل',
        ];

        $this->validate($request, [
            'mobile' => 'ksa_phone|unique:advertisers',
            'e_mail' => 'email|required|unique:advertisers',
            'name' => 'required|max:120|unique:advertisers',
            'pass' => 'required|min:6|confirmed',
//            'area' => 'required',
//            'city' => 'required',
//            'street' => 'required|max:255',
//            'address' => 'required',
//            'lat' => 'required',
//            'lon' => 'required',
        ], $messages);

      

//         $active_code = rand(000000, 999999);
        $active_code = null;
        $users = new User();
        $users->active_code = $active_code;
        $users->mobile = $request->mobile;
        $users->name = $request->name;
        $users->e_mail = $request->e_mail;
        $users->password = Hash::make($request->pass);
//        $users->agree = $request->agree1 * $request->agree2 * $request->agree3;
        $users->agree = 1;

//        $users->area = $request->area;
//        $users->city = $request->city;
//        $users->street = $request->street;
//
//        if($request->filled('address')){
//            $users->address = $request->address ?? '';
//            $users->lat = $request->lat ?? null;
//            $users->lon = $request->lon ?? null;
//        }else{
//            $users->address = '';
//            $users->lat = null;
//            $users->lon = null;
//        }

        $action = $users->save();


       

        if (!$action) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/login')->with(['success' => 'تم إنشاء الحساب بنجاح ... يمكنك الدخول مباشرة الأن']);
//            $res_sms = 'فشل ارسال كود التفعيل اطلب كود اخر';
//            return redirect()->back()->with(['error' => $res_sms]);

//            $msg = 'كود التفعيل الخاص بك: ' . "$active_code";
//            $sms = SMSProvider::sendSMS($msg, $users->mobile);
//
//            if ($sms == '1') {
//                $res_sms = 'تم ارسال كود التفعيل';
//                return redirect()->back()->with(['success' => $res_sms]);
//            } else {
//                $res_sms = 'فشل ارسال كود التفعيل اطلب كود اخر';
//                return redirect()->back()->with(['error' => $res_sms]);
//            }

//         $data = array(
//            'active_code' => $active_code,
//            'name' => $request->name,
//            'img' => Haraj_One_Info::findOrFail(1)->logo
//        );
//        return redirect('/login')->with(['success' => 'تم إنشاء الحساب بنجاح']);
//        Mail::send('mail.mail', $data, function($message) use ($request){
//            $message->to($request->e_mail)
//                ->subject('تفعيل الحساب - حراج واحد');
//        });
//
//        return redirect()->back()->with(['success' => 'تم الحفظ وارسال كود التفعيل الي بريدك الالكتروني']);
        }
    }

    public function RegisterByAdmin(Request $request)
    {
        $messages = [
            'name.unique' => 'هذا الاسم مستخدم من قبل',
            'mobile.unique' => 'هذا الجوال مستعمل من قبل',
            'pass.min' => 'يجب إدخال كلمة المرور كحد أدنى 6 حروف أو أرقام',
            'pass.confirmed' => 'تأكيد كلمة المرور غير مشابه لكلمة المرور',
            'e_mail.unique' => 'هذا البريد الإلكترونى مستعمل من قبل',
        ];

        $this->validate($request, [
            'mobile' => 'required|ksa_phone|unique:advertisers',
            'name' => 'required|max:120|unique:advertisers',
            'pass' => 'required|min:6|confirmed',
            'address' => 'required',
        ], $messages);

        if($request->filled('e_mail')){
            $this->validate($request, [
                'e_mail' => 'email|unique:advertisers'
            ], $messages);
        }

//        do
//        {
//            $alpha_code = random_int(000, 999).$this->generateRandomString2(3);
//            $user_code = User::where('user_code', $alpha_code)->first();
//        }
//        while(!empty($user_code));

        $users = new User();
//        $users->user_code = $alpha_code;
        $users->e_mail = $request->e_mail;
        $users->name = $request->name;
//        $users->personal_name = $request->personal_name;
        $users->password = Hash::make($request->pass);
        $users->mobile = $request->mobile;
        $users->address = $request->address;
//        $users->membership_id = 1;
//        $all_points = Points::findOrFail(1)->num_points+Points::findOrFail(6)->num_points;
//        $users->points = $all_points;

        if ($request->has('admin')) {
            $users->roles = 1;
            $users->type_of_roles = 0;
        }
        $users->agree = 1;
        $action = $users->save();


        if (!$action) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تمت اضافة المعلن بنجاح');
        }
    }


    public function show_confirm()
    {
        return view('mail.mail_confirm');
    }

    public function confirm(Request $request)
    {
        $this->validate($request, [
            'confirm_' => 'required',
        ]);

        $advertiser = Advertiser::findOrFail($request->advertiser_id);
        if ($advertiser->active_code == $request->confirm_) {
            session()->forget('active_code');
            session()->forget('id');

            $advertiser->active_code = null;
            $advertiser->save();
            return back()->with('success_login', 'كود التفعيل صحيح يمكنك الأن الدخول لحسابك');
        } else {
            return back()->with('error', 'كود التفعيل الذى أدخلته غير صحيح ... حاول مرة أخرى');
        }
    }


    public function forget_password_view()
    {
        return view('password_operations.forget_password');
    }
    public function active_view()
    {
        return view('password_operations.active');
    }

    public function forget_password(Request $request)
    {
        $this->validate($request, [
            'e_mail' => 'email|required',
        ], [
            'e_mail.required' => 'البريد الالكتروني مطلوب',
        ]);

        $advertiser = Advertiser::where('e_mail', $request->e_mail)->first();
        if ($advertiser and $advertiser->e_mail != null) {
            $forget_code = rand(100000, 999999);
            $data = array(
                'active_code' => $forget_code,
                'name' => $advertiser->name,
                'img' => Haraj_One_Info::findOrFail(1)->logo
            );
            Mail::send('mail.mail2', $data, function ($message) use ($request) {
                $message->to($request->e_mail)
                    ->subject('  حراج واحد');
            });

            session(['forget_code' => $forget_code]);
            session(['forget_id' => $advertiser->id]);
           
                $res_sms = 'تم ارسال كود استرجاع كلمة المرور';
                return redirect('/reset_password')->with(['success' => $res_sms]);
           

        } else {
            return back()->with('error', 'البريد الالكتروني غير صحيح');
        }
    }


    public function reset_password_view()
    {
        return view('password_operations.reset_password');
    }

    public function reset_password(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'pass' => 'required|confirmed',
        ]);

        if (session('forget_code') == $request->code) {
            $advertiser = Advertiser::findOrFail($request->advertiser_id);
            session()->forget('forget_code');
            session()->forget('forget_id');

            $advertiser->password = Hash::make($request->pass);
            $advertiser->save();
            return redirect('/login')->with('success', 'كود التفعيل صحيح يمكنك الأن الدخول بكلمة المرور الجديدة');
        } else {
            return back()->with('error', 'كود التفعيل الذى أدخلته غير صحيح');
        }
    }

    public function resend_active_code($id)
    {
        $advertiser = Advertiser::where('id', $id)->first();
        if ($advertiser) {
           $data = array(
                'active_code' => $advertiser->active_code,
                'name' => $advertiser->name,
                'img' => Haraj_One_Info::findOrFail(1)->logo
            );
            Mail::send('mail.mail', $data, function ($message) use ($advertiser) {
                $message->to($advertiser->e_mail)
                    ->subject('Haraj One Email Re-Confirm');
            });
            session(['active_code' => $advertiser->active_code]);
            session(['id' => $advertiser->id]);
            return redirect('/mail_confirm');

        } else {
            return back()->with('error', 'البريد الالكتروني غير صحيح');
        }
        
        
    }

    public function resend_code(Request $request)
    {
        
        $advertiser = Advertiser::where('e_mail', $request->e_mail)->first();
        if ($advertiser) {
           $data = array(
                'active_code' => $advertiser->active_code,
                'name' => $advertiser->name,
                'img' => Haraj_One_Info::findOrFail(1)->logo
            );
            Mail::send('mail.mail', $data, function ($message) use ($advertiser) {
                $message->to($advertiser->e_mail)
                    ->subject('Haraj One Email Re-Confirm');
            });
            session(['active_code' => $advertiser->active_code]);
            session(['id' => $advertiser->id]);
            return redirect('/mail_confirm');

        } else {
            return back()->with('error', 'البريد الالكتروني غير صحيح');
        }
        
        
    }

    function generateRandomString2($length = 3)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function change_pass(Request $request){
        $this->validate($request, [
            'old_pass' => 'required',
            'pass' => 'required|confirmed',
        ]);
        $advertiser = Advertiser::findOrFail($request->advertiser_id);

        if(Hash::check($request->old_pass, $advertiser->password)){
            $advertiser->password = Hash::make($request->pass);
            $advertiser->save();
            return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح');
        }
        else{
            return back()->with('error', 'كلمة المرور القديمة خطأ');
        }
    }


}
