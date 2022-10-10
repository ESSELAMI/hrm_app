<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Perfonction\Models\Role;
use Spatie\Perfonction\Models\Perfonction;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\Service;
use App\Models\Agent;
use App\Models\Department;
use App\Models\Section;
use App\Models\Category;
use App\Models\CommuneDistance;
use App\Models\TravelAllowance;
use App\Models\FoodAllowance;

class ServiceController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'user':
                $services = Service::with('category', 'section')->get();

                $categories = Category::all();
                $sections = Section::all();
                return view('user.functions_list', compact('fonctions', 'sections', 'categories'));
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

    public function getServices()
    {
        $services = Service::with('rubrique')->get();
        // with('agent')->where('structure_id',Auth::user()->structure_id)->get();


        return response()->json([
            'services' => $services
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
        $service = Service::create($request->all());

        $service->save();

        return response()->json([
            'success' => 'Information enregistrée avec succès',
            'fonction' => $service,

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
        $service = Service::findOrFail($id);

        $service = $service->update($request->all());

        return response()->json([
            'success' => 'Inoformation modifiée avec succès',
            'fonction' => $service
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
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json([
            'success' => 'Information supprimée avec succès',
        ]);
    }
}
