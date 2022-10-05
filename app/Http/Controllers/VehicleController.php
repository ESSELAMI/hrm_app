<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Vehicle as Vehicle;
use App\Models\VehicleType;
use App\Models\Brand;
use App\Models\EnergyType;
use App\Models\Condition;
use App\Models\InsuranceCompany;
use App\Models\InsuranceType;
use App\Models\Owner;
use App\Models\Affectation;
use App\Models\Insurance;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\View;
use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Requests\InsuranceStoreRequest;
use App\Http\Requests\AffectationStoreRequest;

class VehicleController extends Controller
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
            case 'chef_parc':
                $vehicleTypes = VehicleType::all();
                $energyTypes = EnergyType::all();
                $conditions = Condition::all();
               // $insuranceTypes = InsuranceType::all();
                $insuranceCompanies = InsuranceCompany::where('structure_id',Auth::user()->structure_id)->get();
                $owners = Owner::all();
                $brands = Brand::with('models')->get();
                $vehicles = Vehicle::with('affectations','insurances','model.brand')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.vehicles_list',compact('owners','insuranceCompanies','vehicleTypes','brands','energyTypes','vehicleTypes','conditions','vehicles'));
                break;
            case 'responsable_patrimoine':
                $vehicleTypes = VehicleType::all();
                $energyTypes = EnergyType::all();
                $conditions = Condition::all();
               // $insuranceTypes = InsuranceType::all();
                $insuranceCompanies = InsuranceCompany::where('structure_id',Auth::user()->structure_id)->get();
                $owners = Owner::all();
                $brands = Brand::with('models')->get();
                $vehicles = Vehicle::with('affectations','insurances','model.brand')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.vehicles_list',compact('owners','insuranceCompanies','vehicleTypes','brands','energyTypes','vehicleTypes','conditions','vehicles'));
                break;
            case 'superviseur':
                $vehicleTypes = VehicleType::all();
                $energyTypes = EnergyType::all();
                $conditions = Condition::all();
               // $insuranceTypes = InsuranceType::all();
                $insuranceCompanies = InsuranceCompany::where('structure_id',Auth::user()->structure_id)->get();
                $owners = Owner::all();
                $brands = Brand::with('models')->get();
                $vehicles = Vehicle::with('affectations','insurances','model.brand')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.vehicles_list',compact('owners','insuranceCompanies','vehicleTypes','brands','energyTypes','vehicleTypes','conditions','vehicles'));
                break;
            // case 'responsable_patrimoine':
            //     $vehicleTypes = VehicleType::all();
            //     $energyTypes = EnergyType::all();
            //     $brands = Brand::with('models')->get();
            //     $vehicles = Vehicle::where('structure_id',Auth::user()->structure_id)->get();
            //     return view('parc_manager.add_vehicle',compact('owners','insuranceCompanies','vehicleTypes','brands','energyTypes','vehicleTypes','conditions'));
            //     break;
        }
    }

    public function getVehicles()
    {
        $vehicles = Vehicle::with('model.brand','energyType')->where('structure_id',Auth::user()->structure_id)->get();

        return response()->json([
            'vehicles' => $vehicles,
            ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'chef_parc':
                $vehicleTypes = VehicleType::all();
                $energyTypes = EnergyType::all();
                $conditions = Condition::all();
               // $insuranceTypes = InsuranceType::all();
                $insuranceCompanies = InsuranceCompany::where('structure_id',Auth::user()->structure_id)->get();
                $owners = Owner::all();
                $brands = Brand::with('models')->get();
                return view('parc_manager.add_vehicle',compact('owners','insuranceCompanies','vehicleTypes','brands','energyTypes','vehicleTypes','conditions'));
                break;
            case 'responsable_patrimoine':
                $vehicleTypes = VehicleType::all();
                $energyTypes = EnergyType::all();
                $conditions = Condition::all();
            // $insuranceTypes = InsuranceType::all();
                $insuranceCompanies = InsuranceCompany::where('structure_id',Auth::user()->structure_id)->get();
                $owners = Owner::all();
                $brands = Brand::with('models')->get();
                return view('parc_manager.add_vehicle',compact('owners','insuranceCompanies','vehicleTypes','brands','energyTypes','vehicleTypes','conditions'));
                break;
            case 'superviseur':
                $vehicleTypes = VehicleType::all();
                $energyTypes = EnergyType::all();
                $conditions = Condition::all();
            // $insuranceTypes = InsuranceType::all();
                $insuranceCompanies = InsuranceCompany::where('structure_id',Auth::user()->structure_id)->get();
                $owners = Owner::all();
                $brands = Brand::with('models')->get();
                return view('parc_manager.add_vehicle',compact('owners','insuranceCompanies','vehicleTypes','brands','energyTypes','vehicleTypes','conditions'));
                break;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleStoreRequest $request)
    {
        $validated = $request->validated();
        $request['structure_id']= Auth::user()->structure_id;
        $vehicle = Vehicle::create($request->all());

        if ($request->hasFile('decision_file')) {
            $decision_file = $request->file('decision_file')->store(Auth::user()->structure->name.'/DECISIONS-AFFECTATION');
            $affectation = Affectation::create([
                'vehicle_id' => $vehicle->id,'owner_id' => $request->owner_id, 'decision_file' => $decision_file,
                'structure_id' => $vehicle->structure_id,'assigned_at' => $request->decision_date,
                'status' => $request->status,'kilometrage' => $request->kilometrage,
            ]);
        }

        $insurance = Insurance::create([
            'vehicle_id' => $vehicle->id,'insurrance_company_id' => $request->insurrance_company_id, 'started_at' => $request->started_at,
            'structure_id' => $vehicle->structure_id,'ended_at' => $request->ended_at,
            'cost' => $request->cost,'police_number' => $request->police_number,
        ]);

        return response()->json([
            'success'=>'Véhicule créé avec succès',
            'vehicle' => $vehicle
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
        $request['structure_id']= Auth::user()->structure_id;
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());

        return response()->json([
            'success'=>'Véhicule modifié avec succès',
            'vehicle' => $vehicle
            ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_insurance(InsuranceStoreRequest $request, $id)
    {
        $validated = $request->validated();
        $request['structure_id']= Auth::user()->structure_id;
        $request['vehicle_id']= $id;
        $insurance = Insurance::create($request->all());

        return response()->json([
            'success'=>"Informations d'assurance ajoutées avec succès",
            'insurance' => $insurance
            ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_affectation(AffectationStoreRequest $request, $id)
    {
        $validated = $request->validated();
        $request['structure_id']= Auth::user()->structure_id;
        $request['vehicle_id']= $id;
        if ($request->hasFile('uploaded_file')) {
            $request['decision_file'] = $request->file('uploaded_file')->store(Auth::user()->structure->name.'/DECISIONS-AFFECTATION');
        }
        $affectation = Affectation::create($request->all());

        return response()->json([
            'success'=>"Informations d'affectation ajoutées avec succès",
            'affectation' => $affectation
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
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return response()->json([
            'success'=>'Véhicule supprimé avec succès',
            ]);
    }
}
