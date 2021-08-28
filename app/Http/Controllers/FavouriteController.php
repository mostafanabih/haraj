<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\AdvertiserFavourite;
use App\Advs;
use App\Favourite;
use App\Notification_;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{

    public function add_favourite_advertiser(Request $request)
    {
        $check = AdvertiserFavourite::where('favourite_advertiser', $request->favourite_advertiser)
            ->where('advertiser_id', $request->advertiser_id)->first();
        if($check){
            $check->delete();
            return back()->with('success','تم إزالة المعلن من المفضلة بنجاح');
        }

        $favourite = new AdvertiserFavourite();
        $favourite->favourite_advertiser = $request->favourite_advertiser;
        $favourite->advertiser_id = $request->advertiser_id;
        $action = $favourite->save();

        if(!$action){return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');}
        else{return back()->with('success','تم إضافة المعلن بنجاح للمفضلة');}
    }
    public function show_favourite_advertiser()
    {
        $favourite = AdvertiserFavourite::where('advertiser_id', auth()->user()->id)
            ->paginate(10);

        return view('my_favourite.my_favourite_advertisers')
            ->with(array(
                'favourite' => $favourite,
            ));
    }
    public function delete_favourite_advertiser(Request $request)
    {
        $favourite = AdvertiserFavourite::findOrFail($request->fav_id)->delete();

        if(!$favourite){return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');}
        else{return back()->with('success','تم الحذف بنجاح');}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favourite = Favourite::where('advertiser_id', auth()->user()->id)
                                ->paginate(10);

        return view('my_favourite.my_favourite')
            ->with(array(
                'favourite' => $favourite,
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
        $check = Favourite::where('adv_id', $request->adv_id)
            ->where('advertiser_id', $request->advertiser_id)->first();
        if($check){
            $check->delete();
            return back()->with('success','تم إزالة الاعلان من المفضلة بنجاح');
        }

        $favourite = new Favourite();
        $favourite->adv_id = $request->adv_id;
        $favourite->advertiser_id = $request->advertiser_id;
        $action = $favourite->save();
        
//        $adv_ = Advs::selectRaw('advertiser_id')->where('id', $request->adv_id)->first();
//        if($adv_ and $adv_ != null){
//            $advertiser = Advertiser::selectRaw('player_id, id')
//                ->where('id', $adv_->advertiser_id)->first();
//            $notify = new Notification_();
//            $notify->content = 'قام '.$advertiser->name.' باضافة اعلانك '.$adv_->title.' الى مفضلته';
//            $notify->adv_id = $adv_->id;
//            $notify->advertiser_id = $advertiser->id;
//            $notify->type = 11;
//            $notify->save();
//
//            if ($advertiser->player_id != null or $advertiser->player_id != '') {
//                $tokens = [$advertiser->player_id];
//                $content = $notify->content;
//                $data = ['adv_id' => $notify->adv_id, 'type' => $notify->type];
//                sendNote($tokens, $content, $data);
//            }
//        }

        if(!$action){return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');}
        else{return back()->with('success','تم إضافة الإعلان للمفضلة بنجاح');}
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favourite = Favourite::findOrFail($id)->delete();

        if(!$favourite){return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');}
        else{return back()->with('success','تم حذف الإعلان من المفضلة بنجاح');}
    }
}
