<?php

namespace App\Http\Controllers;

use App\AdvertiserContacts;
use App\AdvImgs;
use App\AdvRatings;
use App\Advs;
use App\Area;
use App\City;
use App\Favourite;
use App\Haraj_One_Info;
use App\InternalSection;
use App\MainSection;
use App\Notification_;
use App\Reports;
use App\SubSection;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class AddAdvController extends Controller
{
    public function get_all_images(Request $request){
        $images = $request->except(['_token']);

        $arr = [];
        foreach($images as $img){
            $name = 'public/img/'.date('Ymdhis').'_'.rand(0, 999).'.jpg';
            file_put_contents($name,base64_decode($img));
            $arr[] = $name;
        }

        return response()->json([$arr]);
    }
    public function adv_update($id){
        $adv = Advs::findOrFail($id);
        $hour_update = Haraj_One_Info::findOrFail(1)->hour_update;

        if(Carbon::parse($adv->updated_at)->addHours($hour_update) >= Carbon::now()){
            return back()->with('error','تحديث الإعلان مرة واحدة كل '.$hour_update.' ساعة');
        }else{
            $adv->updated_at = Carbon::now();
            $action = $adv->save();

            if(!$action){return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');}
            else{
                return back()->with('success','تم تحديث الإعلان بنجاح');
            }
        }
    }

    public static function get_cities($area_id){
        $get_cities = City::where('area_id', $area_id)
            ->select('id', 'name')->get();
        return $get_cities;
    }
    public static function get_sub_sections($main_id){
        $get_subs = SubSection::where('main_id', $main_id)
            ->select('id', 'name')->get();
        return $get_subs;
    }
    public static function get_internal_sections($sub_id){
        $get_internals = InternalSection::where('sub_id', $sub_id)
            ->select('id', 'name')->get();
        return $get_internals;
    }

    /** ajax functions  >>  on change */
    public function bottom_filter1_(Request $request){

        $main_section_id = $request->main_section_id;

        $get_sub_sections_ = SubSection::where('main_id', $main_section_id)
            ->select('id', 'name')
            ->get();

        $data1 = '<option value="">اختر القسم الفرعى ...</option>';
        foreach($get_sub_sections_ as $sub){
            $data1 .= '<option value="'.$sub->id.'">'.$sub->name.'</option>';
        }

        $data2 = '<option value="0">اختر القسم الداخلى ...</option>';

        $years = '';
        if($main_section_id == 1) {
            $years = '<select class="form-control selectpicker" name="car_year" data-live-search="true" required>
                      <option value="">اختر موديل السيارة ...</option>';
            for ($y = Carbon::now()->year; $y > 1969; $y--) {
                $years .= '<option value="' . $y . '">' . $y . '</option>';
            }
            $years .= '</select>';
        }

        return response()->json([$data1, $data2, $years]);
    }
    public function bottom_filter2_(Request $request){

        $main_section_id = $request->main_section_id;
        $sub_section_id = $request->sub_section_id;


        $get_sub_sections_ = SubSection::where('main_id', $main_section_id)
            ->select('id', 'name')
            ->get();
        $get_internal_sections_ = InternalSection::where('main_id', $main_section_id)
            ->where('sub_id', $sub_section_id)
            ->select('id', 'name')
            ->get();

        $data1 = '<option value="">اختر القسم الفرعى ...</option>';
        foreach($get_sub_sections_ as $sub){
            $data1 .= '<option value="'.$sub->id.'"';
            if($sub_section_id == $sub->id){$data1 .=' selected';}
            $data1 .= '>'.$sub->name.'</option>';
        }

        $data2 = '<option value="0">اختر القسم الداخلى ...</option>';
        foreach($get_internal_sections_ as $internal){
            $data2 .= '<option value="'.$internal->id.'">'.$internal->name.'</option>';
        }

        return response()->json([$data1, $data2]);
    }
    public function bottom_filter3_(Request $request){
        $area_id = $request->area_id;

        $get_cities = City::where('area_id', $area_id)
            ->select('id', 'name')
            ->get();

        $data1 = '<option value="">اختر المدينة</option>';
        foreach($get_cities as $city){
            $data1 .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }

        return response()->json([$data1]);
    }

    public function del_img(Request $request){

        $img_id = $request->img_id;

        $adv_img = AdvImgs::findOrFail($img_id);
        if (file_exists($adv_img->img)) {
            unlink($adv_img->img);
        }
        $split = explode('/', $adv_img->img);
        if (file_exists('public/img/small/'.$split[2])) {
            unlink('public/img/small/'.$split[2]);
        }
        $adv_img_ = AdvImgs::findOrFail($img_id)->delete();

        $adv_imgs = AdvImgs::where('adv_id', $adv_img->adv_id)->get();

        $data = '';
        foreach($adv_imgs as $img){
            $data .= '<div class="col-sm-3 mb-3">
                            <img alt="image" style="width: 200px; height: 200px;" class="img-responsive img-rounded img-thumbnail" src="'.asset($img->img).'">
                            <button type="button" value="'.$img->id.'" class="del btn btn-danger btn-block"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف الصورة</button>
                        </div>';
        }
        if(!$adv_img_){
            return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');
        }else{
            return response()->json([$data]);
        }
    }

    public function bottom_filter1_123(Request $request)
    {
        $main_section_id = $request->main_section_id;
        $city_id = $request->city_id;

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
            ->where('advertiser_id', auth()->id())
            ->where('agree', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = '';
        if (count($advs_) > 0) {
            foreach ($advs_ as $adv) {
                $class="";
                if(session('display') == 'tiles')
                {
                    $class="col-md-6";
                }
                if (is_null(AdvsController::get_small_img($adv->id))) {
                    $img = asset('public/img/no_img.png');
                }else{
                    $img = asset(AdvsController::get_small_img($adv->id));
                }
                $data .='<a style="color: #000" href="'.url('/adv/'.$adv->id).'">
                    <div class="'.$class.' my-3 bg-color-white py-2 overflow-hidden my_div2 my_div2_">
                        <div class="col-md-10 col-xs-10">
                            <div class="col-md-12 col-xs-12">
                                <h4 class="string_limit2 color-gold">'.$adv->title.'</h4>
                            </div>
                            <div class="clearfix border-bottom"></div>

                            <div>
                                <div class="col-md-5 col-xs-6 small_font">
                                    <div class="pt-3">
                                            <p>'.AdvsController::get_count_ratings($adv->id).' ردود ' .'</p>
                                            <p class="string_limit pt-2"><i class="fa fa-map-marker"></i> ';
                                            if($adv->city){
                                                $adv_city = ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة';
                                                $adv_area = ($adv->City) ? $adv->City->name : 'بدون مدينة' ;
                                                $adv_city_area = $adv_area.' , '.$adv_city;
                                            }else{
                                                $adv_city_area = 'بدون عنوان';
                                            }
                                        $data .= $adv_city_area.'</p>
                                        </div>
                                </div>
                                <div class="col-md-4 col-xs-6 small_font">
                                    <div class="pull-left pt-3">
                                        <p><i class="fa fa-clock-o"></i>
                                            <small>'.AdvsController::calc_duration($adv->updated_at).'</small>
                                        </p>
                                        <p>#'.$adv->id.'</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="">
                                        <div class="col-md-12 col-xs-6 pt-2">
                                            <a href="'.url('/add_adv/'.$adv->id.'/edit').'" class="btn btn-green btn-block border-r-10">
                                                <span class="hidden-xs hidden-sm font-large-bold">تعديل الإعلان&nbsp;&nbsp;</span><i class="fa fa-edit fa-lg"></i>
                                            </a>
                                        </div>

                                        <div class="col-md-12 col-xs-6 pt-2">
                                            <form action="'.url('/add_adv/'.$adv->id).'" method="post">
                                                '.method_field("DELETE").csrf_field().'
                                                <button type="button" class="del_ btn btn-orange btn-block border-r-10">
                                                    <span class="hidden-xs hidden-sm font-large-bold">حذف الإعلان&nbsp;&nbsp;</span><i class="fa fa-trash fa-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2">
                            <img alt="image" class="adv_height img-responsive img-rounded" src="'.$img.'">
                        </div>
                    </div>
                </a>';
            }
        } else {
            $data .= '
            <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                <h2>لا توجد إعلانات متاحة حتى الأن ...</h2>
            </div>';
        }

        return response()->json([$data]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main_sections = MainSection::all();
        $cities = City::all();
        $advs = Advs::where('advertiser_id', auth()->user()->id)
            ->where('agree', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('add_adv.my_advs')
                ->with(array(
                    'advs' => $advs,
                    'main_sections' => $main_sections,
                    'cities' => $cities,
                ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area = Area::all();
//        $cities = City::all();
        $main_sections = MainSection::all();
        return view('add_adv.add_adv')
                ->with(array(
                    'area' => $area,
//                    'cities' => $cities,
                    'main_sections' => $main_sections,
                ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'images.*.image' => 'يجب ان يكون الملف المرفوع من نوع الصور',
            'title.required' => 'اسم الاعلان مطلوب',
            'title.max' => 'اكثر عدد لحروف اسم الاعلان 255 حرف',
        ];

        $this->validate($request, [
            'title' => 'required|max:255',
            'area' => 'required',
            'city' => 'required',
            'main_section' => 'required',
            'sub_section' => 'required',
            'mobile' => 'required|max:255|ksa_phone',
            'details' => 'required',
            'images.*' => 'required|image',
            'rules1' => 'required',
            'rules2' => 'required',
//            'location' => 'required',
//            'lat' => 'required',
//            'lon' => 'required',
        ], $messages);


        try {
            DB::transaction(function () use ($request) {
                $advs = new Advs();
                $advs->title = $request->title;
                $advs->area = $request->area;
                $advs->city = $request->city;
                $advs->advertiser_id = $request->advertiser_id;
                $advs->main_section = $request->main_section;
                $advs->sub_section = $request->sub_section;
                $advs->internal_section = $request->internal_section;
                if($request->has('car_year')){
                    $advs->year = $request->car_year;
                }else{
                    $advs->year = 0;
                }
                $advs->mobile = $request->mobile;
                $advs->details = $request->details;
                $advs->allow_comment = $request->allow_comment;
                
                $advs->agree = 1;

                if($request->filled('link')){
                    $this->validate($request, ['link' => 'url']);
                    $advs->link = $request->link;
                }else{
                    $advs->link = null;
                }

                if($request->filled('location')){
                    $advs->location = $request->location ?? '';
                    $advs->lat = $request->lat ?? null;
                    $advs->lon = $request->lon ?? null;
                }else{
                    $advs->location = '';
                    $advs->lat = null;
                    $advs->lon = null;
                }


                $advs->save();

                if($request->all_images != null){
                    $all_images = explode(',', $request->all_images);
                    foreach($all_images as $img){
                        // image operations
                        $img_ = Image::make($img);
                        $watermark = Image::make(public_path().'/img/logo1.png');

                        // image rotation
                        $img_->orientate();

                        //make watermark quarter of image
                        $width_of_watermark = 0.20 * $img_->width();
                        $height_of_watermark = 0.20 * $img_->height();
                        $watermark = $watermark->resize($width_of_watermark, $height_of_watermark);

                        // insert watermark at bottom-right corner with 10px offset
                        $img_big = $img_->insert($watermark, 'bottom-right', 10, 10);
                        $img_big->save($img);

                        $img_small = $img_->resize(150, 150);
                        $small_img = str_replace("public/img/", "public/img/small/", $img);
                        $img_small->save($small_img);

                        $charges[] = [
                            'adv_id' => $advs->id,
                            'img' => $img,
                        ];
                    }
                    AdvImgs::insert($charges);
                }

//                if ($request->hasFile('images')) {
//                    $images = $request->file('images');
//                    foreach($images as $img){
//                        $fileName = date('Ymdhis').'_'.rand(0, 999).'.'.$img->getClientOriginalExtension();
////                        $img->move(public_path().'/img' , $fileName);
//
//                        // image operations
//                        $img_ = Image::make($img);
//                        $watermark = Image::make(public_path().'/img/logo1.png')->opacity(50);
//
//                        // image rotation
//                        $img_->orientate();
//
//                        // insert watermark at bottom-right corner with 10px offset
//                        $img_big = $img_->insert($watermark, 'bottom-right', 20, 20);
//                        $img_big->save(public_path().'/img/'.$fileName);
//
//                        $img_small = $img_->resize(150, 150);
//                        $img_small->save(public_path().'/img/small/'.$fileName);
//
//
//                        $charges[] = [
//                            'adv_id' => $advs->id,
//                            'img' => 'public/img/'.$fileName,
//                        ];
//                    }
//                    AdvImgs::insert($charges);
//                }
            });

            // return redirect(url('/add_adv'))->with('success','تمت إضافة الإعلان بنجاح ... سيتم مراجعته أولا من قبل الإدارة وسيتم ظهوره قريبا');
            return redirect(url('/add_adv'))->with('success','تمت إضافة الإعلان بنجاح');

        }
        catch (\Exception $e) {
            return back()->with('error','حدث خطأ ما برجاء المحاولة مرة اخرى');
        }
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
        $adv = Advs::findOrFail($id);

        if($adv->advertiser_id == auth()->id()){

        $area = Area::all();
        $cities = City::where('area_id', $adv->area)->get();
        $main_sections = MainSection::all();
        $adv_imgs = AdvImgs::where('adv_id', $id)->get();

        $sub_sections = SubSection::where('main_id', $adv->main_section)->get();
        $internal_sections = InternalSection::where('main_id', $adv->main_section)
                                        ->where('sub_id', $adv->sub_section)
                                        ->get();
        return view('add_adv.update_adv')
            ->with(array(
                'area' => $area,
                'cities' => $cities,
                'main_sections' => $main_sections,
                'adv' => $adv,
                'adv_imgs' => $adv_imgs,
                'sub_sections' => $sub_sections,
                'internal_sections' => $internal_sections,
            ));

        }else{
            abort(404);
        }

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
        $messages = [
            'images.*.image' => 'يجب ان يكون الملف المرفوع من نوع الصور',
            'title.required' => 'اسم الاعلان مطلوب',
            'title.max' => 'اكثر عدد لحروف اسم الاعلان 255 حرف',
        ];

        $this->validate($request, [
            'title' => 'required|max:255',
            'area' => 'required',
            'city' => 'required',
            'main_section' => 'required',
            'sub_section' => 'required',
            'mobile' => 'required|max:255|ksa_phone',
            'details' => 'required',
            'images.*' => 'image',
//            'location' => 'required',
//            'lat' => 'required',
//            'lon' => 'required',
        ], $messages);

        try {
            DB::transaction(function () use ($request, $id) {
                $adv = Advs::findOrFail($id);
                $adv->title = $request->title;
                $adv->area = $request->area;
                $adv->city = $request->city;
                $adv->advertiser_id = $request->advertiser_id;
                $adv->main_section = $request->main_section;
                $adv->sub_section = $request->sub_section;
                $adv->internal_section = $request->internal_section;
                if($request->has('car_year')){
                    $adv->year = $request->car_year;
                }else{
                    $adv->year = 0;
                }
                $adv->mobile = $request->mobile;
                $adv->details = $request->details;
                $adv->allow_comment = $request->allow_comment;

                if($request->filled('link')){
                    $this->validate($request, ['link' => 'url']);
                    $adv->link = $request->link;
                }else{
                    $adv->link = null;
                }

                if($request->filled('location')){
                    $adv->location = $request->location ?? '';
                    $adv->lat = $request->lat ?? null;
                    $adv->lon = $request->lon ?? null;
                }else{
                    $adv->location = '';
                    $adv->lat = null;
                    $adv->lon = null;
                }

                $adv->save();

                if($request->all_images != null){
                    $all_images = explode(',', $request->all_images);
                    foreach($all_images as $img){
                        // image operations
                        $img_ = Image::make($img);
                        $watermark = Image::make(public_path().'/img/logo1.png');

                        // image rotation
                        $img_->orientate();

                        //make watermark quarter of image
                        $width_of_watermark = 0.20 * $img_->width();
                        $height_of_watermark = 0.20 * $img_->height();
                        $watermark = $watermark->resize($width_of_watermark, $height_of_watermark);

                        // insert watermark at bottom-right corner with 10px offset
                        $img_big = $img_->insert($watermark, 'bottom-right', 10, 10);
                        $img_big->save($img);

                        $img_small = $img_->resize(150, 150);
                        $small_img = str_replace("public/img/", "public/img/small/", $img);
                        $img_small->save($small_img);

                        $charges[] = [
                            'adv_id' => $adv->id,
                            'img' => $img,
                        ];
                    }
                    AdvImgs::insert($charges);
                }

//                if ($request->hasFile('images')) {
//                    $images = $request->file('images');
//                    foreach($images as $img){
//                        $fileName = date('Ymdhis').'_'.rand(0, 999).'.'.$img->getClientOriginalExtension();
////                        $img->move(public_path().'/img' , $fileName);
//
//                        // image operations
//                        $img_ = Image::make($img);
//                        $watermark = Image::make(public_path().'/img/logo1.png')->opacity(50);
//
//                        // image rotation
//                        $img_->orientate();
//
//                        // insert watermark at bottom-right corner with 10px offset
//                        $img_big = $img_->insert($watermark, 'bottom-right', 20, 20);
//                        $img_big->save(public_path().'/img/'.$fileName);
//
//                        $img_small = $img_->resize(150, 150);
//                        $img_small->save(public_path().'/img/small/'.$fileName);
//
//                        $charges[] = [
//                            'adv_id' => $adv->id,
//                            'img' => 'public/img/'.$fileName,
//                        ];
//                    }
//                    AdvImgs::insert($charges);
//                }
            });

            return redirect(url('/add_adv'))->with('success','تم تعديل الإعلان بنجاح');
        }
        catch (\Exception $e) {
            return back()->with('error','حدث خطأ ما برجاء المحاولة مرة اخرى');
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
        $adv = Advs::findOrFail($id)->delete();

        $adv_imgs = AdvImgs::where('adv_id', $id)->get();
        foreach($adv_imgs as $img){
            if (file_exists($img->img)) {
                unlink($img->img);
            }
            $split = explode('/', $img->img);
            if (file_exists('public/img/small/'.$split[2])) {
                unlink('public/img/small/'.$split[2]);
            }
        }
        $adv_imgs_ = AdvImgs::where('adv_id', $id)->get()->each->delete();

        $adv_ratings = AdvRatings::where('adv_id', $id)->get();
        if(count($adv_ratings) > 0){$adv_ratings->each->delete();}

        $favorite_advs = Favourite::where('adv_id', $id)->get();
        if(count($favorite_advs) > 0){$favorite_advs->each->delete();}

        $reports = Reports::where('adv_id', $id)->get();
        if(count($reports) > 0){$reports->each->delete();}

        $notify = Notification_::where('adv_id', $id)->get();
        if(count($notify) > 0){$notify->each->delete();}
//
//        $advertiser_messages = AdvertiserContacts::where('adv_id', $id)->get();
//        if(count($advertiser_messages) > 0){$advertiser_messages->each->delete();}

        if(!$adv or !$adv_imgs_){return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');}
        else{return back()->with('success','تم الحذف بنجاح');}
    }
}
