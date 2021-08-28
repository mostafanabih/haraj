<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\Haraj_One_Info;
use App\Subscriptions;
use Illuminate\Http\Request;
use App\AdvImgs;
use App\AdvRatings;
use App\Advs;
use App\InternalSection;
use App\MainSection;
use App\SubSection;
use Carbon\Carbon;

class AdminController extends Controller
{
    public static function get_main_sub_internal_section($id, $flag){
        if($flag == 1){$section = MainSection::find($id);}
        elseif($flag == 2){$section = SubSection::find($id);}
        elseif($flag == 3){$section = InternalSection::find($id);}
        else{$section = null;}

        if($section){return $section;}else{return null;}
    }

    public function getDashboard()
    {
        $requests = Subscriptions::where('start_date', null)
            ->where('end_date', null)
            ->orderBy('updated_at', 'desc');
        $requests_ = $requests->paginate(5);

        $advs = Advs::all()->count();
        $advs_ = Advs::orderBy('updated_at', 'desc')->paginate(5);
        $advs_->each(function ($adv) {
            $today = Carbon::now();

            $i = AdvImgs::where('adv_id', $adv->id)->first();
            if($i){
                $split = explode('/',$i->img);
                if (file_exists('public/img/small/'.$split[2])) {
                    $adv->image = 'public/img/small/'.$split[2];
                }else{
                    if (file_exists($i->img)) {
                        $adv->image = $i->img;
                    } else {
                        $adv->image = 'public/img/no_img.png';
                    }
                }
            }else{
                $adv->image = 'public/img/no_img.png';
            }

            $ra = AdvRatings::where('adv_id', $adv->id)
                ->where('type', 0)->get();
            $ra = count($ra);
            $adv->rating_count = $ra;
            $t = Carbon::parse($adv->updated_at);
            $tt = $today->diffInDays($t);
            $adv->time = $tt;
        });

        $visits = Haraj_One_Info::findOrFail(1);
        return view('dashboard.dashboard')->with(array(
            'requests' => $requests,
            'requests_' => $requests_,
            'advs' => $advs,
            'advs_' => $advs_,
            'visits' => $visits->visits,
        ));
    }

    public function getRegisterRequest()
    {
        $requests = Subscriptions::where('start_date', null)
                            ->where('end_date', null)
                            ->paginate(10);
        return view('dashboard.register-request')->with('requests', $requests);
    }


