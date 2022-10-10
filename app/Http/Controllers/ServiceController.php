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
            case 'superadmin':
                $services = Service::with('rubriques')->get();

                return view('superadmin.services_list', compact('services'));
                break;
            case 'admin':
                $services = Service::with('rubriques')->get();

                return view('admin.services_list', compact('services'));
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

    public function getServices()
    {
        $services = Service::with('rubriques')->get();
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
            'service' => $service
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
