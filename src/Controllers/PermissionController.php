<?php

namespace MarkVilludo\Permission\Controllers;

use MarkVilludo\Permission\Models\Permission;
use MarkVilludo\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Session;
use Auth;

class PermissionController extends Controller
{
    public function __construct() 
    {
//         $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        if (View::exists('permissions.index')) {
            return view('permissions.index')->with('permissions', $permissions);
        } else {
            return view('laravel-permission::permissions.index')->with('permissions', $permissions);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();

        if (View::exists('permissions.create')) {
            return view('permissions.create')->with('roles', $roles);
        } else {
            return view('laravel-permission::permissions.create')->with('roles', $roles);
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
        // return $request->all();
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];
        
        $permission->save();

        if (!empty($request['roles'])) {
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first();   
                $r->givePermissionTo($permission);
            }
        }

        if (View::exists('permissions.index')) {
            return redirect()->route('permissions.index')->with('flash_message','Permission'. $permission->name.' added!');
        } else {
            return redirect()->route('laravel-permission::permissions.index')->with('flash_message','Permission'. $permission->name.' added!');
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
        return redirect('permissions');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        
        if (View::exists('permissions.edit')) {
            return view('permissions.edit', compact('permission'));
        } else {
            return view('laravel-permission::permissions.edit', compact('permission'));
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
        $permission = Permission::findOrFail($id);

        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        
        $input = $request->all();
        $permission->fill($input)->save();

        if (View::exists('permissions.index')) {
            return redirect()->route('permissions.index')->with('flash_message','Permission'. $permission->name.' updated!');
        } else {
            return redirect()->route('laravel-permission::permissions.index')
                        ->with('flash_message','Permission'. $permission->name.' updated!');
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
        $permission = Permission::findOrFail($id);
        
        if ($permission->name == "Administer roles & permissions") {
            return redirect()->route('permissions.index')
            ->with('flash_message',
             'Cannot delete this Permission!');
        }
        
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('flash_message',
             'Permission deleted!');
    }
}
