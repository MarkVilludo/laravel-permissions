<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Response;
use Validator;
use Config;

class RoleController extends Controller
{   
    public function __construct(Permission $permission, Role $role) 
    {   
        $this->role = $role;
        $this->permission = $permission;
        $this->middleware(['auth', 'isAdmin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $role = $this->role->all();
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
        // return $request->all();
        $rules = [
            'name' => 'required|unique:roles,name',
            'permissions' =>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $data['message'] = [$validator->errors()];
            $statusCode = 422;
        } else {

            $name = $request->name;
            $role = new Role();
            $role->name = $name;

            $permissions = $request['permissions'];

            if ($role->save()) {
                if (count($permissions) > 0) {
                    foreach ($permissions as $permission) {
                        $p = Permission::where('id', '=', $permission)->firstOrFail();
                        $role = Role::where('name', '=', $name)->first();
                        $role->givePermissionTo($p);
                    }
                }
                $data['message'] = Config::get('app_messages.SuccessCreateRole');
                $statusCode = 200;

            } else {
                $data['message'] = Config::get('app_messages.SomethingWentWrong');
                $statusCode = 400;
            }
        }
        return Response::json(['data' => $data], $statusCode);
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
        $rules = [
            'name' => 'required|unique:roles,name,'.$id,
            'permissions' =>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $data['message'] = [$validator->errors()];
            $statusCode = 422;
        } else {    
            // return $id;
            $role = Role::findOrFail($id);

            $input = $request->except(['permissions']);
            $permissions = $request->permissions;
            
            if ($role->fill($input)->save()) {
                $getPermissions = Permission::all();

                foreach ($getPermissions as $getPermission) {
                    $role->revokePermissionTo($getPermission);
                }

                foreach ($permissions as $permission) {
                    $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form permission in db
                    
                    $role->givePermissionTo($p);  
                }
                
                $data['message'] = Config::get('app_messages.SuccessUpdatedRole');
                $statusCode = 200;
            } else {
                $data['message'] = Config::get('app_messages.SomethingWentWrong');
                $statusCode = 400;
            }
        }
        return Response::json(['data' => $data], $statusCode);
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
