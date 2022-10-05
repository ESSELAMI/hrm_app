<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\Accident;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\UploadedFile;

class AccidentController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'chef_parc':
                $vehicles = Vehicle::with('accidents')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.accidents_list',compact('vehicles'));
                break;
            case 'responsable_patrimoine':
            $vehicles = Vehicle::with('accidents')->where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.accidents_list',compact('vehicles'));
                break;
            case 'superviseur':
            $vehicles = Vehicle::with('accidents')->where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.accidents_list',compact('vehicles'));
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

    public function getAccidents()
    {
        $vehicles = Vehicle::with('model.brand','energyType')->where('structure_id',Auth::user()->structure_id)->get();
        $drivers = Driver::where('structure_id',Auth::user()->structure_id)->get();
        $accidents = Accident::with('vehicle.model.brand','driver')
        ->whereHas('vehicle', function ($query)
            {
                $query->where('structure_id', '=', Auth::user()->structure_id);
            })
            ->whereHas('driver', function ($query)
            {
                $query->where('structure_id', '=', Auth::user()->structure_id);
            })
    ->get();
        return response()->json([
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'accidents' => $accidents
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
        if ($request->hasFile('report_file')) {

            $request['report_url'] = $request->file('report_file')->store(Auth::user()->structure->name.'/DECLARATIONS-ACCIDENTS');
        }
        $accident = Accident::create($request->all());
        return response()->json([
            'success'=>'Accident ajouté avec succès',
            'accident' => $accident
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
        $accident = Accident::findOrFail($id);

        if ($request->hasFile('report_file')) {
            unlink(public_path('storage/'.$accident->report_url)); // delete old file
            $request['report_url'] = $request->file('report_file')->store(Auth::user()->structure->name.'/DECLARATIONS-ACCIDENTS');
        }

        $accident = $accident->update($request->all());

        return response()->json([
            'success'=>'Accident modifié avec succès',
            'accident' => $accident,
            'hasfile' => $request->hasFile('report_file'),
            'request' => $request->all()
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
        $accident = Accident::findOrFail($id);
        unlink(public_path('storage/'.$accident->report_url)); // delete report_file
        $accident->delete();

        return response()->json([
            'success'=>'Accident supprimé avec succès',
            ]);
    }
}
