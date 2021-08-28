<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\Packages;
use App\Subscriptions;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Packages::orderBy('duration', 'asc')->orderBy('price', 'asc')->paginate(10);
        return view('dashboard.packages.packages')->with('packages', $packages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.packages.add_package');
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
            'name' => 'required|max:255',
            'details' => 'required',
            'duration' => 'required',
            'price' => 'required|min:0',
        ]);

        $packages = new Packages();
        $packages->name = $request->name;
        $packages->details = $request->details;
        $packages->duration = $request->duration;
        $packages->price = $request->price;
        $action = $packages->save();

        if (!$action) {
            return redirect('/packages')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/packages')->with('success', 'تمت الإضافة بنجاح');
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
        $package = Packages::findOrFail($id);
        return view('dashboard.packages.update_package')->with('package', $package);
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
        $package = Packages::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:255|unique:packages,name,'.$package->id,
            'details' => 'required',
            'duration' => 'required',
            'price' => 'required|min:0',
        ]);

        $package->name = $request->name;
        $package->details = $request->details;
        $package->duration = $request->duration;
        $package->price = $request->price;
        $action = $package->save();

        if (!$action) {
            return redirect('/packages')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/packages')->with('success', 'تم التعديل بنجاح');
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
        $package = Packages::findOrFail($id);

        $subs = Subscriptions::where('package_id', $package->id)->get();
        foreach($subs as $sub){
            Advertiser::findOrFail($sub->advertiser_id)->update(['marked' => 0]);
            $sub->delete();
        }


        $package_ = $package->delete();

        if (!$package_) {
            return redirect('/packages')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/packages')->with('success', 'تم الحذف بنجاح');
        }
    }
}
