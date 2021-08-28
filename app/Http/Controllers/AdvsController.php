<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\AdvertiserContacts;
use App\AdvertiserFavourite;
use App\AdvertiserRatings;
use App\AdvImgs;
use App\AdvRatings;
use App\Advs;
use App\City;
use App\ContactUs;
use App\Favourite;
use App\Followers;
use App\InternalSection;
use App\MainSection;
use App\Notification_;
use App\ReportingReasons;
use App\Haraj_One_Info;
use App\SideAdvs;
use App\SubSection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AdvsController extends Controller
{
    /** static functions */
    public static function calc_duration($start_date)
    {
        //Carbon::setLocale(config('app.locale'))
        Carbon::setLocale('ar');
        $start = Carbon::parse($start_date);
        return $start->diffForHumans();
    }

    public static function get_advertiser($id)
    {
        $advertiser = Advertiser::findOrFail($id);
        return $advertiser;
    }

    public static function get_adv_ratings($adv_id)
    {
        $adv_sum = AdvRatings::where('adv_id', $adv_id)
            ->where('type', 1)->sum('rating');
        $adv_ratings = AdvRatings::where('adv_id', $adv_id)
            ->where('type', 1)->get();
        if ($adv_ratings->count() == 0) {
            $num_formate = number_format($adv_sum, 1);
        } else {
            $num_formate = number_format($adv_sum / $adv_ratings->count(), 1);
        }
        return $num_formate;
    }

    public static function get_count_ratings($adv_id)
    {
        $ra = AdvRatings::where('adv_id', $adv_id)
            ->where('type', 0)->get();
        return count($ra);
    }

    public static function get_adv_percent($adv_id, $rating)
    {
        $percent = AdvRatings::where('adv_id', $adv_id)
            ->where('rating', $rating)
            ->get();
        return count($percent);
    }

    public static function get_adv_img($adv_id)
    {
        $img = AdvImgs::where('adv_id', $adv_id)->first();
        if ($img) {
            return $img;
        } else {
            return null;
        }
    }

    public static function get_small_img($adv_id)
    {
        $img = AdvImgs::where('adv_id', $adv_id)->first();
        if ($img) {
            $split = explode('/', $img->img);
            if (file_exists('public/img/small/' . $split[2])) {
                return 'public/img/small/' . $split[2];
            } else {
                if (file_exists($img->img)) {
                    return $img->img;
                } else {
                    return null;
                }
            }
        } else {
            return null;
        }

    }

    public static function get_menus()
    {
        return MainSection::all();
    }

    public static function get_menus_sub($main_id)
    {
        return SubSection::where('main_id', $main_id)->get();
    }

    public static function get_menus_internal($main_id, $sub_id)
    {
        return InternalSection::where('main_id', $main_id)
            ->where('sub_id', $sub_id)->get();
    }

    public static function is_follow($advertiser_id, $follower_id)
    {
        if (Followers::where('advertiser_id', $advertiser_id)->where('follower_id', $follower_id)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_favourite($advertiser_id, $adv_id)
    {
        if (Favourite::where('advertiser_id', $advertiser_id)->where('adv_id', $adv_id)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_adv($id)
    {
        $adv = Advs::findOrFail($id);
        return $adv;
    }

    public static function is_advertiser_favourite($advertiser_id, $favourite_advertiser)
    {
        if (AdvertiserFavourite::where('advertiser_id', $advertiser_id)->where('favourite_advertiser', $favourite_advertiser)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_advertiser_rating($advertiser_id, $rater)
    {
        if (AdvertiserRatings::where('advertiser_id', $advertiser_id)->where('voter_id', $rater)->exists()) {
            return true;
        } else {
            return false;
        }
    }


    /** ajax functions  >>  on change */
    public function get_car_types(Request $request)
    {

        $car_brand_id = $request->car_brand_id;
        $get_car_types_ = InternalSection::where('main_id', 1)
            ->where('sub_id', $car_brand_id)
            ->select('id', 'name')
            ->get();
        $data = '<option value="0">اختر نوع السيارة</option>';
        foreach ($get_car_types_ as $type) {
            $data .= '<option value="' . $type->id . '">' . $type->name . '</option>';
        }
        return response()->json($data);
    }

    public function bottom_filter1_123_(Request $request)
    {
        $main_section_id = $request->main_section_id;
        $city_id = $request->city_id;
        $advertiser_id = $request->advertiser_id;

        if ($request->city_id == 0) {
            $asd = '!=';
        } else {
            $asd = '=';
        }
        if ($request->main_section_id == 0) {
            $asd2 = '!=';
        } else {
            $asd2 = '=';
        }
        $advs_ = Advs::where('main_section', $asd2, $main_section_id)
            ->where('city', $asd, $city_id)
            ->where('advertiser_id', $advertiser_id)
            ->where('agree', 1)
            ->orderBy('updated_at', 'desc')
            ->get();


        $data3 = '';
        if (count($advs_) > 0) {
            foreach ($advs_ as $adv) {
                $data3 .= '<a style="color: #000" href="' . url('/adv/' . $adv->id) . '">
                        <div class="my-3 bg-color-white py-2 overflow-hidden my_div2">
                            <div class="col-md-10 col-xs-10">
                                <div class="border-bottom">
                                    <h4 class="string_limit2 color-gold">' . $adv->title . '</h4>
                                </div>
                                <div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pt-3">
                                            <p>' . $this::get_count_ratings($adv->id) . ' ردود ' . '</p>
                                            <p class="string_limit pt-2"><i class="fa fa-map-marker"></i> ';
                if ($adv->city) {
                    $adv_city = ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة';
                    $adv_area = ($adv->City) ? $adv->City->name : 'بدون مدينة';
                    $adv_city_area = $adv_area . ' , ' . $adv_city;
                } else {
                    $adv_city_area = 'بدون عنوان';
                }
                $data3 .= $adv_city_area . '</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pull-left pt-3">
                                            <p><i class="fa fa-clock-o"></i>
                                                <small>' . $this::calc_duration($adv->updated_at) . '</small>
                                            </p>
                                            <a style="color: #000" href="' . url('/advertiser/' . $adv->advertiser_id) . '">
                                                <p class="pt-2 string_limit">';
                if ($adv->Advertiser->special == 1) {
                    $data3 .= '<img src="' . asset('public/img/ustar.png') . '">';
                } else {
                    $data3 .= '<i class="fa fa-user-o "></i>';
                }
                $data3 .= '<small>' . $adv->Advertiser->name . '</small>
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2 col-xs-2">
                                <img alt="image" class="adv_height adv-hi img-responsive img-rounded" src="';
                if (is_null($this->get_small_img($adv->id))) {
                    $data3 .= asset('public/img/no_img.png');
                } else {
                    $data3 .= asset($this->get_small_img($adv->id));
                }
                $data3 .= '">
                            </div>
                        </div>
                    </a>';
            }
        } else {
            $data3 .= '
            <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                <h2>لا توجد إعلانات متاحة حتى الأن ...</h2>
            </div>';
        }

        return response()->json([$data3]);
    }

    public function bottom_filter1(Request $request)
    {

        $main_section_id = $request->main_section_id;
        $city_id = $request->city_id;
        $search = $request->search;

        $get_sub_sections_ = SubSection::where('main_id', $main_section_id)
            ->select('id', 'name')
            ->get();

        $data1 = '<option value="0">كل الاقسام الفرعية</option>';
        foreach ($get_sub_sections_ as $sub) {
            $data1 .= '<option value="' . $sub->id . '">' . $sub->name . '</option>';
        }
        $data2 = '<option value="0">كل الاقسام الداخلية</option>';

        $years = '';
//        if($main_section_id == 1) {
//            $years = '<select class="form-control m-b" name="car_year_" id="_car_year_" required>
//                      <option value="0">كل الموديلات</option>';
//            for ($y = Carbon::now()->year; $y > 1969; $y--) {
//                $years .= '<option value="' . $y . '">' . $y . '</option>';
//            }
//            $years .= '</select>';
//        }

        if ($request->city_id == 0) {
            $asd = '!=';
        } else {
            $asd = '=';
        }
        if ($request->main_section_id == 0) {
            $asd2 = '!=';
        } else {
            $asd2 = '=';
        }
        $advs_ = Advs::where('main_section', $asd2, $main_section_id)
            ->where('city', $asd, $city_id)
            ->where('title', 'LIKE', '%' . $search . '%')
            ->where('agree', 1)
            ->orderBy('updated_at', 'desc')
            ->get();


        $data3 = '';
        if (count($advs_) > 0) {
            foreach ($advs_ as $adv) {
                $data3 .= '<a style="color: #000" href="' . url('/adv/' . $adv->id) . '">
                        <div class="my-3 bg-color-white py-2 overflow-hidden my_div2">
                            <div class="col-md-10 col-xs-10">
                                <div class="border-bottom">
                                    <h4 class="string_limit2 color-gold">' . $adv->title . '</h4>
                                </div>
                                <div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pt-3">
                                            <p>' . $this::get_count_ratings($adv->id) . ' ردود ' . '</p>
                                            <p class="string_limit pt-2"><i class="fa fa-map-marker"></i> ';
                if ($adv->city) {
                    $adv_city = ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة';
                    $adv_area = ($adv->City) ? $adv->City->name : 'بدون مدينة';
                    $adv_city_area = $adv_area . ' , ' . $adv_city;
                } else {
                    $adv_city_area = 'بدون عنوان';
                }
                $data3 .= $adv_city_area . '</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pull-left pt-3">
                                            <p><i class="fa fa-clock-o"></i>
                                                <small>' . $this::calc_duration($adv->updated_at) . '</small>
                                            </p>
                                            <a style="color: #000" href="' . url('/advertiser/' . $adv->advertiser_id) . '">
                                                <p class="pt-2 string_limit">';
                if ($adv->Advertiser->special == 1) {
                    $data3 .= '<img src="' . asset('public/img/ustar.png') . '">';
                } else {
                    $data3 .= '<i class="fa fa-user-o "></i>';
                }
                $data3 .= '<small>' . $adv->Advertiser->name . '</small>
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2 col-xs-2">
                                <img alt="image" class="adv_height adv-hi img-responsive img-rounded" src="';
                if (is_null($this->get_small_img($adv->id))) {
                    $data3 .= asset('public/img/no_img.png');
                } else {
                    $data3 .= asset($this->get_small_img($adv->id));
                }
                $data3 .= '">
                            </div>
                        </div>
                    </a>';
            }
        } else {
            $data3 .= '
            <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                <h2>لا توجد إعلانات متاحة حتى الأن ...</h2>
            </div>';
        }

        return response()->json([$data1, $data2, $data3, $years]);
    }

    public function bottom_filter2(Request $request)
    {

        $main_section_id = $request->main_section_id;
        $sub_section_id = $request->sub_section_id;
        $city_id = $request->city_id;
        $search = $request->search;


        $get_sub_sections_ = SubSection::where('main_id', $main_section_id)
            ->select('id', 'name')
            ->get();
        $get_internal_sections_ = InternalSection::where('main_id', $main_section_id)
            ->where('sub_id', $sub_section_id)
            ->select('id', 'name')
            ->get();

        $data1 = '<option value="0">كل الاقسام الفرعية</option>';
        foreach ($get_sub_sections_ as $sub) {
            $data1 .= '<option value="' . $sub->id . '"';
            if ($sub_section_id == $sub->id) {
                $data1 .= ' selected';
            }
            $data1 .= '>' . $sub->name . '</option>';
        }

        $data2 = '<option value="0">كل الاقسام الداخلية</option>';
        foreach ($get_internal_sections_ as $internal) {
            $data2 .= '<option value="' . $internal->id . '">' . $internal->name . '</option>';
        }


        if ($request->city_id == 0) {
            $asd = '!=';
        } else {
            $asd = '=';
        }
        if ($request->sub_section_id == 0) {
            $asd2 = '!=';
        } else {
            $asd2 = '=';
        }
        $advs_ = Advs::where('main_section', $main_section_id)
            ->where('sub_section', $asd2, $sub_section_id)
            ->where('city', $asd, $city_id)
            ->where('title', 'LIKE', '%' . $search . '%')
            ->where('agree', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        $data3 = '';
        if (count($advs_) > 0) {
            foreach ($advs_ as $adv) {
                $data3 .= '
            <a style="color: #000" href="' . url('/adv/' . $adv->id) . '">
                        <div class="my-3 bg-color-white py-2 overflow-hidden my_div2">
                            <div class="col-md-10 col-xs-10">
                                <div class="border-bottom">
                                    <h4 class="string_limit2 color-gold">' . $adv->title . '</h4>
                                </div>
                                <div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pt-3">
                                            <p>' . $this::get_count_ratings($adv->id) . ' ردود ' . '</p>
                                            <p class="string_limit pt-2"><i class="fa fa-map-marker"></i> ';
                if ($adv->city) {
                    $adv_city = ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة';
                    $adv_area = ($adv->City) ? $adv->City->name : 'بدون مدينة';
                    $adv_city_area = $adv_area . ' , ' . $adv_city;
                } else {
                    $adv_city_area = 'بدون عنوان';
                }
                $data3 .= $adv_city_area . '</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pull-left pt-3">
                                            <p><i class="fa fa-clock-o"></i>
                                                <small>' . $this::calc_duration($adv->updated_at) . '</small>
                                            </p>
                                            <a style="color: #000" href="' . url('/advertiser/' . $adv->advertiser_id) . '">
                                                <p class="pt-2 string_limit">';
                if ($adv->Advertiser->special == 1) {
                    $data3 .= '<img src="' . asset('public/img/ustar.png') . '">';
                } else {
                    $data3 .= '<i class="fa fa-user-o "></i>';
                }
                $data3 .= '<small>' . $adv->Advertiser->name . '</small>
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2 col-xs-2">
                                <img alt="image" class="adv_height adv-hi img-responsive img-rounded" src="';
                if (is_null($this->get_small_img($adv->id))) {
                    $data3 .= asset('public/img/no_img.png');
                } else {
                    $data3 .= asset($this->get_small_img($adv->id));
                }
                $data3 .= '">
                            </div>
                        </div>
                    </a>';
            }
        } else {
            $data3 .= '
            <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                <h2>لا توجد إعلانات متاحة حتى الأن ...</h2>
            </div>';
        }

        return response()->json([$data1, $data2, $data3]);
    }

    public function bottom_filter3(Request $request)
    {

        $main_section_id = $request->main_section_id;
        $sub_section_id = $request->sub_section_id;
        $internal_section_id = $request->internal_section_id;
        $city_id = $request->city_id;
        $search = $request->search;


        $get_sub_sections_ = SubSection::where('main_id', $main_section_id)
            ->select('id', 'name')
            ->get();
        $get_internal_sections_ = InternalSection::where('main_id', $main_section_id)
            ->where('sub_id', $sub_section_id)
            ->select('id', 'name')
            ->get();

        $data1 = '<option value="0">كل الاقسام الفرعية</option>';
        foreach ($get_sub_sections_ as $sub) {
            $data1 .= '<option value="' . $sub->id . '"';
            if ($sub_section_id == $sub->id) {
                $data1 .= ' selected';
            }
            $data1 .= '>' . $sub->name . '</option>';
        }
        $data2 = '<option value="0">كل الاقسام الداخلية</option>';
        foreach ($get_internal_sections_ as $internal) {
            $data2 .= '<option value="' . $internal->id . '"';
            if ($internal_section_id == $internal->id) {
                $data2 .= ' selected';
            }
            $data2 .= '>' . $internal->name . '</option>';
        }


        if ($city_id == 0) {
            $asd = '!=';
        } else {
            $asd = '=';
        }
        if ($internal_section_id == 0) {
            $asd2 = '!=';
            $asd3 = -1;
        } else {
            $asd2 = '=';
            $asd3 = $internal_section_id;
        }
        $advs_ = Advs::where('main_section', $main_section_id)
            ->where('sub_section', $sub_section_id)
            ->where('internal_section', $asd2, $asd3)
            ->where('city', $asd, $city_id)
            ->where('title', 'LIKE', '%' . $search . '%')
            ->where('agree', 1)
            ->orderBy('updated_at', 'desc')
            ->get();


        $data3 = '';
        if (count($advs_) > 0) {
            foreach ($advs_ as $adv) {
                $data3 .= '
            <a style="color: #000" href="' . url('/adv/' . $adv->id) . '">
                        <div class="my-3 bg-color-white py-2 overflow-hidden my_div2">
                            <div class="col-md-10 col-xs-10">
                                <div class="border-bottom">
                                    <h4 class="string_limit2 color-gold">' . $adv->title . '</h4>
                                </div>
                                <div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pt-3">
                                            <p>' . $this::get_count_ratings($adv->id) . ' ردود ' . '</p>
                                            <p class="string_limit pt-2"><i class="fa fa-map-marker"></i> ';
                if ($adv->city) {
                    $adv_city = ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة';
                    $adv_area = ($adv->City) ? $adv->City->name : 'بدون مدينة';
                    $adv_city_area = $adv_area . ' , ' . $adv_city;
                } else {
                    $adv_city_area = 'بدون عنوان';
                }
                $data3 .= $adv_city_area . '</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pull-left pt-3">
                                            <p><i class="fa fa-clock-o"></i>
                                                <small>' . $this::calc_duration($adv->updated_at) . '</small>
                                            </p>
                                            <a style="color: #000" href="' . url('/advertiser/' . $adv->advertiser_id) . '">
                                                <p class="pt-2 string_limit">';
                if ($adv->Advertiser->special == 1) {
                    $data3 .= '<img src="' . asset('public/img/ustar.png') . '">';
                } else {
                    $data3 .= '<i class="fa fa-user-o "></i>';
                }
                $data3 .= '<small>' . $adv->Advertiser->name . '</small>
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2 col-xs-2">
                                <img alt="image" class="adv_height adv-hi img-responsive img-rounded" src="';
                if (is_null($this->get_small_img($adv->id))) {
                    $data3 .= asset('public/img/no_img.png');
                } else {
                    $data3 .= asset($this->get_small_img($adv->id));
                }
                $data3 .= '">
                            </div>
                        </div>
                    </a>';
            }
        } else {
            $data3 .= '
            <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                <h2>لا توجد إعلانات متاحة حتى الأن ...</h2>
            </div>';
        }

        return response()->json([$data1, $data2, $data3]);
    }


    /** ajax function  >>  on page load */
    public function get_car_types2(Request $request)
    {

        $car_brand_id = $request->car_brand_id;
        $car_type_id = $request->car_type_id;
        $get_car_types_ = InternalSection::where('main_id', 1)
            ->where('sub_id', $car_brand_id)
            ->select('id', 'name')
            ->get();
        $data = '<option value="0">اختر نوع السيارة</option>';
        foreach ($get_car_types_ as $type) {
            $data .= '<option ';
            if ($car_type_id == $type->id) {
                $data .= 'selected';
            }
            $data .= ' value="' . $type->id . '">' . $type->name . '</option>';
        }
        return response()->json($data);
    }


    /** index page */
    public function index(Request $request)
    {
        $advs = Advs::query()->where('agree', 1)->orderBy('updated_at', 'desc');

        $all_advs = $advs;

        if ($request->has('car_brand')) {
            if ($request->car_year == 0) {
                $asd = '!=';
            } else {
                $asd = '=';
            }
            if ($request->car_type == 0) {
                $asd2 = '!=';
                $asd3 = $request->car_type - 1;
            } else {
                $asd2 = '=';
                $asd3 = $request->car_type;
            }
            $advs = $advs->where('main_section', 1)
                ->where('sub_section', $request->car_brand)
                ->where('internal_section', $asd2, $asd3)
                ->where('year', $asd, $request->car_year);
        }
        if ($request->filled('search')) {
            $advs = $advs->where('title', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->has('city')) {
            if ($request->city == 0) {
                $asd = '!=';
            } else {
                $asd = '=';
            }
            $advs = $advs->where('city', $asd, $request->city);
        }
        if ($request->has('main_section')) {
            if ($request->main_section == 0) {
                $asd = '!=';
            } else {
                $asd = '=';
            }
            $advs = $advs->where('main_section', $asd, $request->main_section);
        }
        if ($request->has('sub_section')) {
            if ($request->sub_section == 0) {
                $asd = '!=';
            } else {
                $asd = '=';
            }
            $advs = $advs->where('sub_section', $asd, $request->sub_section);
        }
        if ($request->has('internal_section')) {
//            if($request->internal_section == 0){$asd = '!=';}else{$asd = '=';}
            $advs = $advs->where('internal_section', $request->internal_section);
        }

        $advs = $advs->paginate(10);

        if ($request->ajax()) {
            $view = view('index_render', compact('advs'))->render();
            return response()->json(['html' => $view]);
        }

        $cities_ = City::all();
        $main_sections_ = MainSection::all();
        $sub_sections_ = SubSection::where('main_id', '1')->get();

        $value = Cookie::get('visit_sel3h');
        if (!isset($value)) {
            Cookie::queue('visit_sel3h', 'yes', 2628000);//5 years
            Haraj_One_Info::findOrFail(1)->increment('visits');
        }

        $side_advs = SideAdvs::all();

        return view('index')
            ->with(array(
                'advs' => $advs,
                'sub_sections' => $sub_sections_,
                'main_sections' => $main_sections_,
                'cities' => $cities_,
                'side_advs' => $side_advs,
                'all_advs' => $all_advs,
            ));
    }

    public function adv_details($adv_id)
    {
        if (auth()->check() and auth()->user()->roles == 1) {
            $adv = Advs::where('id', $adv_id)->first();
            if (!$adv) {
                abort(404);
            }
        } else {
            $adv = Advs::where('id', $adv_id)->where('agree', 1)->first();
            if (!$adv) {
                abort(404);
            }
        }

        $adv_imgs = AdvImgs::where('adv_id', $adv_id)->get();

        if($adv_imgs->count() > 0){
            $meta_adv_img = url($adv_imgs->first()->img);
        }else{
            $meta_adv_img = url('public/img/no_img.png');
        }


        $advertiser = Advertiser::findOrFail($adv->advertiser_id);

        $adv_comments = AdvRatings::where('adv_id', $adv_id)
            ->where('type', 0)->get();
        $adv_ratings = AdvRatings::where('adv_id', $adv_id)
            ->where('type', 1)->get();
        $adv_sum = AdvRatings::where('adv_id', $adv_id)
            ->where('type', 1)->sum('rating');

        $advs = Advs::where('main_section', $adv->main_section)
            ->where('sub_section', $adv->sub_section)
            ->where('agree', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        $seo_desc = mb_substr((preg_replace('/\s+/', ' ', $adv->details)), 0, 160, "Utf-8");

        $adv_favourite_count = Favourite::where('adv_id', $adv_id)->get();
        $reasons = ReportingReasons::all();

        $old_updated_at = $adv->updated_at;
        $adv->increment('views');
        $adv->timestamps = false;
        $adv->updated_at = $old_updated_at;
        $adv->save();

        if ($adv->link != null) {
            $link_parts = parse_url($adv->link);
            $vid_id = isset($link_parts['query']) ? substr($link_parts['query'], 2) : '';
        } else {
            $vid_id = '';
        }

        return view('adv_details')
            ->with(array(
                'seo_title' => $adv->title,
                'seo_description' => $seo_desc,
                'adv' => $adv,
                'adv_imgs' => $adv_imgs,
                'advertiser' => $advertiser,
                'adv_comments' => $adv_comments,
                'adv_ratings' => $adv_ratings,
                'adv_sum' => $adv_sum,
                'advs_' => $advs,
                'reasons' => $reasons,
                'adv_favourite_count' => $adv_favourite_count->count(),
                'vid_id' => $vid_id,
                'meta_adv_img' => $meta_adv_img,
            ));
    }


    public function contact_me(Request $request)
    {
        $voter_name = Advertiser::findOrFail($request->from_id)->name;
        $this->validate($request, [
            'msg' => 'required|max:255',
        ]);

        $contacts = new AdvertiserContacts();
        $contacts->msg = $request->msg;
        $contacts->from_id = $request->from_id;
        $contacts->to_id = $request->to_id;
        $contacts->parent_id = $request->parent_id;
        $action = $contacts->save();

        if ($request->parent_id == 0) {
            $notify = new Notification_();
            $notify->content = 'لديك رسالة خاصة جديدة من '.$voter_name;
            $notify->adv_id = $contacts->id;
            $notify->advertiser_id = $request->to_id;
            $notify->type = 1;
            $action2 = $notify->save();


            $user_notify = Advertiser::findOrFail($request->to_id);
            if ($user_notify->player_id != null or $user_notify->player_id != '') {
                $tokens = [$user_notify->player_id];
                $content = $notify->content;
                $data = ['message_id' => $contacts->id, 'type' => $notify->type];
                sendNote($tokens, $content, $data);
            }


        } else {
            $notify = new Notification_();
            $notify->content = 'لديك رد جديد على رسالة من '.$voter_name;
            $notify->adv_id = $request->parent_id;
            $notify->advertiser_id = $request->to_id;
            $notify->type = 5;
            $action2 = $notify->save();

            $user_notify = Advertiser::findOrFail($request->to_id);
            if ($user_notify->player_id != null or $user_notify->player_id != '') {
                $tokens = [$user_notify->player_id];
                $content = $notify->content;
                $data = ['message_id' => $request->parent_id, 'type' => $notify->type];
                sendNote($tokens, $content, $data);
            }


        }


        if (!$action or !$action2) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم إرسال رسالتك بنجاح');
        }
    }

    public function rating(Request $request)
    {
        $voter_name = Advertiser::findOrFail($request->voter_id)->name;

        $ratings = new AdvRatings();
        if ($request->type == 0) {
            $this->validate($request, [
                'reply' => 'required|max:255',
            ]);
            $ratings->reply = $request->reply;
            $ratings->adv_id = $request->adv_id;
            $ratings->voter_id = $request->voter_id;
            $ratings->type = $request->type;
            $ratings_ = $ratings->save();

            // don't send notify for my comment
            if ($request->voter_id != $request->advertiser_id) {
                /* comment notification */
                $notify = new Notification_();
                $notify->content = 'لديك تعليق جديد بواسطة '.$voter_name;
                $notify->adv_id = $request->adv_id;
                $notify->advertiser_id = $request->advertiser_id;
                $notify->type = 4;
                $notify->save();

                $user_notify = Advertiser::findOrFail($request->advertiser_id);
                if ($user_notify->player_id != null or $user_notify->player_id != '') {
                    $tokens = [$user_notify->player_id];
                    $content = $notify->content;
                    $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
                    sendNote($tokens, $content, $data);
                }

            }

//            $fav_advs = Favourite::where('adv_id', $request->adv_id)->get();
//            if($fav_advs->count() > 0){
//                foreach($fav_advs as $fav){
//                    $charges[] = [
//                        'content' => 'تم التعليق على إعلان لديك بالمفضلة',
//                        'adv_id' => $fav->adv_id,
//                        'advertiser_id' => $fav->advertiser_id,
//                        'type' => 9,
//                        'created_at' => Carbon::now(),
//                        'updated_at' => Carbon::now()
//                    ];
//                }
//                Notification_::insert($charges);
//            }
        }
        else {
            $ratings = AdvRatings::updateOrCreate(
                [
                    'adv_id' => $request->adv_id,
                    'voter_id' => $request->voter_id,
                    'type' => 1
                ],
                [
                    'adv_id' => $request->adv_id,
                    'voter_id' => $request->voter_id,
                    'rating' => $request->rating,
                    'type' => $request->type
                ]
            );
            $ratings_ = $ratings->save();

            $notify = new Notification_();
            $notify->content = 'لديك تقييم جديد بواسطة '.$voter_name;
            $notify->adv_id = $request->adv_id;
            $notify->advertiser_id = $request->advertiser_id;
            $notify->type = 3;
            $notify->save();

            $user_notify = Advertiser::findOrFail($request->advertiser_id);
            if ($user_notify->player_id != null or $user_notify->player_id != '') {
                $tokens = [$user_notify->player_id];
                $content = $notify->content;
                $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
                sendNote($tokens, $content, $data);
            }


//            $fav_advs = Favourite::where('adv_id', $request->adv_id)->where('advertiser_id', '!=', auth()->id())->get();
//            if($fav_advs->count() > 0){
//                foreach($fav_advs as $fav){
//                    $charges[] = [
//                        'content' => 'تم التقييم على إعلان لديك بالمفضلة',
//                        'adv_id' => $fav->adv_id,
//                        'advertiser_id' => $fav->advertiser_id,
//                        'type' => 5,
//                        'created_at' => Carbon::now(),
//                        'updated_at' => Carbon::now()
//                    ];
//                }
//                Notification_::insert($charges);
//            }
        }

        if (!$ratings_) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            if ($request->type == 0) {
                return back()->with('success', 'تمت إضافة التعليق بنجاح');
            } else {
                return back()->with('success', 'تم التقييم بنجاح');
            }
        }
    }


    /** menu items */
    public function show($name)
    {
        $requests = Request::capture();

        $main_sections_ = MainSection::where('name', $name)->first();
        $sub_sections_ = SubSection::where('main_id', $main_sections_->id)->get();
        $cities_ = City::all();

        if ($requests->filled('search')) {
            $advs = Advs::where('main_section', $main_sections_->id)
                ->where('title', 'LIKE', '%' . $requests->search . '%')
                ->where('agree', 1)
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
            $advs = Advs::where('main_section', $main_sections_->id)
                ->where('agree', 1)
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }


        return view('section')
            ->with(array(
                'seo_title' => $name,
                'main_sections' => $main_sections_,
                'advs' => $advs,
                'sub_sections' => $sub_sections_,
                'cities' => $cities_,
            ));
    }


    /** advertiser page */
    public function advertiser_details($advertiser_id)
    {
        $cities_ = City::all();
        $main_sections_ = MainSection::all();

        $advertiser = Advertiser::findOrFail($advertiser_id);
        $followers = Followers::where('advertiser_id', $advertiser_id)->get();
        $ratings = AdvertiserRatings::where('advertiser_id', $advertiser_id)->get();

        $advs = Advs::where('advertiser_id', $advertiser->id)
            ->where('agree', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('advertiser')
            ->with(array(
                'seo_title' => 'حراج واحد | ' . $advertiser->name,
                'advertiser' => $advertiser,
                'advs' => $advs,
                'followers' => $followers,
                'ratings' => $ratings,
                'main_sections' => $main_sections_,
                'cities' => $cities_,
            ));
    }

    public function follow_me(Request $request)
    {
        $follower_name = Advertiser::findOrFail($request->follower_id)->name;

        $check = Followers::where('advertiser_id', $request->advertiser_id)
            ->where('follower_id', $request->follower_id)->first();
        if($check){
            $check->delete();
            $notify = new Notification_();
            $notify->content = 'تمت إلغاء متابعتك من طرف ' . $follower_name;
            $notify->adv_id = 0;
            $notify->advertiser_id = $request->advertiser_id;
            $notify->type = 6;
            $notify->save();

            $user_notify = Advertiser::findOrFail($request->advertiser_id);
            if ($user_notify->player_id != null or $user_notify->player_id != '') {
                $tokens = [$user_notify->player_id];
                $content = $notify->content;
                $data = ['follow_id' => $request->follower_id, 'type' => $notify->type];
                sendNote($tokens, $content, $data);
            }
            return back()->with('success','تم إلغاء المتابعة بنجاح');
        }

        $followers = new Followers();
        $followers->advertiser_id = $request->advertiser_id;
        $followers->follower_id = $request->follower_id;
        $action = $followers->save();

        $notify = new Notification_();
        $notify->content = 'تمت متابعتك من طرف ' . $follower_name;
        $notify->adv_id = 0;
        $notify->advertiser_id = $request->advertiser_id;
        $notify->type = 6;
        $action2 = $notify->save();


        $user_notify = Advertiser::findOrFail($request->advertiser_id);
        if ($user_notify->player_id != null or $user_notify->player_id != '') {
            $tokens = [$user_notify->player_id];
            $content = $notify->content;
            $data = ['follow_id' => $request->follower_id, 'type' => $notify->type];
            sendNote($tokens, $content, $data);
        }

        if (!$action or !$action2) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم متابعة المعلن بنجاح');
        }
    }

    public function advertiser_rating(Request $request)
    {
        $voter_name = Advertiser::findOrFail($request->voter_id)->name;
        $ratings = AdvertiserRatings::updateOrCreate(
            [
                'advertiser_id' => $request->advertiser_id,
                'voter_id' => $request->voter_id
            ],
            [
                'rating' => $request->rating,
                'advertiser_id' => $request->advertiser_id,
                'voter_id' => $request->voter_id
            ]
        );
        $ratings_ = $ratings->save();

        $notify = new Notification_();
        $notify->content = 'لديك تقييم شخصى جديد من '.$voter_name;
        $notify->adv_id = 0;
        $notify->advertiser_id = $request->advertiser_id;
        $notify->type = 7;
        $action2 = $notify->save();


        $user_notify = Advertiser::findOrFail($request->advertiser_id);
        if ($user_notify->player_id != null or $user_notify->player_id != '') {
            $tokens = [$user_notify->player_id];
            $content = $notify->content;
            $data = ['voter_id' => $request->voter_id, 'type' => $notify->type];
            sendNote($tokens, $content, $data);
        }

        if (!$ratings_ or !$action2) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم التقييم بنجاح');
        }
    }


    /** contact us page */
    public function ContactUsShow()
    {
        $info = Haraj_One_Info::first();
        return view('contact_us')
            ->with(array(
                'info' => $info,
            ));
    }

    public function ContactUsSend(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'required|max:255',
            'e_mail' => 'required|email|',
//            'title' => 'required|max:255',
            'msg' => 'required',
        ]);

        $contact_us = new ContactUs();
        $contact_us->name = $request->name;
        $contact_us->mobile = $request->mobile;
        $contact_us->e_mail = $request->e_mail;
//        $contact_us->title = $request->title;
        $contact_us->msg = $request->msg;
        $contact_us_ = $contact_us->save();

        if (!$contact_us_) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم إرسال رسالتك بنجاح');
        }
    }

    public function get_sections_map()
    {
        return view('sections_map');
    }

}
