<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use HasRoles;

class PermissionController extends Controller
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
        return view('superadmin.permissions_list');
        
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
    public function store(PermissionStoreRequest $request)
    {
        $validated = $request->validated();

        $permission = Permission::create(['name'=>$request->name]);

        return response()->json([
                'success'=>'Information ajouté avec succès',
                'permission'=>$permission
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
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $validated = $request->validated();


        $permission = Permission::findById($id);
        $permission->name = $request->name;

        $permission->save();

        return response()->json([
                'success'=>'Information modifée avec succès',
                'permission'=>$permission
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
        $permission = Permission::findById($id);
        $permission->delete();
        
        return response()->json(['success'=>'La permission a été supprimée avec succés']);
      
    }

    public function getPermissions()
    {
        $permissions = Permission::all();
        return compact('permissions');
    }

    public function createPermission()
    {
        $permission = new Permission();
        $permission->name = request('name');

        $permission->save();
    }
}
