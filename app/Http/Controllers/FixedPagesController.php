<?php

namespace App\Http\Controllers;

use App\FixedPages;
use Illuminate\Http\Request;

class FixedPagesController extends Controller
{

    public static function get_pages(){
        return FixedPages::all();
    }

    public function show_page($id)
    {
        $page = FixedPages::findOrFail($id);
        return view('fixed_page')->with('page', $page);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fixed_pages = FixedPages::paginate(10);
        return view('dashboard.fixed_pages.fixed_pages')->with('fixed_pages', $fixed_pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.fixed_pages.add_page');
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
            'title' => 'required|max:255|unique:fixed_pages',
            'content_' => 'required',
        ]);

        $page = new FixedPages();
        $page->title = $request->title;
        $page->content = $request->content_;
        $action = $page->save();

        if (!$action) {
            return redirect('/fixed_pages')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/fixed_pages')->with('success', 'تمت الإضافة بنجاح');
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
        $page = FixedPages::findOrFail($id);
        return view('dashboard.fixed_pages.show_page')->with('page', $page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = FixedPages::findOrFail($id);
        return view('dashboard.fixed_pages.update_page')->with('page', $page);
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
        $page = FixedPages::findOrFail($id);

        if($page->title and $page->title == $request->title){
            $this->validate($request, [
                'title' => 'required|max:255',
                'content_' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'title' => 'required|max:255|unique:fixed_pages',
                'content_' => 'required',
            ]);
        }

        $page->title = $request->title;
        $page->content = $request->content_;
        $action = $page->save();

        if (!$action) {
            return redirect('/fixed_pages')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/fixed_pages')->with('success', 'تم التعديل بنجاح');
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
        $page = FixedPages::findOrFail($id)->delete();

        if (!$page) {
            return redirect('/fixed_pages')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/fixed_pages')->with('success', 'تم الحذف بنجاح');
        }
    }
}
