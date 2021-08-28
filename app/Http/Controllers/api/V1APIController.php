<?php

namespace App\Http\Controllers\api;

use App\Advertiser;
use App\AdvertiserContacts;
use App\AdvertiserRatings;
use App\AdvImgs;
use App\AdvRatings;
use App\Advs;
use App\Area;
use App\BlackList;
use App\City;
use App\ContactUs;
use App\Favourite;
use App\FixedPages;
use App\Followers;
use App\Haraj_One_Info;
use App\Http\Controllers\AdvsController;
use App\Http\Controllers\Controller;
use App\InternalSection;
use App\MainSection;
//use App\Slider;
use App\Notification_;
use App\ReportingReasons;
use App\Reports;
use App\SubSection;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class V1ApiController extends Controller
{
    public function __construct(Request $request)
    {
        Carbon::setLocale('ar');
    }

    public function if_is_exist($sub_path, $img)
    {
        if (is_null($img)) {
            $img = url('') . '/public/img/no_img.png';
        } else {
            if (file_exists($sub_path . $img)) {
                $img = url('') . '/' . $sub_path . $img;
            } else {
                $img = url('') . '/public/img/no_img.png';
            }
        }

        return $img;
    }

    public function return_errors($validator){
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
//    main page
//    public function Sliders()
//    {
//        $sliders = Slider::selectRaw('id,img')->get();
//        $sliders->each(function ($slider) {
//            $slider->img = $this->if_is_exist('public/img/sliders/', $slider->img);
//        });
//
//        if ($sliders->count() > 0) {
//            return response()->json([
//                'status' => true,
//                'data' => $sliders
//            ]);
//        } else {
//            return response()->json([
//                'status' => false,
//                'message' => 'لا يوجد اسليدز حتى الأن ...'
//            ]);
//        }
//    }

    public function Advs(Request $request)
    {
        $advs = Advs::selectRaw('id, advertiser_id, title, main_section, sub_section, year, area, city, created_at')
            ->where('agree', 1);

        if ($request->filled('search')) {
            $advs = $advs->where('title', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->has('main_section') && !in_array($request->main_section, [null, "", 0])) {
            $advs = $advs->where('main_section', $request->main_section);
        }
        if ($request->has('sub_section') && !in_array($request->sub_section, [null, "", 0])) {
            $advs = $advs->where('sub_section', $request->sub_section);
        }
//        if ($request->has('internal_section') && !in_array($request->internal_section, [null, "", 0])) {
//            $advs = $advs->where('internal_section', $request->internal_section);
//        }
        if ($request->has('city') && !in_array($request->city, [null, "", 0])) {
            $advs = $advs->where('city', $request->city);
        }
        if ($request->has('order_by') && $request->order_by == 0) {
            $advs = $advs->orderBy('updated_at', 'asc');
        } else {
            $advs = $advs->orderBy('updated_at', 'desc');
        }

        if ($request->has('adv_with_img') && $request->adv_with_img == 1) {
            $advs = $advs->whereHas('Adv_Img');
        }

        if($request->near == 1){
            $current_lat = $request->lat;
            $current_lon = $request->lon;
            $nearest_distance = 60;

            $cities_nearest = City::select(DB::raw('id, ( 6367 * acos( cos( radians(' . $current_lat . ') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians(' . $current_lon . ') ) + sin( radians(' . $current_lat . ') ) * sin( radians( lat ) ) ) ) AS distance'))
                ->having('distance', '<', $nearest_distance)
                ->orderBy('distance')
                ->get();
            $all_cities = array();
            foreach ($cities_nearest as $city_near) {
                array_push($all_cities, $city_near['id']);
            }

            $advs = $advs->whereIn('city', $all_cities);
        }

        $advs = $advs->paginate(10);

        if (count($advs) > 0) {
            $advs->each(function ($adv) use ($request) {
                $adv->title = str_limit($adv->title, 25);

                $url = url('');
                $i = AdvImgs::where('adv_id', $adv->id)->first();
                if ($i) {
                    $split = explode('/', $i->img);
                    if (file_exists('public/img/small/' . $split[2])) {
                        $adv->image = $url . '/public/img/small/' . $split[2];
                    } else {
                        if (file_exists($i->img)) {
                            $adv->image = $url . '/' . $i->img;
                        } else {
                            $adv->image = $url . '/public/img/no_img.png';
                        }
                    }
                } else {
                    $adv->image = $url . '/public/img/no_img.png';
                }

                $adv->comments_count = AdvsController::get_count_ratings($adv->id);

                $adv->area = Area::find($adv->area)->name ?? 'بدون منطقة ';
                $adv->city = City::find($adv->city)->name ?? 'بدون مدينة ';

                $adv->created_date = Carbon::parse($adv->created_at)->diffForHumans();

                $adv->fav = 0;
                if ($request->has('api_token')) {
                    $advertiser = Advertiser::select('api_token', 'id')->where('api_token', $request->api_token)->first();
                    if ($advertiser and $advertiser->api_token != null) {
                        $fav = Favourite::where('adv_id', $adv->id)->where('advertiser_id', $advertiser->id)->first();
                        if ($fav) {
                            $adv->fav = 1;
                        }
                    }
                }


                $advertiser_name = Advertiser::select('name')->where('id', $adv->advertiser_id)->first()->name;
                $adv->advertiser_name = $advertiser_name ?? '';

            });

            return response()->json([
                'status' => true,
                'data' => $advs
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد اعلانات حتى الأن ...'
            ]);
        }
    }

    public function MainSections()
    {
        $main_sections = MainSection::select('id', 'name', 'img')->get();
        $main_sections->each(function ($main_section) {
            $main_section->img = $this->if_is_exist('', $main_section->img);
        });
        if ($main_sections) {
            return response()->json([
                'status' => true,
                'data' => $main_sections
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لا يوجد اقسام رئيسية حنى الان ...'
            ]);
        }
    }

    public function SubSections($id)
    {
        $sub_sections = SubSection::select('id', 'name', 'img')->where('main_id', $id)->get();
        $sub_sections->each(function ($sub_section) {
            $sub_section->img = $this->if_is_exist('', $sub_section->img);
        });

        if ($sub_sections) {
            return response()->json([
                'status' => true,
                'data' => $sub_sections
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لا يوجد اقسام فرعية لهذا القسم الرئيسى حتى الأن ...'
            ]);
        }
    }

    public function InternalSections($id)
    {
        $internal_sections = InternalSection::select('id', 'name', 'img')->where('sub_id', $id)->get();
        $internal_sections->each(function ($internal_section) {
            $internal_section->img = $this->if_is_exist('', $internal_section->img);
        });

        if ($internal_sections) {
            return response()->json([
                'status' => true,
                'data' => $internal_sections
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد اقسام داخلية لهذا القسم الفرعى حتى الأن ...'
            ]);
        }
    }

//    contact us page
    public function ContactUsInfo()
    {
        $info = Haraj_One_Info::selectRaw('id, name, address, mobile, fax, e_mail, logo')->get();

        $info->each(function ($info_) {
            $info_->logo = $this->if_is_exist('public/img/', $info_->logo);
        });

        return \response()->json([
            'status' => true,
            'data' => $info
        ]);
    }

    public function ContactUs(Request $request)
    {
        $messages = [
            'name.required' => 'برجاء ادخال الاسم',
            'e_mail.required' => 'برجاء ادخال الايميل',
            'message.required' => 'برجاء ادخال الرساله ',
            'mobile.required' => 'برجاء ادخال التفاصيل',
        ];
        $rules = [
            'name' => 'required',
            'e_mail' => 'required',
            'message' => 'required',
            'mobile' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->return_errors($validator);
        } else {
            $input = [
                'name' => $request->name,
                'e_mail' => $request->e_mail,
                'msg' => $request->message,
                'mobile' => $request->mobile,
            ];

            $contact = ContactUs::create($input);
            if ($contact) {
                return response()->json([
                    'status' => true,
                    'message' => 'تم ارسال الرساله بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'خطأ اثناء الارسال برجاء المحاوله مره اخرى',
                ]);
            }

        }
    }

    public function SiteInfo()
    {
        $info = Haraj_One_Info::first();
        $info->logo = $this->if_is_exist('public/img/', $info->logo);

        return \response()->json([
            'status' => true,
            'data' => $info
        ]);
    }

//    adv
    public function AddAdvertisement(Request $request)
    {

        $messages = [
            'images.*.image' => 'يجب ان يكون الملف المرفوع من نوع الصور',
            'api_token.required' => 'يجب ادخال بيانات كود المعلن',
            'api_token.exists' => 'بيانات كود المعلن غير موجودة بالنظام ... برجاء ادخل بيانات صحيحة',
        ];
        $rules = [
            'api_token' => 'required|exists:advertisers,api_token',
            'title' => 'required|max:255',
            'area' => 'required',
            'city' => 'required',
            'main_section' => 'required',
            'sub_section' => 'required',
//            'mobile' => 'required|max:255|ksa_phone',
            'details' => 'required',
            'images.*' => 'required|image',
            'rules1' => 'required',
            'rules2' => 'required',
        ];

//        if ($request->filled('link')) {
//            $rules['link'] = 'required|url';
//        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->return_errors($validator);
        } else {
            $adv = new Advs();
            $adv->title = $request->title;
            $adv->area = $request->area;
            $adv->city = $request->city;

            $advertiser = Advertiser::selectRaw('id,mobile')->where('api_token', $request->api_token)->first();
            $adv->advertiser_id = $advertiser->id;
            $adv->mobile = $advertiser->mobile;

            $adv->main_section = $request->main_section;
            $adv->sub_section = $request->sub_section;
            $adv->internal_section = 0;
//            if ($request->has('internal_section')) {
//                $adv->internal_section = $request->internal_section;
//            }
            $adv->year = 0;
            if ($request->has('year')) {
                $adv->year = $request->year;
            }

            $adv->details = $request->details;
            $adv->allow_comment = $request->allow_comment;
            $adv->agree = 1;

            $adv->link = null;
//            if ($request->filled('link')) {
//                $adv->link = $request->link;
//            }

            $adv->location = '';
            $adv->lat = null;
            $adv->lon = null;
//            if($request->filled('location')){
//                $adv->location = $request->location ?? '';
//                $adv->lat = $request->lat ?? null;
//                $adv->lon = $request->lon ?? null;
//            }

            $adv->save();


            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $img) {
                    $fileName = date('Ymdhis') . '_' . rand(0, 999) . '.' . $img->getClientOriginalExtension();

                    // image operations
                    $img_ = Image::make($img);
                    $watermark = Image::make(public_path() . '/img/logo1.png')->opacity(50);

                    //make watermark quarter of image
                    $width_of_watermark = 0.20 * $img_->width();
                    // auto height fixed width
                    $watermark->resize($width_of_watermark, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    // insert watermark at bottom-right corner with 10px offset
                    $img_big = $img_->insert($watermark, 'bottom-right', 20, 20);
                    $img_big->save(public_path() . '/img/' . $fileName);

                    $img_small = $img_->resize(150, 150);
                    $img_small->save(public_path() . '/img/small/' . $fileName);

                    $input = [
                        'adv_id' => $adv->id,
                        'img' => 'public/img/' . $fileName,
                    ];
                     AdvImgs::create($input);
                    
                }
               

                return response()->json([
                    'status' => true,
                    'message' => 'تم حفظ الاعلان'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'تم حفظ الاعلان ولكن بدون صور '
                ]);
            }
        }
    }

    public function EditAdvertisement(Request $request)
    {
        $user = Advertiser::where('api_token', $request->api_token)->first();

        if ($user and $user->api_token != null) {
            $adv = Advs::where('id', $request->adv_id)->where('advertiser_id', $user->id)->first();
            unset($adv->advertiser_id, $adv->agree, $adv->views, $adv->link, $adv->internal_section, $adv->mobile, $adv->location, $adv->lat, $adv->lon);
            if ($adv) {
                $adv_imgs = AdvImgs::selectRaw('id, img')->where('adv_id', $adv->id)->get();
                if (count($adv_imgs) > 0) {
                    $adv_imgs->each(function ($adv_img) {
                        $img = $adv_img->img;
                        $url = url('');
                        $img = !isset($img) ? $url . '/public/img/no_img.png' : $url . '/' . $img;
                        $adv_img->img_url = $img;
                        unset($adv_img->img);
                    });
                } else {
                    $adv_imgs = [];
                }
                return response()->json([
                    'status' => true,
                    'data' => $adv,
                    'imgs' => $adv_imgs,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'خطأ فى بيانات الاعلان'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك'
            ]);
        }
    }

    public function UpdateAdvertisement(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::selectRaw('id, api_token')->where('api_token', $api_token)->first();
        if ($user and $user->api_token != null) {
            $adv = Advs::where('id', $request->adv_id)->where('advertiser_id', $user->id)->first();
            if ($adv) {
                $messages = [
                    'images.*.image' => 'يجب ان يكون الملف المرفوع من نوع الصور',
                ];
                $rules = [
                    'title' => 'required|max:255',
                    'area' => 'required',
                    'city' => 'required',
                    'main_section' => 'required',
                    'sub_section' => 'required',
//                    'mobile' => 'required|max:255',
                    'details' => 'required',
                    'images.*' => 'required|image',
                ];
//                if ($request->has('internal_section')) {
//                    $rules = ['internal_section' => 'required'];
//                }
                if ($request->has('year')) {
                    $rules = ['year' => 'required'];
                }
//                if ($request->filled('link')) {
//                    $rules['link'] = 'required|url';
//                }

                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return $this->return_errors($validator);
                } else {
                    $adv->title = $request->title;
                    $adv->area = $request->area;
                    $adv->city = $request->city;
                    $adv->main_section = $request->main_section;
                    $adv->sub_section = $request->sub_section;

                    $adv->internal_section = 0;
//                    if ($request->has('internal_section')) {
//                        $adv->internal_section = $request->internal_section;
//                    }
                    $adv->year = 0;
                    if ($request->has('year')) {
                        $adv->year = $request->year;
                    }

//                    $adv->mobile = $request->mobile;
                    $adv->details = $request->details;

//                    if ($request->filled('link')) {
//                        $adv->link = $request->link;
//                    }

//                    if($request->filled('location')){
//                        $adv->location = $request->location ?? '';
//                        $adv->lat = $request->lat ?? null;
//                        $adv->lon = $request->lon ?? null;
//                    }else{
//                        $adv->location = '';
//                        $adv->lat = null;
//                        $adv->lon = null;
//                    }

                    $adv->save();


                    if ($request->hasFile('images')) {
                        $images = $request->file('images');
                        foreach ($images as $img) {
                            $fileName = date('Ymdhis') . '_' . rand(0, 999) . '.' . $img->getClientOriginalExtension();

                            // image operations
                            $img_ = Image::make($img);
                            $watermark = Image::make(public_path() . '/img/logo1.png')->opacity(50);

                            //make watermark quarter of image
                            $width_of_watermark = 0.20 * $img_->width();
                            // auto height fixed width
                            $watermark->resize($width_of_watermark, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                            // insert watermark at bottom-right corner with 10px offset
                            $img_big = $img_->insert($watermark, 'bottom-right', 20, 20);
                            $img_big->save(public_path() . '/img/' . $fileName);

                            $img_small = $img_->resize(150, 150);
                            $img_small->save(public_path() . '/img/small/' . $fileName);

                            $charges[] = [
                                'adv_id' => $adv->id,
                                'img' => 'public/img/' . $fileName,
                            ];
                        }
                        AdvImgs::insert($charges);
                    }
                    return response()->json([
                        'status' => true,
                        'message' => 'تم تعديل الاعلان بنجاح'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'خطأ ف بيانات الاعلان'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى ']);
        }

    }

    public function RemoveAdvertisement(Request $request, $id)
    {
        $api_token = $request->api_token;
        $user = Advertiser::selectRaw('id, api_token')->where('api_token', $api_token)->first();

        if ($user and $user->api_token != null) {
            $advertisement = Advs::where('id', $id)->where('advertiser_id', $user->id)->first();
            if ($advertisement) {
                $advertisement->delete();

//                imgs delete
                $adv_imgs = AdvImgs::where('adv_id', $id)->get();
                foreach ($adv_imgs as $img) {
                    if (file_exists($img->img)) {
                        unlink($img->img);
                    }
                    $split = explode('/', $img->img);
                    if (file_exists('public/img/small/' . $split[2])) {
                        unlink('public/img/small/' . $split[2]);
                    }
                }
                AdvImgs::where('adv_id', $id)->get()->each->delete();

                $adv_ratings = AdvRatings::selectRaw('id')->where('adv_id', $id)->get();
                if (count($adv_ratings) > 0) {
                    $adv_ratings->each->delete();
                }

                $favorite_advs = Favourite::selectRaw('id')->where('adv_id', $id)->get();
                if (count($favorite_advs) > 0) {
                    $favorite_advs->each->delete();
                }

                $reports = Reports::selectRaw('id')->where('adv_id', $id)->get();
                if (count($reports) > 0) {
                    $reports->each->delete();
                }

                $notify = Notification_::selectRaw('id')->where('adv_id', $id)->get();
                if (count($notify) > 0) {
                    $notify->each->delete();
                }

                return response()->json([
                    'status' => true,
                    'message' => 'تم الحذف بنجاح'
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يوجد اعلان بهذه البيانات'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى '
            ]);
        }
    }

    public function DeleteAdvImg(Request $request, $id)
    {
        $user = Advertiser::where('api_token', $request->api_token)->first();
        if ($user and $user->api_token != null) {
            $adv = Advs::where('id', $id)->where('advertiser_id', $user->id)->first();
            if ($adv) {
                if ($request->has('img_ids')) {
//                    $arr = explode(',', $request->img_ids);
                    foreach ($request->img_ids as $img_id) {
                        $image = AdvImgs::where('id', $img_id)->first();
                        if ($image) {
                            $main_image = $image->img;
                            if (file_exists($main_image)) {
                                unlink($main_image);
                                $split = explode('/', $main_image);
                                if (file_exists('public/img/small/' . $split[2])) {
                                    unlink('public/img/small/' . $split[2]);
                                }
                            }
                            $image->delete();
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'يوجد خطأ ببيانات الصور المدخلة'
                            ]);
                        }
                    }
                    return response()->json([
                        'status' => true,
                        'message' => 'تم حذف الصور بنجاح'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'خطأ فى استدعاء بيانات الصور'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'خطأ فى استدعاء بيانات الاعلان'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى '
            ]);
        }
    }

    public function GetFavorites(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();
        if ($user and $user->api_token != null) {

            $favorites = Favourite::selectRaw('id,adv_id')->where('advertiser_id', $user->id)->paginate(10);
            $favorites->each(function ($favorite) {
                $adv = Advs:: where('id', $favorite->adv_id)->first();

                $i = AdvImgs::where('adv_id', $adv->id)->first();
                $url = url('');
                $img = !isset($i->img) ? $url . '/public/img/no_img.png' : $url . '/' . $i->img;
                $favorite->image = $img;
                $favorite->fav_id = $favorite->id;
                $favorite->id = $adv->id;

                $favorite->title = str_limit($adv->title, 25);

                $favorite->created_date = Carbon::parse($adv->created_at)->diffForHumans();

                $advertiser = Advertiser::where('id', $adv->advertiser_id)->first();
                $favorite->advertiser_name = $advertiser->name;

                $favorite->area = Area::find($adv->area)->name ?? 'بدون منطقة ';
                $favorite->city = City::find($adv->city)->name ?? 'بدون مدينة ';

                $favorite->comments_count = AdvsController::get_count_ratings($adv->id);
            });

            return response()->json([
                'status' => true,
                'data' => $favorites
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى '
            ]);
        }
    }

    public function AddToFavorites(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();

        if ($user and $user->api_token != null) {
            $messages = ['adv_id.required' => 'برجاء اختيار الاعلان',];
            $rules = ['adv_id' => 'required',];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return $this->return_errors($validator);
            } else {
                $adv = Advs::where('id', $request->adv_id)->first();
                if ($adv) {
                    $favorite = Favourite::where('advertiser_id', $user->id)->where('adv_id', $request->adv_id)->first();
                    if ($favorite) {
                        return response()->json([
                            'status' => false,
                            'message' => 'هذا الاعلان فى المفضله بالفعل '
                        ]);
                    } else {
                        $input = [
                            'advertiser_id' => $user->id,
                            'adv_id' => $request->adv_id,
                        ];
                        $new_favorite = Favourite::create($input);
                        if ($new_favorite) {

//                            $adv_ = Advs::selectRaw('advertiser_id')->where('id', $request->adv_id)->first();
//                            if($adv_ and $adv_ != null){
//                                $advertiser = Advertiser::selectRaw('player_id, id, name')
//                                    ->where('id', $adv_->advertiser_id)->first();
//                                $notify = new Notification_();
//                                $notify->content = 'قام '.$advertiser->name.' باضافة اعلانك '.$adv_->title.' الى مفضلته';
//                                $notify->adv_id = $adv_->id;
//                                $notify->advertiser_id = $advertiser->id;
//                                $notify->type = 11;
//                                $notify->save();
//
//                                if ($advertiser->player_id != null or $advertiser->player_id != '') {
//                                    $tokens = [$advertiser->player_id];
//                                    $content = $notify->content;
//                                    $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
//                                    sendNote($tokens, $content, $data);
//                                }
//                            }

                            return response()->json([
                                'status' => true,
                                'message' => 'تم الاضافه للمفضله بنجاح'
                            ]);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'حدث خطأ اثناء الحفظ برجاء المحاوله موره اخرى'
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'هذا الاعلان غير موجود'
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بيانات كود المعلن'
            ]);
        }
    }

    public function RemoveFromFavorites(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();

        if ($user and $user->api_token != null) {
            $favorite = Favourite::where('advertiser_id', $user->id)->where('adv_id', $request->adv_id)->first();
            if ($favorite) {
                $favorite->delete();

//                $notify = new Notification_();
//                $notify->content = 'تمت ازالة اعلان من المفضلة لديك';
//                $notify->adv_id = $request->adv_id;
//                $notify->advertiser_id = $user->id;
//                $notify->type = 11;
//                $notify->save();
//
//                if ($user->player_id != null or $user->player_id != '') {
//                    $tokens = [$user->player_id];
//                    $content = $notify->content;
//                    $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
//                    sendNote($tokens, $content, $data);
//                }

                return response()->json([
                    'status' => true,
                    'message' => 'تم حذف االاعلان من المفضله'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'هذا الاعلان ليس فى المفضله'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بيانات كود المعلن'
            ]);
        }

    }

    public function AdvDetails(Request $request)
    {
        $id = $request->adv_id;
        $api_token = $request->api_token;

//        $adv = Advs::selectRaw('id,link,location,lat,lon,title,area,city,advertiser_id,main_section,sub_section,year,mobile,details,created_at')
        $adv = Advs::selectRaw('id,title,area,city,advertiser_id,main_section,sub_section,year,mobile,details,allow_comment,created_at')
            ->where('id', $id)->where('agree', 1)->first();
        if($adv){
            $user = Advertiser::where('api_token', $api_token)->first();
            $adv->fav = 0;
            $adv->user_rate = 0;
            if ($user and $user->api_token != null){
                $favorite = Favourite::where('advertiser_id', $user->id)->where('adv_id', $id)->first();
                if($favorite){
                    $adv->fav = 1;
                }

                $adv_rating = AdvRatings::where('adv_id', $adv->id)->where('voter_id', $user->id)
                    ->where('type', 1)->first();
                if($adv_rating){
                    $adv->user_rate = $adv_rating->rating;
                }
            }


            $adv->area_name = Area::where('id', $adv->area)->first()->name ?? '';
            $adv->city_name = City::where('id', $adv->city)->first()->name ?? '';

            $adv->advertiser_name = Advertiser::where('id', $adv->advertiser_id)->first()->name;

            $imgs = AdvImgs::where('adv_id', $adv->id)->get();
            if (count($imgs) > 0) {
                $imgs->each(function ($img) {
                    $img->img_url = url($img->img);
                });
                $imgs = $imgs->map(function ($img) {
                    return collect($img->toArray())
                        ->only(['img_url', 'id'])
                        ->all();
                });
            } else {
                $imgs = [];
            }

            $adv->base_url = url('/adv/' . $adv->id);

//            $rates = AdvRatings::where('adv_id', $adv->id)->where('type', 1)->get();
//            if (count($rates) > 0) {
//                $rates->each(function ($rate) {
//                    $rate->rate = $rate->rating;
//                    $rate->rater_id = $rate->voter_id;
//                    $rate->rater_name = $rate->Rater->name;
//                });
//            }
//            else {$rates = [];}

            $comments = AdvRatings::where('adv_id', $adv->id)->where('type', 0)->get();
            if (count($comments) > 0) {
                $comments->each(function ($comment) {
                    $comment->comment = $comment->reply;
                    $comment->comment_user_id = $comment->voter_id;
                    $comment->comment_user_name = $comment->Rater->name;
                    $comment->comment_date = Carbon::parse($comment->created_at)->diffForHumans();
                });
                $comments = $comments->map(function ($comment) {
                    return collect($comment->toArray())
                        ->only(['comment', 'comment_user_id', 'comment_user_name', 'comment_date'])
                        ->all();
                });

            } else {
                $comments = [];
            }

            $rates = AdvRatings::where('adv_id', $adv->id)->where('type', 1)->get();
            if (count($rates) > 0) {
                $rate1 = count($rates->where('rating', 1));
                $rate2 = count($rates->where('rating', 2));
                $rate3 = count($rates->where('rating', 3));
                $rate4 = count($rates->where('rating', 4));
                $rate5 = count($rates->where('rating', 5));
                $total_rates = count($rates);
                $final_rate = ($rates->sum('rating') / $total_rates);
                $final_rate = number_format($final_rate, 1);
            } else {
                $rate1 = 0;
                $rate2 = 0;
                $rate3 = 0;
                $rate4 = 0;
                $rate5 = 0;
                $total_rates = 0;
                $final_rate = 0;
            }


            $adv->adv_date = Carbon::parse($adv->created_at)->diffForHumans();

            $same_advs = Advs::selectRaw('id,title')->where('main_section', $adv->main_section)
                ->where('sub_section', $adv->sub_section)
                ->where('agree', 1)
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
            if (count($same_advs) > 0) {
                $same_advs->each(function ($adv_) {
                    $adv_->title_ = $adv_->title;
                    $adv_img = AdvImgs::select('img')->where('adv_id', $adv_->id)->first();
                    if ($adv_img) {
                        $adv_->img_url = url($adv_img->img);
                    } else {
                        $adv_->img_url = null;
                    }
                });
                $same_advs = $same_advs->map(function ($adv_) {
                    return collect($adv_->toArray())
                        ->only(['id', 'img_url', 'title'])
                        ->all();
                });
            }
            else {
                $same_advs = [];
            }

//            if($adv->link != null){
//                $link_parts = parse_url($adv->link);
//            }else{
//                $link_parts = [];
//            }

            return response()->json([
                'status' => true,
                'data' => $adv,
                'imgs' => $imgs,
                'same_advs' => $same_advs,
//                'rates' => $rates,
                'comments' => $comments,
                'rate1' => $rate1,
                'rate2' => $rate2,
                'rate3' => $rate3,
                'rate4' => $rate4,
                'rate5' => $rate5,
                'total_rates' => $total_rates,
                'final_rate' => $final_rate,
//                'link_parts' => $link_parts,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ اثناء استدهاء البيانات برجاء المحاوله مره اخرى'
            ]);
        }
    }

    public function ReportReasons(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();
        if ($user and $user != null) {
            $reasons = ReportingReasons::select('id', 'name')->get();
            return response()->json([
                'status' => true,
                'data' => $reasons
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك'
            ]);
        }
    }

    public function AdvReport(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();
        if ($user and $user != null) {
            $adv = Advs::where('id', $request->adv_id)->first();
            if ($adv) {
                if ($request->filled('reason_id')) {
                    $old_report = Reports::where('adv_id', $request->adv_id)->where('reporter_id', $user->id)->first();
                    if ($old_report) {
                        $old_report->reason_id = $request->reason_id;
                        $action = $old_report->save();
                        if ($action) {
                            return response()->json([
                                'status' => true,
                                'message' => 'تم تحديث البلاغ بنجاح'
                            ]);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'حدث خطأ اثناء الابلاغ برجاء المحاوله مره اخرى'
                            ]);
                        }
                    } else {
                        $report = new Reports();
                        $report->advertiser_id = $adv->advertiser_id;
                        $report->adv_id = $request->adv_id;
                        $report->c_r_type = 0;
                        $report->c_r_id = 0;
                        $report->c_r_voter_id = 0;
                        $report->reason_id = $request->reason_id;
                        $report->reporter_id = $user->id;
                        $action = $report->save();
                        if ($action) {
                            return response()->json([
                                'status' => true,
                                'message' => 'تم الابلاغ بنجاح'
                            ]);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'حدث خطأ اثناء الابلاغ برجاء المحاوله مره اخرى'
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'برجاء ادخال كود السبب'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'الاعلان غير موجود'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك'
            ]);
        }
    }

    public function AdvRate(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();
        if ($user and $user->api_token != null) {
            $messages = [
                'adv_id.required' => 'برجاء اختيار اعلان لتقييمه',
                'rate.required' => 'برجاء ادخال التقييم',
                'rate.integer' => 'التقييم يجب ان يكون رقم صحيح',
            ];
            $rules = [
                'adv_id' => 'required',
                'rate' => 'required|integer|min:1|max:5',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return $this->return_errors($validator);
            } else {
                $pre_rate = AdvRatings::where('adv_id', $request->adv_id)->where('voter_id', $user->id)->first();
                if ($pre_rate and $pre_rate) {
                    $pre_rate->rating = $request->rate;
                    $pre_rate->save();
                    return response()->json([
                        'status' => true,
                        'message' => 'تم اعاده التقييم بنجاح'
                    ]);
                } else {
                    $input = [
                        'adv_id' => $request->adv_id,
                        'voter_id' => $user->id,
                        'rating' => $request->rate,
                        'type' => 1,
                    ];

                    $rate = AdvRatings::create($input);

                    $adv = Advs::where('id', $request->adv_id)->first();
                    if($adv->advertiser_id != $user->id){
                        $notify = new Notification_();
                        $notify->content = 'لديك تقييم جديد';
                        $notify->adv_id = $request->adv_id;
                        $notify->advertiser_id = $adv->advertiser_id;
                        $notify->type = 3;
                        $notify->save();

                        $user_notify = Advertiser::findOrFail($adv->advertiser_id);
                        if ($user_notify->player_id != null or $user_notify->player_id != '') {
                            $tokens = [$user_notify->player_id];
                            $content = $notify->content;
                            $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
                            sendNote($tokens, $content, $data);
                        }
                    }

                    if ($rate) {
                        return response()->json([
                            'status' => true,
                            'message' => 'تم التقييم بنجاح'
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'خطأ اثناء الحفظ برجاء المحاوله مره اخرى'
                        ]);
                    }
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك'
            ]);
        }
    }

    public function AdvComment(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::selectRaw('id,api_token')->where('api_token', $api_token)->first();
        if ($user and $user->api_token != null) {
            $messages = [
                'adv_id.required' => 'برجاء اختيار اعلان لتقييمه',
                'comment.required' => 'برجاء ادخال التعليق',
            ];
            $rules = [
                'adv_id' => 'required',
                'comment' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return $this->return_errors($validator);
            } else {
                $input = [
                    'adv_id' => $request->adv_id,
                    'voter_id' => $user->id,
                    'reply' => $request->comment,
                    'type' => 0,
                ];
                $comment = AdvRatings::create($input);

                $adv = Advs::selectRaw('advertiser_id')->where('id', $request->adv_id)->first();
                // don't send notify for my comment
                if ($user->id != $adv->advertiser_id) {
                    $notify = new Notification_();
                    $notify->content = 'لديك تعليق جديد';
                    $notify->adv_id = $request->adv_id;
                    $notify->advertiser_id = $adv->advertiser_id;
                    $notify->type = 4;
                    $notify->save();

                    $user_notify = Advertiser::findOrFail($adv->advertiser_id);
                    if ($user_notify->player_id != null or $user_notify->player_id != '') {
                        $tokens = [$user_notify->player_id];
                        $content = $notify->content;
                        $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
                        sendNote($tokens, $content, $data);
                    }
                }


                if ($comment) {
                    return response()->json([
                        'status' => true,
                        'message' => 'تم التعليق بنجاح'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'حدث خطأ ما اثناء التعليق'
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك'
            ]);
        }
    }


//    advertiser
    public function MyAdvs(Request $request)
    {
        $advertiser = Advertiser::where('api_token', $request->api_token)->first();
        if ($advertiser and $advertiser->api_token != null) {
            $advs = Advs::where('advertiser_id', $advertiser->id);
            if ($request->has('main_section') && !in_array($request->main_section, [null, "", 0])) {
                $advs = $advs->where('main_section', $request->main_section);
            }
            if ($request->has('city') && !in_array($request->city, [null, "", 0])) {
                $advs = $advs->where('city', $request->city);
            }
            $advs = $advs->get();

            if (count($advs) > 0) {
                $advs->each(function ($adv) use ($advertiser) {
                    $adv->title = str_limit($adv->title, 25);

                    $url = url('');
                    $i = AdvImgs::where('adv_id', $adv->id)->first();
                    if ($i) {
                        $split = explode('/', $i->img);
                        if (file_exists('public/img/small/' . $split[2])) {
                            $adv->image = $url . '/public/img/small/' . $split[2];
                        } else {
                            if (file_exists($i->img)) {
                                $adv->image = $url . '/' . $i->img;
                            } else {
                                $adv->image = $url . '/public/img/no_img.png';
                            }
                        }
                    } else {
                        $adv->image = $url . '/public/img/no_img.png';
                    }

                    $adv->advertiser_name = $advertiser->name ?? '';

                    $adv->area = Area::find($adv->area)->name ?? 'بدون منطقة ';
                    $adv->city = City::find($adv->city)->name ?? 'بدون مدينة ';

                    $adv->comments_count = AdvsController::get_count_ratings($adv->id);

                    $adv->created_date = Carbon::parse($adv->created_at)->diffForHumans();
                });

                $advs = $advs->map(function ($adv) {
                    return collect($adv->toArray())
                        ->only(['id', 'title', 'area', 'city', 'comments_count', 'created_date', 'advertiser_name', 'image'])
                        ->all();
                });
                return response()->json([
                    'status' => true,
                    'data' => $advs
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يوجد اعلانات لهذا المستخدم'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بيانات المستخدم',
            ]);
        }
    }

    public function MyNotifications(Request $request)
    {
        $user = auth()->guard('api')->user();

        if ($user) {

            $notifications = Notification_::where('advertiser_id', $user->id)->orderBy('created_at', 'desc')->get();
            if (count($notifications) > 0) {
                foreach ($notifications as $notification) {
                    if ($notification->adv_id != null || $notification->adv_id != 0) {
                        $adv = Advs::where('id', $notification->adv_id)->first();
                        $notification->adv_title = $adv->title ?? '';
                    } else {
                        $notification->adv_title = null;
                    }

                    $notification->content = $notification->content ?? '';
                    $notification->adv_id = $notification->adv_id ?? '';
                    $notification->advertiser_id = $notification->advertiser_id ?? '';
                    $notification->type = $notification->type ?? '';

                    $notification->is_reading = $notification->reading;
                    $notification->created_date = Carbon::parse($notification->created_at)->format('y-m-d');
                    $notification->created_hour = Carbon::parse($notification->created_at)->format('h:i');
                }

                $notifications = $notifications->map(function ($notification) {
                    return collect($notification->toArray())
                        ->only(['id', 'adv_title', 'content', 'adv_id', 'advertiser_id', 'type', 'is_reading', 'created_date', 'created_hour'])
                        ->all();
                });
                return response()->json([
                    'status' => true,
                    'data' => $notifications,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    "message" => 'لا يوجد اشعارات لهذا المستخدم'
                ]);
            }

        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى '
            ]);
        }


    }

    public function NotificationRead(Request $request, $id)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();
        if ($user and $user->api_token != null) {
            $notification = Notification_::where('advertiser_id', $user->id)->where('id', $id)->where('reading', 0)->first();
            if ($notification) {
                $notification->reading = 1;
                $notification->save();

                if ($notification->type == 1) {
                    $data = url('') . '/messages';
                } elseif ($notification->type == 2) {
                    $data = url('') . '/adv/' . $notification->adv_id;
                } elseif ($notification->type == 3) {
                    $data = url('') . '/adv/' . $notification->adv_id;
                } elseif ($notification->type == 4) {
                    $data = url('') . '/adv/' . $notification->adv_id;
                } elseif ($notification->type == 5) {
                    $data = url('') . '/reply/' . $notification->adv_id;
                } elseif ($notification->type == 6) {
                    $data = url('') . '/home';
                } elseif ($notification->type == 7) {
                    $data = url('') . '/home';
                } elseif ($notification->type == 8) {
                    $data = url('') . '/add_subscription';
                } elseif ($notification->type == 9) {
                    $data = url('') . '/add_subscription';
                } elseif ($notification->type == 10) {
                    $data = url('') . '/adv/' . $notification->adv_id;
                } elseif ($notification->type == 11) {
                    $data = url('') . '/adv/' . $notification->adv_id;
                } else {
                    $data = $notification;
                }

                return response()->json([
                    'status' => true,
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يوجد اشعار بهذه البيانات'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى '
            ]);
        }

    }

    public function EditPersonalInfo(Request $request)
    {
//        $advertiser = Advertiser::select('api_token', 'id', 'mobile', 'name', 'e_mail', 'area', 'city', 'street', 'address', 'lat', 'lon', 'facebook', 'twitter', 'instagram')
        $advertiser = Advertiser::select('api_token', 'id', 'mobile', 'name', 'e_mail', 'area', 'city', 'street', 'facebook', 'twitter', 'instagram')
            ->where('api_token', $request->api_token)->first();

        if ($advertiser and $advertiser->api_token != null) {
//            $advertiser->img = $this->if_is_exist('public/img/advertiser_imgs/', $advertiser->img);
            unset($advertiser->api_token);

            $advertiser->followers_count = Followers::select('id')->where('advertiser_id', $advertiser->id)->get()->count();
            $advertiser->ratings_count = AdvertiserRatings::select('id')->where('advertiser_id', $advertiser->id)->get()->count();

            return response()->json([
                'status' => true,
                'data' => $advertiser
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لا يوجد مستخدم بهذه البيانات'
            ]);
        }
    }

    public function UpdatePersonalInfo(Request $request)
    {
        $update_user = Advertiser::where('api_token', $request->api_token)->first();
        if ($update_user and $update_user->api_token != null) {
            $rules = [
                'name' => 'required|max:255|unique:advertisers,name,' . $update_user->id,
                'e_mail' => 'required|email|unique:advertisers,e_mail,' . $update_user->id,
                'mobile' => 'required|ksa_phone|max:255|unique:advertisers,mobile,' . $update_user->id,
                'area' => 'required',
                'city' => 'required',
                'street' => 'required|max:255',
            ];
            if ($request->filled('password')) {
                $rules['password'] = 'required|confirmed';
            }
//            if ($request->has('image')) {
//                $rules['image'] = 'image';
//            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->return_errors($validator);
            } else {
                $update_user->name = $request->name;
                $update_user->mobile = $request->mobile;
                $update_user->e_mail = $request->e_mail;
                $update_user->area = $request->area;
                $update_user->city = $request->city;
                $update_user->street = $request->street;
                $update_user->facebook = $request->facebook;
                $update_user->twitter = $request->twitter;
                $update_user->instagram = $request->instagram;
                if ($request->filled('password')) {
                    $update_user->password = bcrypt($request->password);
                }

//                if($request->filled('location')){
//                    $update_user->address = $request->location ?? '';
//                    $update_user->lat = $request->lat ?? null;
//                    $update_user->lon = $request->lon ?? null;
//                }else{
//                    $update_user->address = '';
//                    $update_user->lat = null;
//                    $update_user->lon = null;
//                }

                $update_user->save();
                return response()->json([
                    'status' => true,
                    'message' => 'تم تعديل البيانات بنجاح'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بيانات المعلن'
            ]);
        }
    }

    public function AdvertiserPage(Request $request)
    {
//        $advertiser = Advertiser::selectRaw('id,name,mobile,address,lat,lon,last_activity,facebook,twitter,instagram')->where('id', $request->id)->first();
        $advertiser = Advertiser::selectRaw('id,name,mobile,last_activity,facebook,twitter,instagram')->where('id', $request->id)->first();
        if ($advertiser) {

            $advs = Advs::where('advertiser_id', $advertiser->id);
            if ($request->has('main_section') && $request->main_section != null && $request->main_section != "" && $request->main_section != 0) {
                $advs = $advs->where('main_section', $request->main_section);
            }
            if ($request->has('city') && $request->city != null && $request->city != "" && $request->city != 0) {
                $advs = $advs->where('city', $request->city);
            }
            $advs = $advs->get();

            if (count($advs) > 0) {
                $advs->each(function ($adv) use ($advertiser) {
                    $adv->title = str_limit($adv->title, 25);

                    $url = url('');
                    $i = AdvImgs::where('adv_id', $adv->id)->first();
                    if ($i) {
                        $split = explode('/', $i->img);
                        if (file_exists('public/img/small/' . $split[2])) {
                            $adv->image = $url . '/public/img/small/' . $split[2];
                        } else {
                            if (file_exists($i->img)) {
                                $adv->image = $url . '/' . $i->img;
                            } else {
                                $adv->image = $url . '/public/img/no_img.png';
                            }
                        }
                    } else {
                        $adv->image = $url . '/public/img/no_img.png';
                    }

                    $adv->advertiser_name = $advertiser->name ?? '';

                    $adv->comments_count = AdvRatings::where('adv_id', $adv->id)->where('type', 0)->get()->count();

                    $adv->area = Area::find($adv->area)->name ?? 'بدون منطقة ';
                    $adv->city = City::find($adv->city)->name ?? 'بدون مدينة ';

                    $adv->created_date = Carbon::parse($adv->created_at)->diffForHumans();
                });

                $advertiser_advs = $advs->map(function ($adv) {
                    return collect($adv->toArray())
                        ->only(['id', 'title', 'area', 'city', 'comments_count', 'created_date', 'advertiser_name', 'image'])
                        ->all();
                });
            } else {
                $advertiser_advs = [];
            }

            $advertiser->ratings_count = AdvertiserRatings::where('advertiser_id', $request->id)->get()->count();
            $advertiser->followers_count = Followers::where('advertiser_id', $request->id)->get()->count();
            $advertiser->last_activity = Carbon::parse($advertiser->last_activity)->diffForHumans();

            $advertiser->is_following = false;
            $other_advertiser = Advertiser::selectRaw('id')->where('api_token' , $request->api_token)->first();
            if($other_advertiser and $other_advertiser != null){
                $is_follow_exist = Followers::where('advertiser_id', $request->id)->where('follower_id', $other_advertiser->id)->first();
                if($is_follow_exist and $is_follow_exist != null){
                    $advertiser->is_following = true;
                }
            }
//            $advertiser_rating = AdvertiserRatings::selectRaw('id,rating')->where('advertiser_id', $advertiser->id)->get();
//            $total_rates = $advertiser_rating->count();
//            $advertiser_rating_sum = $advertiser_rating->sum('rating');
//            if ($total_rates > 0) {
//                $rate1 = count($advertiser_rating->where('rating', 1));
//                $rate2 = count($advertiser_rating->where('rating', 2));
//                $rate3 = count($advertiser_rating->where('rating', 3));
//                $rate4 = count($advertiser_rating->where('rating', 4));
//                $rate5 = count($advertiser_rating->where('rating', 5));
//                $final_rate = number_format(($advertiser_rating_sum / $total_rates), 1);
//            } else {
//                $rate1 = 0;
//                $rate2 = 0;
//                $rate3 = 0;
//                $rate4 = 0;
//                $rate5 = 0;
//                $final_rate = 0;
//            }

            return response()->json([
                'status' => true,
                'data' => $advertiser,
                'advertiser_advs' => $advertiser_advs,
//                'rate1' => $rate1,
//                'rate2' => $rate2,
//                'rate3' => $rate3,
//                'rate4' => $rate4,
//                'rate5' => $rate5,
//                'total_rates' => $total_rates,
//                'final_rate' => $final_rate
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بيانات المستخدم',
            ]);
        }
    }

    public function AdvertiserRate(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();

        if ($user and $user->api_token != null) {
            $messages = [
                'advertiser_id.required' => 'برجاء اختيار معلن لتقييمه',
                'advertiser_id.exists' => 'المعلن المحدد غير موجود',
                'rate.required' => 'برجاء ادخال التقييم',
                'rate.min' => 'برجاء ادخال التقييم بحد ادنى 1 نجمة',
                'rate.max' => 'برجاء ادخال التقييم بحد اقصى 5 نجمة',
                'rate.integer' => 'برجاء ادخال التقييم رقما صحيحا',
            ];
            $rules = [
                'advertiser_id' => 'required|exists:advertisers,id',
                'rate' => 'required|integer|min:1|max:5',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->return_errors($validator);
            } else {
                if ($request->advertiser_id == $user->id) {
                    return response()->json([
                        'status' => false,
                        'message' => 'لا يمكن تقييم نفسك'
                    ]);
                } else {
                    $pre_rate = AdvertiserRatings::where('advertiser_id', $request->advertiser_id)->where('voter_id', $user->id)->first();
                    if ($pre_rate) {
                        return response()->json([
                            'status' => false,
                            'message' => 'لقد قيمت هذا المعلن سابقا'
                        ]);
                    } else {
                        $input = [
                            'advertiser_id' => $request->advertiser_id,
                            'voter_id' => $user->id,
                            'rating' => $request->rate,
                        ];

                        $rate = AdvertiserRatings::create($input);

                        $notify = new Notification_();
                        $notify->content = 'لديك تقييم شخصى جديد';
                        $notify->adv_id = 0;
                        $notify->advertiser_id = $request->advertiser_id;
                        $notify->type = 7;
                        $notify->save();

                        if ($user->player_id != null or $user->player_id != '') {
                            $tokens = [$user->player_id];
                            $content = $notify->content;
                            $data = ['advertiser_id' => $notify->advertiser_id, 'type' => $notify->type];
                            sendNote($tokens, $content, $data);
                        }

                        if ($rate) {
                            return response()->json([
                                'status' => true,
                                'message' => 'تم التقييم بنجاح'
                            ]);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'خطأ اثناء الحفظ برجاء المحاوله مره اخرى'
                            ]);
                        }
                    }
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى '
            ]);
        }
    }

    public function AdvertiserFollow(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::where('api_token', $api_token)->first();

        if ($user and $user->api_token != null) {
            $messages = [
                'advertiser_id.required' => 'برجاء اختيار معلن لتقييمه',
                'advertiser_id.exists' => 'المعلن المحدد غير موجود',
            ];
            $rules = [
                'advertiser_id' => 'required|exists:advertisers,id',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->return_errors($validator);
            } else {
                if ($request->advertiser_id == $user->id) {
                    return response()->json([
                        'status' => false,
                        'message' => 'لا يمكن متابعة نفسك'
                    ]);
                } else {
                    $pre_follow = Followers::where('advertiser_id', $request->advertiser_id)->where('follower_id', $user->id)->first();
                    if ($pre_follow) {
                        $pre_follow->delete();
                        return response()->json([
                            'status' => true,
                            'message' => 'تم الغاء المتابعة بنجاح'
                        ]);
                    } else {

                        $followers = new Followers();
                        $followers->advertiser_id = $request->advertiser_id;
                        $followers->follower_id = $user->id;
                        $action = $followers->save();

                        $follower_name = Advertiser::selectRaw('name')->where('id', $user->id)->first()->name;
                        $notify = new Notification_();
                        $notify->content = 'تمت متابعتك من طرف ' . $follower_name;
                        $notify->adv_id = 0;
                        $notify->advertiser_id = $request->advertiser_id;
                        $notify->type = 6;
                        $notify->save();

                        $user = Advertiser::selectRaw('player_id,id')->where('id', $request->advertiser_id)->first();
                        if ($user->player_id != null or $user->player_id != '') {
                            $tokens = [$user->player_id];
                            $content = $notify->content;
                            $data = ['follower_id' => $user->id, 'type' => $notify->type];
                            sendNote($tokens, $content, $data);
                        }

                        if ($action) {
                            return response()->json([
                                'status' => true,
                                'message' => 'تمت المتابعة بنجاح'
                            ]);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'خطأ اثناء الحفظ برجاء المحاوله مره اخرى'
                            ]);
                        }
                    }
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى '
            ]);
        }
    }

    public function followers(Request $request)
    {
        $api_token = $request->api_token;
        $user = Advertiser::selectRaw('id')->where('api_token', $api_token)->first();
        $followers = Followers::selectRaw('follower_id')->where('advertiser_id', $user->id)->get();

        if($followers->count() > 0){
            $followers->each(function($follower){
                $follower_info = Advertiser::selectRaw('name')->where('id', $follower->follower_id)->first();
                $follower->name = $follower_info->name ?? '';
            });
            $followers = $followers->map(function ($follower) {
                return collect($follower->toArray())
                    ->only(['follower_id', 'name',])
                    ->all();
            });

            return response()->json([
                'status' => true,
                'data' => $followers
            ]);
        }else {
            return response()->json([
                'status' => false,
                'message' => 'ليس لديك متابعين حتى الأن'
            ]);
        }
    }

//    other
    public function Pages()
    {
        $pages = FixedPages::select('id', 'title')->get();
        if ($pages) {
            return response()->json([
                'status' => true,
                'data' => $pages
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'ليس لديك صفحات ثابتة حتى الأن'
            ]);
        }
    }

    public function commission()
    {
        return view('api.commission');
    }

    public function PageDetails($id)
    {
        $page = FixedPages::selectRaw('id, title, content')->where('id', $id)->first();
        $logo = Haraj_One_Info::select('logo')->findOrFail(1)->logo;
        $page->logo = $this->if_is_exist('public/img/', $logo);
        if ($page) {
            return response()->json([
                'status' => true,
                'data' => $page
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد صفحة ثابتة بهذه البيانات'
            ]);

        }

    }

//    public function TaxPage()
//    {
//        $tax_info = Haraj_One_Info::selectRaw('id, tax_explain, tax_percent')->first();
//        if ($tax_info) {
//            return response()->json([
//                'status' => true,
//                'data' => $tax_info
//            ]);
//        } else {
//            return response()->json([
//                'status' => false,
//                'message' => 'لا توجد بيانات للضرية حتى الأن'
//            ]);
//
//        }
//
//    }

    public function CalcTax(Request $request)
    {
        $money = $request->money ?? 0;
        $tax_percent = 1;
//        $tax_percent = Haraj_One_Info::select('tax_percent')->first()->tax_percent;
        $tax = ($money * $tax_percent) / 100;
        return response()->json([
            'status' => true,
            'data' => $tax
        ]);
    }

    public function BlackListSearch(Request $request)
    {
        $advertiser = Advertiser::query();
        if ($request->has('name')) {
            $advertiser = $advertiser->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('mobile', $request->name);
        }
        $advertiser = $advertiser->pluck('id');


        $list = BlackList::whereIn('advertiser_id', $advertiser)->pluck('advertiser_id');
        $blacks = Advertiser::whereIn('id', $list)->get();

        if (count($blacks) > 0) {
            $blacks->each(function ($black) {
                $city_name = City::where('id', $black->city)->first()->name ?? '';
                $black->city_name = $city_name;
            });
            $blacks = $blacks->map(function ($black) {
                return collect($black->toArray())
                    ->only(['id', 'name', 'city_name', 'mobile'])
                    ->all();
            });
            return response()->json([
                'status' => true,
                'data' => $blacks
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لا يوجد نتايج فى القائمه السوداء لهذا الشخص'
            ]);
        }
    }

    public function GetCities(Request $request)
    {
        $messages = ['area_id.required' => 'المنطقة مطلوبة',];
        $rules = ['area_id' => 'required',];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->return_errors($validator);
        } else {
            if ($request->area_id == 0) {
                $cities = City::select('id', 'name')->get();
            } else {
                $cities = City::select('id', 'name')->where('area_id', $request->area_id)->get();
            }

            if ($cities) {
                return response()->json([
                    'status' => true,
                    'data' => $cities
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'حدث خطأ اثناء تجميع البانات برجاء المحاوله مره اخرى '
                ]);
            }
        }


    }

    public function GetArea()
    {
        $area = Area::select('id', 'name')->get();
        if ($area) {
            return response()->json([
                'status' => true,
                'data' => $area
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ اثناء تجميع البانات برجاء المحاوله مره اخرى '
            ]);
        }
    }

//    public function SpecialAdvs()
//    {
//        $special_advs = Advs::select('id', 'title')->where('special', 1)->get();
//        if ($special_advs->count() > 0) {
//            foreach ($special_advs as $special_adv) {
//                $url = url('');
//                $i = AdvImgs::where('adv_id', $special_adv->id)->first();
//                if ($i) {
//                    $split = explode('/', $i->img);
//                    if (file_exists('public/img/small/' . $split[2])) {
//                        $image_ = $url . '/public/img/small/' . $split[2];
//                    } else {
//                        if (file_exists($i->img)) {
//                            $image_ = $url . '/' . $i->img;
//                        } else {
//                            $image_ = $url . '/public/img/no_img.png';
//                        }
//                    }
//                } else {
//                    $image_ = $url . '/public/img/no_img.png';
//                }
//
//                $special_adv->img = $image_;
//            }
//        } else {
//            $special_advs = [];
//        }
//
//        return response()->json([
//            'status' => true,
//            'data' => $special_advs
//        ]);
//    }


// messages
    public function MessageAdvertiser(Request $request)
    {
        $api_token = $request->api_token;
        $advertiser = Advertiser::selectRaw('id, api_token')->where('api_token', $api_token)->first();

        if ($advertiser and $advertiser->api_token != null) {
            $messages = [
                'msg.required' => 'برجاء ادخال الرساله',
                'to_id.required' => 'برجاء ادخل بيانات المرسل اليه',
            ];
            $rules = [
                'msg' => 'required',
                'to_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->return_errors($validator);
            } else {
                $contacts = new AdvertiserContacts();
                $contacts->msg = $request->msg;
                $contacts->from_id = $advertiser->id;
                $contacts->to_id = $request->to_id;
                $contacts->parent_id = 0;
                $contacts->save();


                $notify = new Notification_();
                $notify->content = 'لديك رسالة خاصة جديدة';
                $notify->adv_id = $contacts->id;
                $notify->advertiser_id = $request->to_id;
                $notify->type = 1;
                $notify->save();

                $user = Advertiser::findOrFail($request->to_id);
                if ($user->player_id != null or $user->player_id != '') {
                    $tokens = [$user->player_id];
                    $content = $notify->content;
                    $data = ['message_id' => $contacts->id, 'type' => $notify->type];
                    sendNote($tokens, $content, $data);
                }


                return response()->json([
                    'status' => true,
                    'message' => 'تم ارسال الرساله بنجاح',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بيانات المرسل'
            ]);

        }


    }

    public function MyMessages(Request $request)
    {
        $api_token = $request->api_token;
        $advertiser = Advertiser::selectRaw('id, api_token')->where('api_token', $api_token)->first();

        if ($advertiser and $advertiser->api_token != null) {
            $messages = AdvertiserContacts::selectRaw('id, msg, from_id, to_id, created_at')->where(function ($q) use ($advertiser) {
                $q->where('to_id', $advertiser->id);
                $q->orWhere('from_id', $advertiser->id);
            })->where('parent_id', 0)->get();
            if ($messages) {
                $active_messages = AdvertiserContacts::where('to_id', $advertiser->id)
                    ->where('parent_id', 0)->where('reading', 0)->get();
                if (count($active_messages) > 0) {
                    foreach ($active_messages as $active) {
                        $active->update(['reading' => 1]);
                        $notifys = Notification_::where('adv_id', $active->id)->where('type', 1)->where('reading', 0)->get();
                        if ($notifys->count() > 0) {
                            $notifys->each->update(['reading' => 1]);
                        }
                    }
                }

                foreach ($messages as $message) {
                    if ($message->from_id == $advertiser->id) {
                        $to_advertiser = Advertiser::findOrFail($message->to_id)->name;
                        $message->message_with = str_limit($to_advertiser, 50) ?? '';
                    } else {
                        $from_advertiser = Advertiser::findOrFail($message->from_id)->name;
                        $message->message_with = str_limit($from_advertiser, 50) ?? '';
                    }

                    $message->message_date = Carbon::parse($message->created_at)->diffForHumans();

                    $message->message = $message->msg;
                }
                $messages = $messages->map(function ($message) {
                    return collect($message->toArray())
                        ->only(['id', 'message_with', 'message_date', 'message'])
                        ->all();
                });
                return response()->json([
                    'status' => true,
                    'data' => $messages
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يوجد رسائل لديك'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بيانات المعلن'
            ]);
        }
    }

    public function MessageReplies(Request $request)
    {
        $api_token = $request->api_token;
        $message_id = $request->message_id;
        $advertiser = Advertiser::selectRaw('id, api_token, name')->where('api_token', $api_token)->first();

        $messages = [
            'message_id.required' => 'برجاء ادخل بيانات الرسالة',
        ];
        $rules = [
            'message_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->return_errors($validator);
        } else {
            if ($advertiser and $advertiser->api_token != null) {
                $if_advertiser_msg_match = AdvertiserContacts::where(function ($q1) use ($advertiser, $message_id) {
                    $q1->where('from_id', $advertiser->id);
                    $q1->orWhere('to_id', $advertiser->id);
                })->where('id', $message_id)->first();

                if ($if_advertiser_msg_match) {
                    if($advertiser->id == $if_advertiser_msg_match->to_id){
                        $advertiser_name = Advertiser::selectRaw('name')->where('id', $if_advertiser_msg_match->from_id)->first();
                        $other_side_name = $advertiser_name->name;
                    }else{
                        $other_side_name = $advertiser->name;
                    }


                    $active_messages = AdvertiserContacts::where('parent_id', $message_id)
                        ->where('reading', 0)->get();
                    if (count($active_messages) > 0) {
                        foreach ($active_messages as $active) {
                            if ($active->to_id == $advertiser->id) {
                                $notifys = Notification_::where('adv_id', $active->parent_id)
                                    ->where('advertiser_id', $active->to_id)
                                    ->where('type', 5)->where('reading', 0)->get();
                                if ($notifys->count() > 0) {
                                    $notifys->each->update(['reading' => 1]);
                                }
                                $active->update(['reading' => 1]);
                            }
                        }
                    }

                    $from_advertiser = Advertiser::findOrFail($if_advertiser_msg_match->from_id)->name;

                    $msgs = AdvertiserContacts::where(function ($q1) use ($message_id) {
                        $q1->where('id', $message_id);
                        $q1->orWhere('parent_id', $message_id);
                    })->orderBy('id', 'asc')->get();

                    $msgs->each(function ($msg) {
                        $msg->reply = $msg->msg ?? '';
                        $msg->reply_date = Carbon::parse($msg->created_at)->diffForHumans() ?? '';
                        $msg->reply_advertiser = $msg->from_id;
                        $msg->other_side = $msg->to_id;
                    });

                    $msgs = $msgs->map(function ($msg) {
                        return collect($msg->toArray())
                            ->only(['other_side', 'reply', 'reply_date', 'reply_advertiser'])
                            ->all();
                    });
                    return response()->json([
                        'status' => true,
                        'data' => $msgs,
                        'other_side_name' => $other_side_name,
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'بيانات الرسالة لا تخص هذا المعلن'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'خطأ فى بيانات المعلن'
                ]);
            }
        }
    }

    public function ReplyMessage(Request $request)
    {
        $api_token = $request->api_token;
        $advertiser = Advertiser::selectRaw('id, api_token')->where('api_token', $api_token)->first();

        if ($advertiser and $advertiser->api_token != null) {
            $messages = [
                'reply.required' => 'برجاء ادخال الرد على الرسالة',
            ];
            $rules = [
                'reply' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->return_errors($validator);
            } else {
                $msg = AdvertiserContacts::selectRaw('from_id, to_id')->where('id', $request->message_id)->first();

                if ($msg) {
                    $message_reply = new AdvertiserContacts();
                    $message_reply->msg = $request->reply;
                    $message_reply->from_id = $advertiser->id;
                    if ($msg->from_id == $advertiser->id) {
                        $message_reply->to_id = $msg->to_id;
                    } else {
                        $message_reply->to_id = $msg->from_id;
                    }
                    $message_reply->parent_id = $request->message_id;
                    $action = $message_reply->save();

                    if ($action) {
                        $notify = new Notification_();
                        $notify->content = 'لديك رد جديد على رسالة';
                        $notify->adv_id = $message_reply->parent_id;
                        $notify->advertiser_id = $message_reply->to_id;
                        $notify->type = 5;
                        $notify->save();

                        $user = Advertiser::selectRaw('player_id')->findOrFail($message_reply->to_id);
                        if ($user->player_id != null or $user->player_id != '') {
                            $tokens = [$user->player_id];
                            $content = $notify->content;
                            $data = ['message_id' => $message_reply->parent_id, 'type' => $notify->type];
                            sendNote($tokens, $content, $data);
                        }

                        return response()->json([
                            'status' => true,
                            'message' => 'تم الرد على الرساله بنجاح'
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'حدث خطأ ما اثناء الرد على الرسالة'
                        ]);
                    }

                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'الرساله غير موجوده'
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'خطأ فى بياناتك برجاء المحاوله مره اخرى '
            ]);
        }
    }

}
