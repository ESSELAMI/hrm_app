<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\CommuneDistance;
use App\Models\Place;

class CommuneDistanceController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'superadmin':
                $commune_distances = CommuneDistance::with('source', 'destination');
                $places = Place::all();
                return view('superadmin.commune_distances_list', compact('commune_distances', 'places'));
                break;
            case 'admin':
                $places = Place::all();
                $commune_distances = CommuneDistance::with('source', 'destination');
                return view('superadmin.commune_distances_list', compact('commune_distances', 'places'));
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

    public function getCommuneDistances()
    {
        $commune_distances = CommuneDistance::with('source', 'destination')->get();
        return response()->json([
            'commune_distances' => $commune_distances
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

        $commune_distances = CommuneDistance::create($request->all());

        return response()->json([
            'success' => 'L\'agence d\'assurance créée avec succès',
            'commune_distances' => $commune_distances
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'superadmin':
                $commune_distances = CommuneDistance::with('source', 'destination');
                $places = Place::all();
                return view('superadmin.commune_distances_list', compact('commune_distances', 'places'));
                break;
            case 'admin':
                $places = Place::all();
                $commune_distances = CommuneDistance::with('source', 'destination');
                return view('superadmin.commune_distances_list', compact('commune_distances', 'places'));
                break;
        }
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
        $commune_distance = CommuneDistance::findOrFail($id);
        $commune_distance->update($request->all());

        return response()->json([
            'success' => 'Information modifiée avec succès',
            'commune_distance' => $commune_distance
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
        $commune_distance = CommuneDistance::findOrFail($id);
        $commune_distance->delete();

        return response()->json([
            'success' => 'Information supprimée avec succès',
        ]);
    }
}
