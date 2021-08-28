<?php

namespace App\Http\Controllers;

use App\Haraj_One_Info;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public static function get_info(){
        return Haraj_One_Info::findOrFail(1);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Haraj_One_Info::findOrFail(1);
        return view('dashboard.site_settings')
            ->with(array(
                'settings' => $settings,
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
        $updated_ = Haraj_One_Info::findOrFail($id);

        $messages = [
            'whatsapp.ksa_phone' => 'صيغة الواتساب المطلوبة 05xxxxxxxx ... ويجب أن لا يتعدى 10 أرقام'
        ];

        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'required|max:255|ksa_phone',
            'address' => 'required',
            'fax' => 'required|max:255',
            'e_mail' => 'required|email',
            'facebook' => 'required|url',
            'twitter' => 'required|url',
            'instagram' => 'required|url',
            'whatsapp' => 'required|ksa_phone',
            'youtube' => 'required|url',
            'google_play' => 'required|url',
            'app_store' => 'required|url',
            'image.*' => 'image|max:2048',
            'description' => 'required|max:1000',
//            'agree1' => 'required',
//            'agree2' => 'required',
//            'agree3' => 'required',
            'key_words' => 'required',
            'hour_update' => 'required|min:1',
        ], $messages);


        $updated_->name = $request->name;
        $updated_->mobile = $request->mobile;
        $updated_->fax = $request->fax;
        $updated_->address = $request->address;
        $updated_->e_mail = $request->e_mail;
        $updated_->facebook = $request->facebook;
        $updated_->twitter = $request->twitter;
        $updated_->instagram = $request->instagram;
        $updated_->whatsapp = $request->whatsapp;
        $updated_->youtube = $request->youtube;
        $updated_->google_play = $request->google_play;
        $updated_->app_store = $request->app_store;
        $updated_->description = $request->description;
        $updated_->agree1 = 1;
        $updated_->agree2 = 1;
        $updated_->agree3 = 1;
        $updated_->key_words = $request->key_words;
        $updated_->hour_update = $request->hour_update;

        if ($request->hasFile('image')) {
            if($updated_->logo != null){
                if (file_exists(public_path().'/img/'.$updated_->logo)) {
                    unlink(public_path().'/img/'.$updated_->logo);
                }
            }

            $image = $request->file('image');
            $fileName = date('Ymdhis').'_'.rand(0, 999).'.'.$image->getClientOriginalExtension();
            $image->move(public_path().'/img' , $fileName);
            $updated_->logo = $fileName;
        }

        $action = $updated_->save();

        if(!$action){return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');}
        else{return back()->with('success','تم تعديل البيانات بنجاح');}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
