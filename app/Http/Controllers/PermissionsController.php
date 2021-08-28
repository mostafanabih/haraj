<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\Permission;
use App\Permission_role;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public static function get_permissions($admin_id){
        $permissions = Permission_role::where('admin_id', $admin_id)->get();
        return $permissions;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Advertiser::where('roles', 1)
            ->where('type_of_roles', 0)->paginate(10);
        return view('dashboard.admins.admins')->with(array(
            'admins' => $admins,
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
        $admin = Advertiser::findOrFail($id);
        $permissions = Permission::all();

        $permissions_roles = Permission_role::where('admin_id', $admin->id)->select('permission_id')->get();
        $permission_role = '';
        foreach($permissions_roles as $k){
            $permission_role .= $k->permission_id.',';
        }
        $permission_role_ = explode(',', rtrim($permission_role,","));

        return view('dashboard.admins.update_permission')->with(array(
            'admin' => $admin,
            'permissions' => $permissions,
            'permission_role_' => $permission_role_,
        ));
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
        $permissions = Permission_role::where('admin_id', $id)->get()->each->delete();

        if($request->has('permissions')){
            foreach($request->permissions as $permission){
                $my_inputs = [];
                $my_inputs[] = [
                    'admin_id' => $request->admin_id,
                    'permission_id' => $permission,
                ];
                Permission_role::insert($my_inputs);
            }
        }

        if (!$permissions) {
            return redirect('/permissions')->with('error', 'حدث خطأ .. من فضلك حاول مرة أخرى');
        } else {
            return redirect('/permissions')->with('success', 'تم تعديل الصلاحيات بنجاح');
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
        //
    }
}
