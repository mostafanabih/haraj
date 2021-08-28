<?php

namespace App\Http\Controllers;

use App\ReportingReasons;
use App\Reports;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    public function add_reporting(Request $request){

        $report = Reports::updateOrCreate(
            [
                'advertiser_id' => $request->advertiser_id,
                'adv_id' => $request->adv_id,
                'c_r_type' => $request->c_r_type,
                'c_r_id' => $request->c_r_id,
                'c_r_voter_id' => $request->c_r_voter_id,
                'reporter_id' => $request->reporter_id
            ],
            [
                'advertiser_id' => $request->advertiser_id,
                'adv_id' => $request->adv_id,
                'c_r_type' => $request->c_r_type,
                'c_r_id' => $request->c_r_id,
                'c_r_voter_id' => $request->c_r_voter_id,
                'reason_id' => $request->reason_id,
                'reporter_id' => $request->reporter_id
            ]
        );
        $action = $report->save();

        if (!$action) {
            return redirect()->back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect()->back()->with('success', 'تم ارسال بلاغك بنجاح');
        }
    }

    public function get_reports(Request $request){
        $reports = Reports::query();

        if($request->has('report_type')){
            if($request->report_type == 1){
                $reports = Reports::where('advertiser_id', '!=', 0)
                    ->where('adv_id', 0)
                    ->orderBy('created_at', 'desc')->paginate(10);
            }
            elseif($request->report_type == 2){
                $reports = Reports::where('adv_id', '!=', 0)
                    ->where('c_r_type', 0)->orderBy('created_at', 'desc')->paginate(10);
            }
            elseif($request->report_type == 3){
                $reports = Reports::where('c_r_type', 1)->orderBy('created_at', 'desc')->paginate(10);
            }
            elseif($request->report_type == 4){
                $reports = Reports::where('c_r_type', 2)->orderBy('created_at', 'desc')->paginate(10);
            }
            else{
                $reports = Reports::orderBy('created_at', 'desc')->paginate(10);
            }
        }
        else{
            $reports = $reports->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('dashboard.reporting.reports')->with('reports', $reports);
    }

    public function del_report($id){
        $report = Reports::findOrFail($id)->delete();

        if (!$report) {
            return redirect('/reports')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/reports')->with('success', 'تم الحذف بنجاح');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reasons = ReportingReasons::paginate(10);
        return view('dashboard.reporting.reporting_reasons')->with('reasons', $reasons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return view('dashboard.cities.add_city');
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
            'name' => 'required|max:255|unique:reporting_reasons',
        ]);

        $reason = new ReportingReasons();
        $reason->name = $request->name;
        $action = $reason->save();

        if (!$action) {
            return redirect('/reporting_reasons')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/reporting_reasons')->with('success', 'تمت الإضافة بنجاح');
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
//        $city = City::findOrFail($id);
//        return view('dashboard.cities.update_city')->with('city', $city);
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
//        $this->validate($request, [
//            'name' => 'required|max:255|unique:cities',
//        ]);
//
//        $city = City::findOrFail($id);
//        $city->name = $request->name;
//        $action = $city->save();
//
//        if (!$action) {
//            return redirect('/cities')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
//        } else {
//            return redirect('/cities')->with('success', 'تم التعديل بنجاح');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reason = ReportingReasons::findOrFail($id)->delete();

        if (!$reason) {
            return redirect('/reporting_reasons')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/reporting_reasons')->with('success', 'تم الحذف بنجاح');
        }
    }
}
