<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\AnnualTax;
use App\Models\Vehicle;

class AnnualTaxController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'chef_parc':
                $vehicles = Vehicle::with('annualTaxes')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.annualTaxes_list',compact('vehicles'));
                break;
            case 'responsable_patrimoine':
                $vehicles = Vehicle::with('annualTaxes')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.annualTaxes_list',compact('vehicles'));
                break;
            case 'superviseur':
                $vehicles = Vehicle::with('annualTaxes')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.annualTaxes_list',compact('vehicles'));
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

    public function getAnnualTaxes()
    {
        $vehicles = Vehicle::with('model.brand','energyType')->where('structure_id',Auth::user()->structure_id)->get();
        $annualTaxes = AnnualTax::with('vehicle.model.brand')->whereHas('vehicle', function ($query)
        {
            $query->where('structure_id', '=', Auth::user()->structure_id);
        })->get();
        return response()->json([
            'vehicles' => $vehicles,
            'annualTaxes' => $annualTaxes
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
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $annualTax = $vehicle->annualTaxes()->create($request->all());
        return response()->json([
            'success'=>'vignettes créée avec succès',
            'annualTax' => $annualTax
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
        $annualTax = AnnualTax::findOrFail($id);
        $annualTax = $annualTax->update($request->all());

        return response()->json([
            'success'=>'vignettes modifiée avec succès',
            'annualTax' => $annualTax
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
        $annualTax = AnnualTax::findOrFail($id);
        $annualTax->delete();

        return response()->json([
            'success'=>'vignettes supprimée avec succès',
            ]);
    }
}
