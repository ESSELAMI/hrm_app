<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Perconfirmedlevel\Models\Role;
use Spatie\Perconfirmedlevel\Models\Perconfirmedlevel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\ConfirmedLevel;
use App\Models\Agent;
use App\Models\Department;
use App\Models\Level;
use App\Models\Reason;
use App\Models\CommuneDistance;
use App\Models\TravelAllowance;
use App\Models\FoodAllowance;

class ConfirmedLevelController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'user':
            $levels = Level::all();    
            $confirmedlevels = ConfirmedLevel::with('agent.department','agent.fonction','user','level')->whereHas('agent.department', function ($query)
            {
                $query->where('structure_id', '=', Auth::user()->structure_id);
            })->get();
            $agents = Agent::with('department','fonction')->whereHas('department', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })->get();
              //  $agents = Agent::with('confirmedlevels')->where('structure_id',Auth::user()->structure_id)->get();
               return view('user.confirmedlevels_list',compact('agents','confirmedlevels','levels'));
                break;
            // case 'user_patrimoine':
            // $vehicles = Vehicle::with('confirmedlevels')->where('structure_id',Auth::user()->structure_id)->get();
            // return view('parc_manager.confirmedlevels_list',compact('confirmedlevels','vehicles'));
            //     break;
            // case 'superviseur':
            // $vehicles = Vehicle::with('confirmedlevels')->where('structure_id',Auth::user()->structure_id)->get();
            // return view('parc_manager.confirmedlevels_list',compact('confirmedlevels','vehicles'));
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

    public function getConfirmedLevels()
    {
        // $confirmedlevels = ConfirmedLevel::with('agent.department','agent.fonction','user')->where('user_id', '=', Auth::user()->id)->whereHas('agent.department', function ($query)
        $confirmedlevels = ConfirmedLevel::with('agent.department','agent.fonction','user','level')->whereHas('agent.department', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })->get();
        // with('agent')->where('structure_id',Auth::user()->structure_id)->get();

        
        return response()->json([
            'confirmedlevels' => $confirmedlevels
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
        $request['user_id'] = Auth::user()->id;
        $confirmedlevel = ConfirmedLevel::create($request->all());
        // $confirmedlevel->user = Auth::user()->id;
        $confirmedlevel->save();
       
        return response()->json([
            'success'=>'Information enregistrée avec succès',
            'confirmedlevel' => $confirmedlevel
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
        $confirmedlevel = ConfirmedLevel::findOrFail($id);
        
        $confirmedlevel = $confirmedlevel->update($request->all());

        return response()->json([
            'success'=>'Inoformation modifiée avec succès',
            'confirmedlevel' => $confirmedlevel
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
        $confirmedlevel = ConfirmedLevel::findOrFail($id);
        $confirmedlevel->delete();

        return response()->json([
            'success'=>'Information supprimée avec succès',
            ]);
    }
}
