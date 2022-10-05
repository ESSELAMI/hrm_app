<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Agent;
use App\Models\Fonction;
use App\Models\Job;
use App\Models\Diploma;
use App\Models\Level;
use App\Models\Section;
use App\Models\Category;
use App\Models\Subdirectorate;
use App\Models\Department;
use Illuminate\Http\Request;


class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'user':
                
                $departments = Department::where('structure_id', '=', Auth::user()->structure_id)->get();
                $fonctions = Fonction::with('section','category')->get();
                $jobs = Job::all();
                $diplomas = Diploma::all();
                $levels = Level::all();
                $subdirectorates = Subdirectorate::all();
                
                $agents = Agent::with('job','fonction','diploma','department')->whereHas('department', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })->get();
                return view('user.agents_list',compact('agents','departments','fonctions','jobs','diplomas','levels','subdirectorates'));
                break;
            // case 'responsable_patrimoine':
            //     $licenceTypes = LicenceType::all();
            //     $drivers = Driver::where('structure_id',Auth::user()->structure_id)->get();
            //     return view('parc_manager.drivers_list',compact('licenceTypes','drivers'));
            //     break;
            // case 'superviseur':
            //     $licenceTypes = LicenceType::all();
            //     $drivers = Driver::where('structure_id',Auth::user()->structure_id)->get();
            //     return view('parc_manager.drivers_list',compact('licenceTypes','drivers'));
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

    public function getAgents()
    {
        // $agents = Agent::all();
        $agents = Agent::with('subdirectorate','level','job','fonction.category','fonction.section','diploma','department')->whereHas('department', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })->get();
        return response()->json([
            'agents' => $agents
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
        
        $agent = Agent::create($request->all());

        return response()->json([
            'success'=>'Agent créé avec succès',
            'agent' => $agent
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
       // $request['structure_id']= Auth::user()->structure_id;
        $agent = Agent::findOrFail($id);
        $agent->update($request->all());

        return response()->json([
            'success'=>'Agent modifié avec succès',
            'agent' => $agent
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
        $agent = Agent::findOrFail($id);
        $agent->delete();

        return response()->json([
            'success'=>'Agent supprimé avec succès',
            ]);
    }
}
