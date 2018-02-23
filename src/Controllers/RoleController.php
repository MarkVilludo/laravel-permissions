<?php

namespace MarkVilludo\Permission\Controllers;

use MarkVilludo\Permission\Models\Permission;
use MarkVilludo\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        if (View::exists('roles.index')) {
            return view('roles.index')->with('roles', $roles);
        } else {
            return view('laravel-permission::roles.index')->with('roles', $roles);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        if (View::exists('roles.create')) {
            return view('roles.create', ['permissions'=>$permissions]);
        } else {
            return view('laravel-permission::roles.create', ['permissions'=>$permissions]);
        }
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
            'name'=>'required|unique:roles|max:10',
            'permissions' =>'required',
            ]
        );

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        $roles = Role::all();

        if (View::exists('roles.create')) {
            return view('roles.index')->with('roles', $roles)
                        ->with('flash_message','Role'. $role->name.' added!');
        } else {
            return view('laravel-permission::roles.index')->with('roles', $roles)
                        ->with('flash_message','Role'. $role->name.' added!');
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
        return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        if (View::exists('roles.create')) {
            return view('roles.create', compact('role', 'permissions'));
        } else {
            return view('laravel-permission::roles.edit', compact('role', 'permissions'));
        }
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
        // return $request->all();
        $role = Role::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();
        $p_all = Permission::all();

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p);
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form permission in db
            $role->givePermissionTo($p);  
        }

        if (View::exists('roles.create')) {
            return redirect()->route('roles.index')->with('flash_message', 'Role'. $role->name.' updated!');
        } else {
            return redirect()->route('laravel-permission::roles.index')->with('flash_message', 'Role'. $role->name.' updated!');
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
        $role = Role::findOrFail($id);
        $role->delete();

        if (View::exists('roles.index')) {
            return redirect()->route('roles.index')->with('flash_message', 'Role deleted!');
        } else {
            return redirect()->route('laravel-permission::roles.index')->with('flash_message', 'Role deleted!');
        }
    }
}
