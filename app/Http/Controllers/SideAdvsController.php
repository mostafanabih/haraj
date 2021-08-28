<?php

namespace App\Http\Controllers;

use App\SideAdvs;
use Illuminate\Http\Request;

class SideAdvsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side_advs = SideAdvs::paginate(10);
        return view('dashboard.side_advs.my_side_advs')->with('side_advs', $side_advs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.side_advs.add_side_adv');
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
            'image.*' => 'required|image|max:2048',
            'link' => 'required|url',
        ]);

        $side_adv = new SideAdvs();

        $image = $request->file('image');
        $fileName = date('Ymdhis').'_'.rand(0, 999).'.'.$image->getClientOriginalExtension();
        $upload = $image->move(public_path().'/img/side_advs' , $fileName);

        $side_adv->img = $fileName;
        $side_adv->link = $request->link;
        $action = $side_adv->save();

        if(!$upload or !$action){return back()->with('error','حدث خطأ فى إضافة الصور');}
        else{return redirect(url('/side_advs'))->with('success','تمت إضافة الاعلان بنجاح');}
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
        $side_adv = SideAdvs::findOrFail($id);
        return view('dashboard.side_advs.update_side_adv')->with('side_adv', $side_adv);
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
        $this->validate($request, [
            'image.*' => 'image|max:2048',
            'link' => 'required|url',
        ]);

        $side_adv = SideAdvs::findOrFail($id);

        if ($request->hasFile('image')) {

            if (file_exists(public_path().'/img/side_advs/'.$side_adv->img)) {
                unlink(public_path().'/img/side_advs/'.$side_adv->img);
            }

            $image = $request->file('image');
            $fileName = date('Ymdhis').'_'.rand(0, 999).'.'.$image->getClientOriginalExtension();
            $image->move(public_path().'/img/side_advs' , $fileName);
            $side_adv->img = $fileName;
        }

        $side_adv->link = $request->link;
        $action = $side_adv->save();

        if(!$action){return back()->with('error','حدث خطأ فى التعديل');}
        else{return redirect(url('/side_advs'))->with('success','تم التعديل بنجاح');}

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $side_adv = SideAdvs::findOrFail($id);
        if (file_exists(public_path().'/img/side_advs/'.$side_adv->img)) {
            unlink(public_path().'/img/side_advs/'.$side_adv->img);
        }
        $side_adv_ = $side_adv->delete();

        if(!$side_adv_){return back()->with('error','حدث خطأ .. من فضلك حاول مرة أخرى');}
        else{return back()->with('success','تم الحذف بنجاح');}
    }
}
