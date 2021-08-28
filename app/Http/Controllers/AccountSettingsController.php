<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $settings = Advertiser::findOrFail(auth()->user()->id);
//        $citits = City::all();
//        return view('account_settings.account_settings')
//            ->with(array(
//                'settings' => $settings,
//                'citits' => $citits,
//            ));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updated_ = Advertiser::findOrFail($id);

        $rules = [
            'name' => 'required|max:255|unique:advertisers,name,'. $updated_->id,
            'e_mail' => 'required|email|unique:advertisers,e_mail,'. $updated_->id,
            'mobile' => 'required|ksa_phone|max:255|unique:advertisers,mobile,'. $updated_->id,
            'area' => 'required',
            'city' => 'required',
            'street' => 'required|max:255',
//            'address' => 'required',
//            'lat' => 'required',
//            'lon' => 'required',
        ];

    /*    if ($updated_->mobile and $updated_->mobile == $request->mobile) {
        } else {
            $rules['mobile'] = 'unique:advertisers';
        }
        if ($updated_->name and $updated_->name == $request->name) {
        } else {
            $rules['name'] = 'unique:advertisers';
        }*/

        $this->validate($request, $rules);

        $updated_->name = $request->name;
        $updated_->mobile = $request->mobile;
        $updated_->e_mail = $request->e_mail;
        $updated_->area = $request->area;
        $updated_->city = $request->city;
        $updated_->street = $request->street;

        if($request->filled('address')){
            $updated_->address = $request->address ?? '';
            $updated_->lat = $request->lat ?? null;
            $updated_->lon = $request->lon ?? null;
        }else{
            $updated_->address = '';
            $updated_->lat = null;
            $updated_->lon = null;
        }

        $updated_->facebook = $request->facebook;
        $updated_->twitter = $request->twitter;
        $updated_->instagram = $request->instagram;


        if($request->filled('pass')){
            $this->validate($request, [
                'pass' => 'required|min:6|confirmed',
            ]);
            $updated_->password = Hash::make($request->pass);
        }

        $action = $updated_->save();

        $check = preg_match('/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', $request->mobile);
        if ($check) {
            session()->forget('update_phone');
        }

        if (!$action) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم تعديل بياناتك بنجاح');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
