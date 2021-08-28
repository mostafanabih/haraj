<?php

namespace App\Http\Controllers;

use App\AdvertiserContacts;
use App\AdvImgs;
use App\AdvRatings;
use App\Advertiser;
use App\Advs;
use App\Area;
use App\City;
use App\Favourite;
use App\InternalSection;
use App\MainSection;
use App\Notification_;
use App\Reports;
use App\SubSection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class AdminAdvController extends Controller
{
    public function adv_confirm($adv_id){
        $adv = Advs::findOrFail($adv_id);
        $adv->agree = 1;
        $action = $adv->save();

        $notify = new Notification_();
        $notify->content = 'تم الموافقة على نشر اعلانك '.$adv->title;
        $notify->adv_id = $adv->id;
        $notify->advertiser_id = $adv->advertiser_id;
        $notify->type = 2;
        $action2 = $notify->save();

        $user_notify = Advertiser::findOrFail($adv->advertiser_id);
        if ($user_notify->player_id != null or $user_notify->player_id != '') {
            $tokens = [$user_notify->player_id];
            $content = $notify->content;
            $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
            sendNote($tokens, $content, $data);
        }


        if(!$action or !$action2){
            return back()->with('error', 'حدث خطأ ما ... برجاء المحاولة مرة أخرى');
        }
        else{
            return redirect()->back()->with('success', 'تم نشر الإعلان بنجاح');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advs = Advs::orderBy('updated_at', 'desc')->paginate(10);
        $advs->each(function ($adv) {
            $today = Carbon::now();

            $i = AdvImgs::where('adv_id', $adv->id)->first();
            if($i){
                $split = explode('/',$i->img);
                if (file_exists('public/img/small/'.$split[2])) {
                    $adv->image = 'public/img/small/'.$split[2];
                }else{
                    if (file_exists($i->img)) {
                        $adv->image = $i->img;
                    } else {
                        $adv->image = 'public/img/no_img.png';
                    }
                }
            }
            else{$adv->image = 'public/img/no_img.png';}

            $ra = AdvRatings::where('adv_id', $adv->id)
                            ->where('type', 0)->get();
            $ra = count($ra);
            $adv->rating_count = $ra;
            $t = Carbon::parse($adv->updated_at);
            $tt = $today->diffInDays($t);
            $adv->time = $tt;
        });
        return view('dashboard.advs.advertisement', compact('advs'));
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
        $adv = Advs::findOrFail($id);

        $area = Area::all();
        $cities = City::where('area_id', $adv->area)->get();
        $main_sections = MainSection::all();
        $adv_imgs = AdvImgs::where('adv_id', $id)->get();

        $sub_sections = SubSection::where('main_id', $adv->main_section)->get();
        $internal_sections = InternalSection::where('main_id', $adv->main_section)
            ->where('sub_id', $adv->sub_section)
            ->get();

        return view('dashboard.advs.update_adv')
            ->with(array(
                'area' => $area,
                'cities' => $cities,
                'main_sections' => $main_sections,
                'adv' => $adv,
                'adv_imgs' => $adv_imgs,
                'sub_sections' => $sub_sections,
                'internal_sections' => $internal_sections,
            ));
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

        $adv = Advs::findOrFail($id);
        $adv->title = $request->title;
        $adv->area = $request->area;
        $adv->city = $request->city;
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

        $action = $adv->save();

        if($action){
//            if ($request->hasFile('images')) {
//                $images = $request->file('images');
//                foreach($images as $img){
//                    $fileName = date('Ymdhis').'_'.rand(0, 999).'.'.$img->getClientOriginalExtension();
////                    $img->move(public_path().'/img' , $fileName);
//
//                    // image operations
//                    $img_ = Image::make($img);
//                    $watermark = Image::make(public_path().'/img/logo1.png')->opacity(50);
//
//                    // image rotation
//                    $img_->orientate();
//
//                    // insert watermark at bottom-right corner with 10px offset
//                    $img_big = $img_->insert($watermark, 'bottom-right', 20, 20);
//                    $img_big->save(public_path().'/img/'.$fileName);
//
//                    $img_small = $img_->resize(150, 150);
//                    $img_small->save(public_path().'/img/small/'.$fileName);
//
//                    $charges[] = [
//                        'adv_id' => $adv->id,
//                        'img' => 'public/img/'.$fileName,
//                    ];
//                }
//                $upload = AdvImgs::insert($charges);
//                if(!$upload){return back()->with('error','حدث خطأ فى إضافة الصور');}
//                else{return redirect(url('/adv_action'))->with('success','تم تعديل الإعلان بنجاح');}
//            }
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
                $upload = AdvImgs::insert($charges);
                if(!$upload){return back()->with('error','حدث خطأ فى إضافة الصور');}
                else{return redirect(url('/adv_action'))->with('success','تم تعديل الإعلان بنجاح');}
            }
            else{
                return redirect(url('/adv_action'))->with('success','تم تعديل الإعلان بنجاح');
            }
        }
        else{
            return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');
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
