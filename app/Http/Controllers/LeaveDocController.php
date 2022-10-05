<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Perleave_doc\Models\Role;
use Spatie\Perleave_doc\Models\Perleave_doc;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\LeaveDoc;
use App\Models\Agent;
use App\Models\Department;
use App\Models\Place;
use App\Models\Reason;
use App\Models\CommuneDistance;
use App\Models\TravelAllowance;
use App\Models\FoodAllowance;

class LeaveDocController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'user':
            $leave_docs = LeaveDoc::with('agent.department','agent.fonction','responsable')->where('responsable_id', '=', Auth::user()->id)->whereHas('agent.department', function ($query)
            {
                $query->where('structure_id', '=', Auth::user()->structure_id);
            })->get();
            $agents = Agent::with('department','fonction')->whereHas('department', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })->get();
              //  $agents = Agent::with('leave_docs')->where('structure_id',Auth::user()->structure_id)->get();
               return view('user.leavedocs_list',compact('agents','leave_docs'));
                break;
            // case 'responsable_patrimoine':
            // $vehicles = Vehicle::with('leave_docs')->where('structure_id',Auth::user()->structure_id)->get();
            // return view('parc_manager.leave_docs_list',compact('leave_docs','vehicles'));
            //     break;
            // case 'superviseur':
            // $vehicles = Vehicle::with('leave_docs')->where('structure_id',Auth::user()->structure_id)->get();
            // return view('parc_manager.leave_docs_list',compact('leave_docs','vehicles'));
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

    public function getLeaveDocs()
    {
        $leave_docs = LeaveDoc::with('agent.department','agent.fonction','responsable')->where('responsable_id', '=', Auth::user()->id)->whereHas('agent.department', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })->get();
        // with('agent')->where('structure_id',Auth::user()->structure_id)->get();

        
        return response()->json([
            'leave_docs' => $leave_docs
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
        $request['responsable_id'] = Auth::user()->id;
        $leave_doc = LeaveDoc::create($request->all());
        // $leave_doc->responsable = Auth::user()->id;
        $leave_doc->save();
       
        return response()->json([
            'success'=>'Information enregistrée avec succès',
            'leave_doc' => $leave_doc
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
        $leave_doc = LeaveDoc::findOrFail($id);
        
        $leave_doc = $leave_doc->update($request->all());

        return response()->json([
            'success'=>'Inoformation modifiée avec succès',
            'leave_doc' => $leave_doc
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
        $leave_doc = LeaveDoc::findOrFail($id);
        $leave_doc->delete();

        return response()->json([
            'success'=>'Information supprimée avec succès',
            ]);
    }
}
