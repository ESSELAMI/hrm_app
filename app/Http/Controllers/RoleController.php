<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

use HasRoles;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','role:superadmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('superadmin.roles_list');

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
    public function store(RoleStoreRequest $request)
    {
        $validated = $request->validated();


        $role = new Role();
        $role->name = $request->name;

        $role->save();

        // return compact('validated');
        return response()->json([
                'success'=>'Information ajouté avec succès',
                'role'=>$role
                ]);

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
    public function update(RoleUpdateRequest $request, $id)
    {
        $validated = $request->validated();


        $role = Role::findById($id);
        $role->name = $request->name;

        $role->save();

        return response()->json([
                'success'=>'Information modifée avec succès',
                'role'=>$role
                ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $role = Role::findById($id);
        if ($role->name!='superadmin') {
            $role->delete();
            return response()->json(['success'=>'Le rôle a été supprimé avec succés']);
        } else if($role->name === 'superadmin'){
            return response()->json(['error'=>'Ce rôle ne peut pas être supprimé']);
        }
    }
    public function getRoles()
    {
        $roles = Role::with('permissions')->get();
        return compact('roles');
    }

    public function assignPermissions(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'permissions'=>'required',
            ]);
        $permissions = $request->permissions;


        $permissions = Permission::find($permissions);

        $role = Role::findById($id);
        $role->syncPermissions($permissions);

        $roles = Role::with('permissions')->get();
        return response()->json([
                'success' => 'Information modifée avec succès',
                'permissions' => $permissions,
                'roles' => $roles
                ]);
    }
    public function revokePermission(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'permission'=>'required',
            ]);
        $permission = $request->permission;


        $permission = Permission::find($permission);

        $role = Role::findById($id);
        $role->revokePermissionTo($permission);

        return response()->json([
                'success'=>'Information modifée avec succès'
                ]);
    }

    public function test()
    {
        $permissions = Permission::find($permissions);
        $role = Role::findOrFail(1);
        $role->syncPermissions($permissions);
    }
}
