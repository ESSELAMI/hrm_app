<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\Reparation;
use App\Models\Mechanic;
use App\Models\Vehicle;

class ReparationController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'chef_parc':
                $vehicles = Vehicle::with('reparations')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.reparations_list',compact('vehicles'));
                break;
            case 'responsable_patrimoine':
            $vehicles = Vehicle::with('reparations')->where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.reparations_list',compact('vehicles'));
                break;
            case 'superviseur':
            $vehicles = Vehicle::with('reparations')->where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.reparations_list',compact('vehicles'));
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

    public function getReparations()
    {
        $vehicles = Vehicle::with('model.brand','energyType')->where('structure_id',Auth::user()->structure_id)->get();
        $mechanics = Mechanic::where('structure_id',Auth::user()->structure_id)->get();
        $reparations = Reparation::with('vehicle.model.brand','mechanic')->whereHas('vehicle', function ($query)
        {
            $query->where('structure_id', '=', Auth::user()->structure_id);
        })->get();
        return response()->json([
            'vehicles' => $vehicles,
            'mechanics' => $mechanics,
            'reparations' => $reparations
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

        $reparation = Reparation::create($request->all());
        return response()->json([
            'success'=>'Information créée avec succès',
            'reparation' => $reparation
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
        $reparation = Reparation::findOrFail($id);
        $reparation = $reparation->update($request->all());

        return response()->json([
            'success'=>'Information modifiée avec succès',
            'reparation' => $reparation
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
        $reparation = Reparation::findOrFail($id);
        $reparation->delete();

        return response()->json([
            'success'=>'Information supprimée avec succès',
            ]);
    }
}
