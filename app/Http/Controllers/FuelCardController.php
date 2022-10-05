<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\FuelCard;
use App\Models\Vehicle;

class FuelCardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'chef_parc':
                $fuelCards = FuelCard::with('vehicle')->get();
                $vehicles = Vehicle::with('fuelCard')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.fuelCards_list',compact('fuelCards','vehicles'));
                break;
            case 'responsable_patrimoine':
            $fuelCards = FuelCard::with('vehicle')->get();
            $vehicles = Vehicle::with('fuelCard')->where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.fuelCards_list',compact('fuelCards','vehicles'));
                break;
            case 'superviseur':
            $fuelCards = FuelCard::with('vehicle')->get();
            $vehicles = Vehicle::with('fuelCard')->where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.fuelCards_list',compact('fuelCards','vehicles'));
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

    public function getFuelCards()
    {
        $vehicles = Vehicle::with('fuelCard','model.brand','energyType')->where('structure_id',Auth::user()->structure_id)->get();
        return response()->json([
            'vehicles' => $vehicles
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
        //$fuelCard = FuelCard::create($request->all());
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $fuelCard = $vehicle->fuelCard ? $vehicle->fuelCard()->update($request->all()) : $vehicle->fuelCard()->create($request->all());
        return response()->json([
            'success'=>'Carte NAFTAL créée avec succès',
            'fuelCard' => $fuelCard
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
        $fuelCard = FuelCard::findOrFail($id);
        $fuelCard->update($request->all());

        return response()->json([
            'success'=>'Carte NAFTAL modifiée avec succès',
            'fuelCard' => $fuelCard
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
        $fuelCard = FuelCard::findOrFail($id);
        $fuelCard->delete();

        return response()->json([
            'success'=>'Carte NAFTAL supprimée avec succès',
            ]);
    }
}