    /* main section */
    public function getMainSections()
    {
        $m_sections = MainSection::paginate(10);
        return view('dashboard.sections.main.main-sections', compact('m_sections'));
    }
    public function getAddMainSection()
    {
        return view('dashboard.sections.main.add-main-section');
    }
    public function EditMainSection($id)
    {
        $main_section = MainSection::where('id', $id)->first();
        return view('dashboard.sections.main.edit-main-section', compact('main_section'));
    }
    public function MainSectionStore(Request $request)
    {
        $messages = [
            'name.required' => ('برجاء ادخال اسم القسم'),
            'name.unique' => ('اسم القسم موجود بالفعل'),
            'image.image' => ('يجب أن يكون الملف المرفوع من نوع صورة')
        ];
        $rules = [
            'name' => 'required|unique :main_section,name',
            'image' => 'image',
        ];
        $this->validate($request, $rules, $messages);
        $name = null;
        if ($file = $request->file('image')) {
            $name = date('Ymdhis').'_'.rand(0, 999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/main-sections-images', $name);

            $input = [
                'name' => $request->name,
                'img' => 'public/img/main-sections-images/'.$name
            ];
        }else{
            $input = [
                'name' => $request->name
            ];
        }

        $section = MainSection::create($input);
        if ($section) {
            return redirect()->route('main-sections')->with(['success' => 'تم الحفظ بنجاح']);
        } else {
            return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
        }
    }
    public function MainSectionUpdate(Request $request)
    {
        $section_update = MainSection::where('id', $request->section_id)->first();
        $messages = [
            'name.required' => ('برجاء ادخال اسم القسم'),
            'name.unique' => ('اسم القسم موجود بالفعل'),
        ];
        $rules = [
            'name' => 'required|unique :main_section,name,' . $section_update->id,
        ];
        $this->validate($request, $rules, $messages);

        $name = null;

        if ($request->hasFile('image')) {
            $section_img = $section_update->img;
            $file = $request->file('image');
            $name = date('Ymdhis').'_'.rand(0, 999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/main-sections-images', $name);
            if ($section_img != "" && $section_img != null) {
                if (file_exists($section_img)) {
                    unlink($section_img);
                }
            }
            $section_update->name = $request->name;
            $section_update->img = 'public/img/main-sections-images/'.$name;
            $action = $section_update->save();
            if ($action) {
                return redirect()->route('main-sections')->with(['success' => 'تم الحفظ بنجاح']);
            } else {
                return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
            }
        }else{
            $section_update->name = $request->name;
            $action = $section_update->save();
            if ($action) {
                return redirect()->route('main-sections')->with(['success' => 'تم الحفظ بنجاح']);
            } else {
                return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
            }
        }
    }
    public function MainSectionDelete($id)
    {
        $main_section = MainSection::findOrFail($id);
        if (file_exists($main_section->img)){
            unlink($main_section->img);
        }
        $action = $main_section->delete();

        $sub_imgs = SubSection::where('main_id', $id)->get();
        foreach($sub_imgs as $img){
            if (file_exists($img->img)) {
                unlink($img->img);
            }
        }
        $sub_imgs_ = SubSection::where('main_id', $id)->get()->each->delete();

        $internal_imgs = InternalSection::where('main_id', $id)->get();
        foreach($internal_imgs as $img){
            if (file_exists($img->img)) {
                unlink($img->img);
            }
        }
        $internal_imgs_ = InternalSection::where('main_id', $id)->get()->each->delete();

        // advs & its imgs
        $advs = Advs::where('main_section', $id)->get();
        foreach($advs as $adv){
            $adv_imgs = AdvImgs::where('adv_id', $adv->id)->get();
            foreach($adv_imgs as $img){
                if(file_exists($img->img)) {
                    unlink($img->img);
                }
            }
            $adv_imgs->each->delete();

            $adv_ratings = AdvRatings::where('adv_id', $adv->id)->get();
            if(count($adv_ratings) > 0){$adv_ratings->each->delete();}

            $favorite_advs = Favourite::where('adv_id', $adv->id)->get();
            if(count($favorite_advs) > 0){$favorite_advs->each->delete();}
        }
        if(count($advs) > 0){$advs->each->delete();}


        if (!$action or !$sub_imgs_ or !$internal_imgs_){
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم الحذف بنجاح');
        }
    }





    //sub section
    public function SubSection($id)
    {
        $main_section = MainSection::where('id', $id)->first();
        $subs = SubSection::where('main_id', $id)->paginate(10);
        return view('dashboard.sections.sub.sub-sections', compact('subs', 'main_section'));
    }
    public function getAddSubSection(Request $request)
    {
        $main_section = MainSection::where('id', $request->id)->first();
        return view('dashboard.sections.sub.add-sub-section', compact('main_section'));
    }
    public function EditSubSection($id)
    {
        $sub_section = SubSection::where('id', $id)->first();
        return view('dashboard.sections.sub.edit-sub-section', compact('sub_section'));
    }
    public function SubSectionStore(Request $request)
    {
        $messages = [
            'name.required' => ('برجاء ادخال اسم القسم'),
            'name.unique' => ('اسم القسم موجود بالفعل'),
            'image.image' => ('يجب أن يكون الملف المرفوع من نوع صورة')
        ];
        $rules = [
            'name' => 'required|unique :sub_section,name',
            'image' => 'image',
        ];
        $this->validate($request, $rules, $messages);
        $name = null;

        if ($file = $request->file('image')) {
            $name = date('Ymdhis').'_'.rand(0, 999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/sub-sections-images', $name);

            $input = [
                'name' => $request->name,
                'img' => 'public/img/sub-sections-images/'.$name,
                'main_id' => $request->main_id,
            ];
        }else{
            $input = [
                'name' => $request->name,
                'main_id' => $request->main_id,
            ];
        }

        $section = SubSection::create($input);
        if ($section) {
            return redirect('/sub-sections/' . $request->main_id)->with(['success' => 'تم الحفظ بنجاح']);
        } else {
            return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
        }
    }
    public function SubSectionUpdate(Request $request)
    {
        $sub_update = SubSection::where('id', $request->sub_section_id)->first();

        $messages = [
            'name.required' => ('برجاء ادخال اسم القسم'),
            'name.unique' => ('اسم القسم موجود بالفعل'),
        ];
        $rules = [
            'name' => 'required|unique :main_section,name,' . $sub_update->id,
        ];
        $this->validate($request, $rules, $messages);

        $name = null;

        if ($request->hasFile('image')) {
            $section_img = $sub_update->img;
            $file = $request->file('image');
            $name = date('Ymdhis').'_'.rand(0, 999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/sub-sections-images', $name);
            if ($section_img != "" && $section_img != null) {
                if (file_exists($section_img)) {
                    unlink($section_img);
                }
            }
            $sub_update->name = $request->name;
            $sub_update->img = 'public/img/sub-sections-images/'.$name;
            $action = $sub_update->save();
            if ($action) {
                return redirect('/sub-sections/' . $sub_update->main_id)->with(['success' => 'تم الحفظ بنجاح']);
            } else {
                return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
            }
        }else{
            $sub_update->name = $request->name;
            $action = $sub_update->save();
            if ($action) {
                return redirect('/sub-sections/' . $sub_update->main_id)->with(['success' => 'تم الحفظ بنجاح']);
            } else {
                return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
            }
        }
    }
    public function SubSectionDelete($id)
    {
        $sub_section = SubSection::findOrFail($id);
        if (file_exists($sub_section->img)){
            unlink($sub_section->img);
        }
        $action = $sub_section->delete();

        $internal_imgs = InternalSection::where('sub_id', $id)->get();
        foreach($internal_imgs as $img){
            if (file_exists($img->img)) {
                unlink($img->img);
            }
        }
        $internal_imgs_ = InternalSection::where('sub_id', $id)->get()->each->delete();

        // advs & its imgs
        $advs = Advs::where('sub_section', $id)->get();
        foreach($advs as $adv){
            $adv_imgs = AdvImgs::where('adv_id', $adv->id)->get();
            foreach($adv_imgs as $img){
                if(file_exists($img->img)) {
                    unlink($img->img);
                }
            }
            $adv_imgs->each->delete();

            $adv_ratings = AdvRatings::where('adv_id', $adv->id)->get();
            if(count($adv_ratings) > 0){$adv_ratings->each->delete();}

            $favorite_advs = Favourite::where('adv_id', $adv->id)->get();
            if(count($favorite_advs) > 0){$favorite_advs->each->delete();}
        }
        if(count($advs) > 0){$advs->each->delete();}

        if (!$action or !$internal_imgs_){
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم الحذف بنجاح');
        }
    }





    // internal sections
    public function InternalSection($id)
    {
        $internals = InternalSection::where('sub_id', $id)->paginate(10);
        $sub_section = SubSection::where('id', $id)->first();
        return view('dashboard.sections.internal.internal-sections', compact('internals', 'sub_section'));
    }
    public function getAddInternalSection(Request $request)
    {
        $sub_section = SubSection::where('id', $request->id)->first();
        return view('dashboard.sections.internal.add-internal-section', compact('sub_section'));
    }
    public function EditInternalSection($id)
    {
        $internal_section = InternalSection::where('id', $id)->first();
        return view('dashboard.sections.internal.edit-internal-section', compact('internal_section'));
    }
    public function InternalSectionStore(Request $request)
    {
        $messages = [
            'name.required' => ('برجاء ادخال اسم القسم'),
            'name.unique' => ('اسم القسم موجود بالفعل'),
            'image.image' => ('يجب أن يكون الملف المرفوع من نوع صورة')
        ];
        $rules = [
            'name' => 'required|unique :internal_section,name',
            'image' => 'image',
        ];
        $this->validate($request, $rules, $messages);
        $name = null;

        if ($file = $request->file('image')) {
            $name = date('Ymdhis').'_'.rand(0, 999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/internal-sections-images', $name);

            $input = [
                'name' => $request->name,
                'img' => 'public/img/internal-sections-images/'.$name,
                'main_id' => $request->main_id,
                'sub_id' => $request->sub_id,
            ];
        }else{
            $input = [
                'name' => $request->name,
                'main_id' => $request->main_id,
                'sub_id' => $request->sub_id,
            ];
        }

        $section = InternalSection::create($input);
        if ($section) {
            return redirect('/internal-sections/' . $request->sub_id)->with(['success' => 'تم الحفظ بنجاح']);
        } else {
            return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
        }
    }
    public function InternalSectionUpdate(Request $request)
    {
        $internal_update = InternalSection::where('id', $request->internal_section_id)->first();
        $messages = [
            'name.required' => ('برجاء ادخال اسم القسم'),
            'name.unique' => ('اسم القسم موجود بالفعل'),
        ];
        $rules = [
            'name' => 'required|unique :main_section,name,' . $internal_update->id,
        ];
        $this->validate($request, $rules, $messages);

        $name = null;

        if ($request->hasFile('image')) {
            $section_img = $internal_update->img;
            $file = $request->file('image');
            $name = date('Ymdhis').'_'.rand(0, 999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/internal-sections-images', $name);
            if ($section_img != "" && $section_img != null) {
                if (file_exists($section_img)) {
                    unlink($section_img);
                }
            }
            $internal_update->name = $request->name;
            $internal_update->img = 'public/img/internal-sections-images/'.$name;
            $action = $internal_update->save();
            if ($action) {
                return redirect('/internal-sections/' . $internal_update->sub_id)->with(['success' => 'تم الحفظ بنجاح']);
            } else {
                return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
            }
        }else{
            $internal_update->name = $request->name;
            $action = $internal_update->save();
            if ($action) {
                return redirect('/internal-sections/' . $internal_update->sub_id)->with(['success' => 'تم الحفظ بنجاح']);
            } else {
                return back()->with(['error' => 'حدث خطأ اثناء الحفظ']);
            }
        }
    }
    public function InternalSectionDelete($id)
    {
        $internal_section = InternalSection::findOrFail($id);
        if (file_exists($internal_section->img)){
            unlink($internal_section->img);
        }
        $action = $internal_section->delete();

        // advs & its imgs
        $advs = Advs::where('internal_section', $id)->get();
        foreach($advs as $adv){
            $adv_imgs = AdvImgs::where('adv_id', $adv->id)->get();
            foreach($adv_imgs as $img){
                if(file_exists($img->img)) {
                    unlink($img->img);
                }
            }
            $adv_imgs->each->delete();

            $adv_ratings = AdvRatings::where('adv_id', $adv->id)->get();
            if(count($adv_ratings) > 0){$adv_ratings->each->delete();}

            $favorite_advs = Favourite::where('adv_id', $adv->id)->get();
            if(count($favorite_advs) > 0){$favorite_advs->each->delete();}
        }
        if(count($advs) > 0){$advs->each->delete();}

        if (!$action){
            return back()->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return back()->with('success', 'تم الحذف بنجاح');
        }
    }



}
