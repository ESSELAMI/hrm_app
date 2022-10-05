<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Perfonction\Models\Role;
use Spatie\Perfonction\Models\Perfonction;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\Fonction;
use App\Models\Agent;
use App\Models\Department;
use App\Models\Section;
use App\Models\Category;
use App\Models\CommuneDistance;
use App\Models\TravelAllowance;
use App\Models\FoodAllowance;

class FonctionController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'user':
                $fonctions = Fonction::with('category','section')->get();
            
                $categories = Category::all();
                $sections = Section::all();
               return view('user.functions_list',compact('fonctions','sections','categories'));
                break;
            // case 'responsable_patrimoine':
            // $vehicles = Vehicle::with('fonctions')->where('structure_id',Auth::user()->structure_id)->get();
            // return view('parc_manager.fonctions_list',compact('fonctions','vehicles'));
            //     break;
            // case 'superviseur':
            // $vehicles = Vehicle::with('fonctions')->where('structure_id',Auth::user()->structure_id)->get();
            // return view('parc_manager.fonctions_list',compact('fonctions','vehicles'));
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

    public function getFonctions()
    {
        $fonctions = Fonction::with('category','section')->get();
        // with('agent')->where('structure_id',Auth::user()->structure_id)->get();

        
        return response()->json([
            'fonctions' => $fonctions
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
        $fonction = Fonction::create($request->all());
        
        $fonction->save();
       
        return response()->json([
            'success'=>'Information enregistrée avec succès',
            'fonction' => $fonction,
            
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
        $fonction = Fonction::findOrFail($id);
        
        $fonction = $fonction->update($request->all());

        return response()->json([
            'success'=>'Inoformation modifiée avec succès',
            'fonction' => $fonction
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
        $fonction = Fonction::findOrFail($id);
        $fonction->delete();

        return response()->json([
            'success'=>'Information supprimée avec succès',
            ]);
    }
}
