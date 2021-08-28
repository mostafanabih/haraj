<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\BlackList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BlackListController extends Controller
{
    public function find_black_list(Request $request)
    {
        if ($request->filled('search')) {
            $advertiser = Advertiser::where('mobile', $request->search)
                ->orWhere('e_mail', $request->search)
                ->first();

            if($advertiser){
                if($advertiser->black_list == 0){
                    return view('black_list.find_black_list')->with('advertiser', 'error2');
                }else{
                    return view('black_list.find_black_list')->with('advertiser', $advertiser);
                }
            }else{
                return view('black_list.find_black_list')->with('advertiser', 'error');
            }

        } else {
            return view('black_list.find_black_list')->with('advertiser');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $black_list = BlackList::paginate(10);
        return view('black_list.black_list')
            ->with(array(
                'black_list' => $black_list,
            ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $advertisers = Advertiser::where('black_list', 0)
                                ->where('roles', '!=', 1)
                                ->get();
        return view('black_list.create')
            ->with(array(
                'advertisers' => $advertisers,
            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'reason' => 'required|max:255',
        ]);

        $black_list = new BlackList();
        $black_list->advertiser_id = $request->advertiser_id;
        $black_list->reason = $request->reason;

        $black_list_update = Advertiser::findOrFail($request->advertiser_id)
            ->update(['black_list' => 1]);

        $black_list_insert = $black_list->save();

        if (!$black_list_update or !$black_list_insert) {
            return redirect('/black_list')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/black_list')->with('success', 'تمت الإضافة بنجاح');
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $black_list = BlackList::find($id)->delete();
        $black_list_update_ = Advertiser::where('id', $request->advertiser_id)
            ->update(['black_list' => 0]);

        if (!$black_list or !$black_list_update_) {
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم الحذف بنجاح');
        }

    }
}
