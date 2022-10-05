<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\Mechanic;


class MechanicController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'chef_parc':
                $mechanics = Mechanic::where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.mechanics_list',compact('mechanics'));
                break;
            case 'responsable_patrimoine':
            $mechanics = Mechanic::where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.mechanics_list',compact('mechanics'));
                break;
            case 'superviseur':
            $mechanics = Mechanic::where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.mechanics_list',compact('mechanics'));
                break;
        }
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

    public function getMechanics()
    {
        $mechanics = Mechanic::where('structure_id',Auth::user()->structure_id)->get();
        return response()->json([
            'mechanics' => $mechanics
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['structure_id']= Auth::user()->structure_id;
        $mechanic = Mechanic::create($request->all());

        return response()->json([
            'success'=>'Mécanicien créé avec succès',
            'mechanic' => $mechanic
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
    public function update(Request $request, $id)
    {
        $request['structure_id']= Auth::user()->structure_id;
        $mechanic = Mechanic::findOrFail($id);
        $mechanic->update($request->all());

        return response()->json([
            'success'=>'Mécanicien modifié avec succès',
            'mechanic' => $mechanic
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
        $mechanic = Mechanic::findOrFail($id);
        $mechanic->delete();

        return response()->json([
            'success'=>'Mécanicien supprimé avec succès',
            ]);
    }
}
