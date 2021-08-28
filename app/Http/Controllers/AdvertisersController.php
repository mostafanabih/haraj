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
use App\Permission_role;
use App\Reports;
use App\Subscriptions;
use Illuminate\Http\Request;

class AdvertisersController extends Controller
{
    public function normal_user_convert($id){
        $advertiser = Advertiser::findOrFail($id);
        $advertiser->roles = 0;
        $advertiser->type_of_roles = null;
        $action = $advertiser->save();

        if (!$action) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم تحويل المشرف لعضو بنجاح');
        }
    }

    public function super_user_convert($id){
        $advertiser = Advertiser::findOrFail($id);
        $advertiser->roles = 1;
        $advertiser->type_of_roles = 0;
        $action = $advertiser->save();

        if (!$action) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم تحويل العضو لمشرف بنجاح');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $advertisers = Advertiser::query();

        if($request->has('name') or $request->has('city') or $request->has('marked')){
            if($request->name == ''){$asd = '!='; $sign = '';}else{$asd = 'LIKE'; $sign = '%';}
            if($request->city == 0){$asd2 = '!=';$asd2_ = '=';$asd2_2 = '0';$asd2_2_ = null;}else{$asd2 = '=';$asd2_ = '=';$asd2_2 = $request->city;$asd2_2_ = $request->city;}
            if($request->marked == 0){$asd3 = '!=';}else{$asd3 = '=';}
            $advertisers = Advertiser::where(function ($q){
                $q->where('roles', '!=', 1);
                $q->orWhere('type_of_roles', 0);
            })
                ->where('black_list', 0)
                ->where('name', $asd, $sign.$request->name.$sign)
                ->where(function($q_) use($request, $asd2, $asd2_, $asd2_2, $asd2_2_){
                    $q_->where('city', $asd2, $asd2_2);
                    $q_->orWhere('city', $asd2_, $asd2_2_);
                })
                ->where('marked', $asd3, $request->marked-1)
                ->paginate(10);
        }
        else{
            $advertisers = $advertisers->where(function ($q){
                $q->where('roles', '!=', 1);
                $q->orWhere('type_of_roles', 0);
            })
                ->where('black_list', 0)
                ->paginate(10);
        }


        $citits = City::all();
        return view('dashboard.advertisers.advertisers')->with(array(
            'citits' => $citits,
            'advertisers' => $advertisers,
        ));
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
        $this->validate($request, [
            'from' => 'required|date_format:"Y-m-d"',
            'to' => 'required|date_format:"Y-m-d"|after:from',
        ]);

        $subscription = new Subscriptions();
        $subscription->advertiser_id = $request->advertiser_id;
        $subscription->package_id = 0;
        $subscription->start_date = $request->from;
        $subscription->end_date = $request->to;
        $action = $subscription->save();

        $advertiser_update = Advertiser::findOrFail($request->advertiser_id)
            ->update(['marked' => 1]);

        if (!$action or !$advertiser_update) {
            return redirect('/advertisers')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/advertisers')->with('success', 'تم تحويل العضو لمشترك بنجاح');
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
        $advertiser = Advertiser::findOrFail($id);
        return view('dashboard.advertisers.convert')->with('advertiser', $advertiser);
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
        if($request->has('status')){
            if($request->status == 0){
                $rand = rand(0, 99999);
                $action = Advertiser::findOrFail($id)
                    ->update(['active_code' => $rand, 'agree' => 0]);
                $msg = 'تم الإيقاف بنجاح';
            }else{
                $action = Advertiser::findOrFail($id)
                    ->update(['active_code' => null, 'agree' => 1]);
                $msg = 'تم رفع الإيقاف بنجاح';
            }
        }

        elseif($request->has('is_active')){
            $action = Advertiser::findOrFail($id)
                ->update(['active_code' => null]);
            $msg = 'تم تفعيل الحساب بنجاح';
        }

        elseif($request->has('is_special')){
            if($request->is_special == 0){
                $action = Advertiser::findOrFail($id)
                    ->update(['special' => 0]);
                $msg = 'تم ازالة علامة التمييز للمعلن';
            }else{
                $action = Advertiser::findOrFail($id)
                    ->update(['special' => 1]);
                $msg = 'تم تمميز المعلن بنجاح';
            }
        }

        else{
            return redirect()->back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        }

        if (!$action) {
            return redirect()->back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect()->back()->with('success', $msg);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //1
        $advertiser = Advertiser::findOrFail($id)->delete();

        //2
        $advertiser_contacts = AdvertiserContacts::where('to_id', $request->advertiser_id)
            ->orWhere('from_id', $request->advertiser_id)->get();
        if(count($advertiser_contacts) > 0){$advertiser_contacts->each->delete();}

        //3
        $advertiser_favourite = AdvertiserFavourite::where('advertiser_id', $request->advertiser_id)->orWhere('favourite_advertiser', $request->advertiser_id)->get();
        if(count($advertiser_favourite) > 0){$advertiser_favourite->each->delete();}

        //4
        $advertiser_ratings = AdvertiserRatings::where('advertiser_id', $request->advertiser_id)->orWhere('voter_id', $request->advertiser_id)->get();
        if(count($advertiser_ratings) > 0){$advertiser_ratings->each->delete();}

        //5
        $advs = Advs::where('advertiser_id', $request->advertiser_id)->get();
        foreach($advs as $adv){
            $adv_imgs = AdvImgs::where('adv_id', $adv->id)->get();
            foreach($adv_imgs as $img){
                if(file_exists($img->img)) {
                    unlink($img->img);
                }
            }
            AdvImgs::where('adv_id', $adv->id)->get()->each->delete();

            $adv_ratings = AdvRatings::where('adv_id', $adv->id)->orWhere('voter_id', $request->advertiser_id)->get();
            if(count($adv_ratings) > 0){$adv_ratings->each->delete();}

            $favorite_advs = Favourite::where('adv_id', $adv->id)->orWhere('advertiser_id', $request->advertiser_id)->get();
            if(count($favorite_advs) > 0){$favorite_advs->each->delete();}

            $reports = Reports::where('adv_id', $adv->id)->get();
            if(count($reports) > 0){$reports->each->delete();}

            $notify = Notification_::where('adv_id', $adv->id)->get();
            if(count($notify) > 0){$notify->each->delete();}
        }
        if(count($advs) > 0){$advs->each->delete();}

        //6
        $black_list = BlackList::where('advertiser_id', $request->advertiser_id)->get();
        if(count($black_list) > 0){$black_list->each->delete();}

        //7
        $followers = Followers::where('advertiser_id', $request->advertiser_id)->orWhere('follower_id', $request->advertiser_id)->get();
        if(count($followers) > 0){$followers->each->delete();}

        //8
        $subscriptions = Subscriptions::where('advertiser_id', $request->advertiser_id)->get();
        if(count($subscriptions) > 0){$subscriptions->each->delete();}

        //9
        $notify = Notification_::where('advertiser_id', $request->advertiser_id)->get();
        if(count($notify) > 0){$notify->each->delete();}

        //10
        $permission = Permission_role::where('admin_id', $request->advertiser_id)->get();
        if(count($permission) > 0){$permission->each->delete();}

        //11
        $reports = Reports::where('advertiser_id', $request->advertiser_id)->get();
        if(count($reports) > 0){$reports->each->delete();}

        if (!$advertiser) {
            return redirect('/advertisers')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/advertisers')->with('success', 'تم الحذف بنجاح');
        }
    }
}
