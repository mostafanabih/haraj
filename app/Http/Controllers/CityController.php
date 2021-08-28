<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\AdvertiserContacts;
use App\AdvertiserFavourite;
use App\AdvertiserRatings;
use App\AdvImgs;
use App\AdvRatings;
use App\Advs;
use App\Area;
use App\BlackList;
use App\City;
use App\Favourite;
use App\Followers;
use App\Notification_;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::paginate(10);
        return view('dashboard.cities.city')->with('cities', $cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area = Area::all();
        return view('dashboard.cities.add_city')->with('area', $area);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:cities',
            'area' => 'required',
            'location' => 'required',
            'lat' => 'required',
            'lon' => 'required',

        ]);

        $city = new City();
        $city->name = $request->name;
        $city->area_id = $request->area;

        $city->location = $request->location;
        $city->lat = $request->lat;
        $city->lon = $request->lon;

        $action = $city->save();

        if (!$action) {
            return redirect('/cities')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/cities')->with('success', 'تمت الإضافة بنجاح');
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
        $area = Area::all();
        $city = City::findOrFail($id);
        return view('dashboard.cities.update_city')
            ->with(array(
            'city' => $city,
            'area' => $area
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
        $city = City::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:255',
            'area' => 'required',
            'location' => 'required',
            'lat' => 'required',
            'lon' => 'required',
        ]);

        if($city->area_id != $request->area){
            $cities = City::where('area_id', $request->area)->get();
            foreach($cities as $city_){
                if($city_->name != $request->name){}
                else{$this->validate($request, ['name' => 'unique:cities']);}
            }
        }else{
            $this->validate($request, ['name' => 'unique:cities']);
        }


        $city->name = $request->name;
        $city->area_id = $request->area;

        $city->location = $request->location;
        $city->lat = $request->lat;
        $city->lon = $request->lon;

        $action = $city->save();

        if (!$action) {
            return redirect('/cities')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/cities')->with('success', 'تم التعديل بنجاح');
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
        $city = City::findOrFail($id);

        //1
        $advertisers = Advertiser::where('city', $city->id)->get();
        foreach($advertisers as $advertiser){
//            if($advertiser->img != null){
//                if(file_exists('public/img/advertiser_imgs/'.$advertiser->img)) {
//                    unlink('public/img/advertiser_imgs/'.$advertiser->img);
//                }
//            }

            //2
            $advertiser_contacts = AdvertiserContacts::where('to_id', $advertiser->id)->get();
            if(count($advertiser_contacts) > 0){$advertiser_contacts->each->delete();}

            //3
            $advertiser_favourite = AdvertiserFavourite::where('advertiser_id', $advertiser->id)->orWhere('favourite_advertiser', $advertiser->id)->get();
            if(count($advertiser_favourite) > 0){$advertiser_favourite->each->delete();}

            //4
            $advertiser_ratings = AdvertiserRatings::where('advertiser_id', $advertiser->id)->orWhere('voter_id', $advertiser->id)->get();
            if(count($advertiser_ratings) > 0){$advertiser_ratings->each->delete();}

            //5
            $advs = Advs::where('advertiser_id', $advertiser->id)->orWhere('city', $advertiser->city)->get();
            foreach($advs as $adv){
                $adv_imgs = AdvImgs::where('adv_id', $adv->id)->get();
                foreach($adv_imgs as $img){
                    if(file_exists($img->img)) {
                        unlink($img->img);
                    }
                }
                $adv_imgs->each->delete();

                $adv_ratings = AdvRatings::where('adv_id', $adv->id)->orWhere('voter_id', $advertiser->id)->get();
                if(count($adv_ratings) > 0){$adv_ratings->each->delete();}

                $favorite_advs = Favourite::where('adv_id', $adv->id)->orWhere('advertiser_id', $advertiser->id)->get();
                if(count($favorite_advs) > 0){$favorite_advs->each->delete();}

                $notify = Notification_::where('adv_id', $adv->id)->get();
                if(count($notify) > 0){$notify->each->delete();}
            }
            if(count($advs) > 0){$advs->each->delete();}

            //6
            $black_list = BlackList::where('advertiser_id', $advertiser->id)->get();
            if(count($black_list) > 0){$black_list->each->delete();}

            //7
            $followers = Followers::where('advertiser_id', $advertiser->id)->orWhere('follower_id', $advertiser->id)->get();
            if(count($followers) > 0){$followers->each->delete();}

            //8
            $notify = Notification_::where('advertiser_id', $advertiser->id)->get();
            if(count($notify) > 0){$notify->each->delete();}

            $advertiser->delete();
        }


        $city = $city->delete();

        if (!$city) {
            return redirect('/cities')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/cities')->with('success', 'تم الحذف بنجاح');
        }
    }
}
