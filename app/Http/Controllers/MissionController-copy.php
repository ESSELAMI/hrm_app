<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\Mission;
use App\Models\Agent;
use App\Models\Department;
use App\Models\Place;
use App\Models\Reason;
use App\Models\CommuneDistance;
use App\Models\TravelAllowance;
use App\Models\FoodAllowance;

class MissionController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        $user_structure_id = Auth::user()->structure_id;
        switch ($role) {
            case 'user':
            $missions = Mission::with('agent.department','destinations','source','driver')->whereHas('agent.department', function ($query)
            {
                $query->where('structure_id', '=', Auth::user()->structure_id);
            })->get();
                // $agents =  \DB::select("SELECT 
                // a.id,
                // a.firstname,
                // a.lastname,
                // f.name,
                // a.vehicle_licence_number,
                // -- f.category_id,
                // -- f.section_id,
                // a.department_id,
                //  d.structure_id
                // from agents a, departments d, functions f
                // where d.structure_id = $user_structure_id
                // and d.id = a.department_id
                // and f.id = a.function_id
                // ");

            $agents = Agent::with('department','fonction')->whereHas('department', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })->get();
                $places = Place::all();
                $reasons = Reason::all();
              //  $agents = Agent::with('missions')->where('structure_id',Auth::user()->structure_id)->get();
               return view('user.missions_list',compact('agents','missions','places','places','reasons'));
                break;
            // case 'responsable_patrimoine':
            // $vehicles = Vehicle::with('missions')->where('structure_id',Auth::user()->structure_id)->get();
            // return view('parc_manager.missions_list',compact('missions','vehicles'));
            //     break;
            // case 'superviseur':
            // $vehicles = Vehicle::with('missions')->where('structure_id',Auth::user()->structure_id)->get();
            // return view('parc_manager.missions_list',compact('missions','vehicles'));
            //     break;
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

    public function getMissions()
    {
        $missions = Mission::with('agent.department','agent.fonction','destinations','source','driver')->whereHas('agent.department', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })->get();
        // with('agent')->where('structure_id',Auth::user()->structure_id)->get();

        
        return response()->json([
            'missions' => $missions
            ]);
    }

    public function getDistances(Request $request)
    {
        $source_id = $request->source_id;
        $destinations_ids = $request->destinations_ids;

        
        foreach ($destinations_ids as $destination_id) {
            $distances[] = CommuneDistance::whereRaw("source_id = $source_id and destination_id = $destination_id or (source_id = $destination_id and destination_id = $source_id
            )")->get()
            // ->orWhere(['source_id' => $destination_id, 'destination_id' => $source_id])
             ->pluck('distance');
            
        }

        $grade_id = $request->grade_id;
        $travel_allowances = TravelAllowance::where(['grade_id' => $grade_id])->get();
        $food_allowances = FoodAllowance::all();
        return response()->json([
            'distances' => $distances,
            'travel_allowances' => $travel_allowances,
            'food_allowances' => $food_allowances,
            'grade_id' => $grade_id
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
        $mission = Mission::create($request->all());
        
        $mission->save();
        $destinations = explode(',' , $request->destinations);
        $mission->destinations()->sync($destinations);
        return response()->json([
            'success'=>'Information enregistrée avec succès',
            'mission' => $mission,
            'm' => $mission->id
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
        $mission = Mission::findOrFail($id);
        $mission->destinations()->sync($request->destinations);
        $mission = $mission->update($request->all());

        return response()->json([
            'success'=>'Inoformation modifiée avec succès',
            'mission' => $mission
            ]);
    }

    public function update_decompte(Request $request, $id)
    {
        $mission = Mission::findOrFail($id);

        $mission->total =  $request->total;
        $mission->status =  $request->status;
        $mission->save();

        return response()->json([
            'success'=>'Inoformation modifiée avec succès',
            'mission' => $mission
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
        $mission = Mission::findOrFail($id);
        $mission->delete();

        return response()->json([
            'success'=>'Information supprimée avec succès',
            ]);
    }
    public function destroyAll()
    {
        \DB::table('missions')->delete();

        // $missions->delete();

        return response()->json([
            'success'=>'Informations supprimées avec succès',
            ]);
    }
}
