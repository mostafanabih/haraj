<?php

namespace App\Http\Controllers\api;

use App\Advertiser;
use App\Http\Controllers\Controller;
use App\Haraj_One_Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $rules = [
            'name' => 'required',
            'password' => 'required',
            'player_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error_data = [];
            foreach ($errors->all() as $error) {
                array_push($error_data, $error);
            }
            $data = $error_data;

            return response()->json([
                'status' => false,
                'errors' => $data
            ]);
        } else {
            $user = Advertiser::where(function ($q) use ($request) {
                $q->where('e_mail', $request->name);
                $q->orWhere('mobile', $request->name);
                $q->orWhere('name', $request->name);
            })->where('black_list', 0)->first();

            $token = str_random(60);

            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->active_code == null) {

                        $user->api_token = $token;
                        $user->player_id = $request->player_id;
                        $user->save();

                        if (is_null($user->img)) {
                            $user->img = url('') . '/public/img/no_img.png';
                        } else {
                            if (file_exists('public/img/advertiser_imgs/' . $user->img)) {
                                $user->img = url('') . '/public/img/advertiser_imgs/' . $user->img;
                            } else {
                                $user->img = url('') . '/public/img/no_img.png';
                            }
                        }
                        unset($user->password,$user->address,$user->lat,$user->lon);

                        return response()->json([
                            'status' => true,
                            'data' => $user,
                            'active' => true
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'برجاء تفعيل حسابك اولا',
                            'active' => false,
                            'advertiser_id' => $user->id
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'كلمه المرور غير صحيحه'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'المستخدم غير موجود'
                ]);
            }
        }
    }

    public function Logout(Request $request)
    {
        $advertiser = Advertiser::where('api_token', $request->api_token)->first();

        if ($advertiser) {
            $advertiser->player_id = null;
            $advertiser->api_token = null;
            $advertiser->save();
            return response()->json([
                'status' => true,
                'message' => 'تم الخروج بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى البيانات ... برجاء المحاولة مرة اخرى'
            ]);
        }

    }

    public function SignUp(Request $request)
    {
        $messages = [
            'name.unique' => 'هذا الاسم مستخدم من قبل',
            'mobile.unique' => 'هذا الجوال مستعمل من قبل',
            'pass.min' => 'يجب إدخال كلمة المرور كحد أدنى 6 حروف أو أرقام',
            'pass.confirmed' => 'تأكيد كلمة المرور غير مشابه لكلمة المرور',
            'e_mail.unique' => 'هذا البريد الإلكترونى مستعمل من قبل',
        ];
        $rules = [
            'mobile' => 'ksa_phone|unique:advertisers,mobile',
            'name' => 'required|max:120|unique:advertisers,name',
            'password' => 'required|min:6|confirmed',
            'player_id' => 'required',
//            'area' => 'required',
//            'city' => 'required',
//            'street' => 'required|max:255',
        ];
        if ($request->filled('e_mail')) {
            $rules['e_mail'] = 'required|email|unique:advertisers,e_mail';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error_data = [];
            foreach ($errors->all() as $error) {
                array_push($error_data, $error);
            }
            $data = $error_data;

            return response()->json([
                'status' => false,
                'errors' => $data
            ]);
        } else {
            $advertiser = new Advertiser();
            $advertiser->name = $request->name;
            $advertiser->mobile = $request->mobile;
            if ($request->filled('e_mail')) {
                $advertiser->e_mail = $request->e_mail;
            }

//            $active_code = rand(000000, 999999);
            $active_code = null;
            $advertiser->active_code = $active_code;

            $advertiser->password = bcrypt($request->password);
            $token = str_random(60);
            $advertiser->api_token = $token;
            $advertiser->agree = 1;

            $advertiser->player_id = $request->player_id;
            $advertiser->save();

            $advertiser = Advertiser::where('id', $advertiser->id)->first();
            unset($advertiser->password,$advertiser->address,$advertiser->lat,$advertiser->lon);
            return response()->json([
                'status' => true,
                'data' => $advertiser,
                'active_code' => $active_code
            ]);
        }

    }

    public function SignUpConfirm(Request $request)
    {
        $advertiser = Advertiser::where('id', $request->advertiser_id)->first();
        if ($advertiser) {
            if ($advertiser->active_code == $request->active_code) {
                $advertiser->active_code = null;
                $token = str_random(60);
                $advertiser->api_token = $token;
                $advertiser->save();

                unset($advertiser->password,$advertiser->address,$advertiser->lat,$advertiser->lon);
                return response()->json([
                    'status' => true,
                    'data' => $advertiser,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'مفتاح التعريف غير صحيح'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بيانات المعلن',
            ]);
        }

    }

    public function ResetPassword(Request $request)
    {
        $messages = [
            'e_mail.required' => ' الايميل مطلوب',
            'e_mail.email' => 'صيغه الايميل خاطئه',
        ];
        $rules = [
            'e_mail' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error_data = [];
            foreach ($errors->all() as $error) {
                array_push($error_data, $error);
            }
            $data = $error_data;

            return response()->json([
                'status' => false,
                'errors' => $data
            ]);
        }
        else{
            $advertiser = Advertiser::where('e_mail', $request->e_mail)->first();
            if ($advertiser and $advertiser->e_mail != null) {
                $active_code = rand(000000, 999999);
                $data = array(
                    'active_code' => $active_code,
                    'name' => $advertiser->name,
                    'img' => Haraj_One_Info::findOrFail(1)->logo
                );
                Mail::send('mail.mail2', $data, function ($message) use ($request) {
                    $message->to($request->e_mail)
                        ->subject('Haraje1.com Active Code');
                });

                $advertiser->active_code = $active_code;
                $advertiser->api_token = null;
                $advertiser->player_id = null;
                $advertiser->save();

                return response()->json([
                    'status' => true,
                    'advertiser_id' => $advertiser->id,
                    'message' => 'تم ارسال الكود لتغيير كلمه المرور'
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يوجد حساب مسجل لهذا البريد'
                ]);
            }
        }
    }

    public function NewPasswordSave(Request $request)
    {
        $messages = [
            'active_code.required' => 'كود التفعيل مطلوب',
            'password.required' => 'برجاء ادخال كلمه المرور  ',
            'password.confirmed' => 'كلمه المرو ليست متطابقه ',
            'advertiser_id.required' => 'بيانات المعلن مطلوبة',
        ];
        $rules = [
            'active_code' => 'required',
            'password' => 'required|confirmed',
            'advertiser_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error_data = [];
            foreach ($errors->all() as $error) {
                array_push($error_data, $error);
            }
            $data = $error_data;

            return response()->json([
                'status' => false,
                'errors' => $data
            ]);
        }
        else{
            $advertiser = Advertiser::where('id', $request->advertiser_id)->first();
            if ($advertiser) {
                if ($advertiser->active_code == $request->active_code) {
                    $advertiser->active_code = null;
                    $advertiser->password = bcrypt($request->password);
//                    $token = str_random(60);
//                    $advertiser->api_token = $token;
//                    $advertiser->player_id = $request->player_id;
                    $advertiser->save();
                    return response()->json([
                        'status' => true,
                        'advertiser_id' => $advertiser->id,
                        'message' => "تم تغيير كلمه المرور بنجاح"
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "كود التفعيل غير صحيح"
                    ]);
                }

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'بيانات المعلن خطأ'
                ]);
            }
        }
    }
}
