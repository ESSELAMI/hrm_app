@extends('layouts.base')

@section('page_title')
<h5> <strong> Liste des véhicules </strong></h5>
{{-- <span> Nombre des véhicules : <strong>@{{ number_vehicles}}</strong> </span> --}}
@endsection
@section('page-styles')
{{-- <style>
th { font-size: 11px; }
td { font-size: 10px; }
</style> --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('vehicles-list') }}">Liste des véhicules</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row" >
    <div :class=" [!show_edit ? 'col-lg-12 animated fadeInDown' : 'col-lg-12 animated fadeOutDown'] " v-show="!show_edit">
        <div class="card">
            <div class="card-header table-card-header">
                <h5>Liste des véhicules</h5>

            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="vehicles-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Immatriculation</th>
                                <th>N° Chassis</th>
                                <th>Motorisation</th>
                                <th>Type</th>
                                <th>GPS</th>
                                <th>Etat général</th>
                                <th>Numéro-Police</th>
                                <th>Kilométrage</th>
                                <th>Propriétaire</th>
                                <th class="text-center noExport">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicles as $index => $vehicle)
                            <tr id="tr_{{$index}}">
                                <td>{{ $index+1}}</td>
                                <td>{{ $vehicle->model->brand->name }} </td>
                                <td>{{ $vehicle->model->name }} </td>
                                <td>{{ $vehicle->licence_plate }} </td>
                                <td>{{ $vehicle->identification_number }} </td>
                                <td>{{ $vehicle->energyType->name}} </td>
                                <td>{{ $vehicle->vehicleType->name }} </td>
                                @if ($vehicle->has_gps_tracker)
                                    <td class="text-center"><i class="icofont icofont-ui-check text-success"></i> <p style="display:none">Oui</p></td>
                                @else
                                    <td class="text-center"><i class="icofont icofont-ui-close text-danger"></i><p style="display:none">Non</p></td>
                                @endif

                                @switch( $vehicle->status)
                                    @case('NEUF')
                                        <td><strong class="text-info"> {{$vehicle->status}}</strong> </td>
                                        @break
                                    @case('BON ETAT')
                                        <td><strong class="text-success"> {{$vehicle->status}}</strong> </td>
                                        @break
                                    @case('TRES BON ETAT')
                                        <td><strong class="text-primary"> {{$vehicle->status}}</strong> </td>
                                        @break
                                    @case('ETAT MOYEN')
                                        <td><strong class="text-warning"> {{$vehicle->status}}</strong> </td>
                                        @break
                                    @case('MAUVAIS ETAT')
                                        <td><strong class="text-danger"> {{$vehicle->status}}</strong> </td>
                                        @break
                                    @default
                                    <td><strong class="text-default"> {{$vehicle->status}}</strong> </td>
                                @endswitch

                                <td>{{ $vehicle->police_number }} </td>
                                <td>{{ $vehicle->kilometrage }} </td>
                                <td>{{ $vehicle->owner->name }} </td>
                                <td >
                                    <div class="text-center">

                                            <i data-toggle="tooltip" data-placement="top" data-original-title="Modifier"
                                             class="feather icon-edit text-custom f-18 clickable md-trigger"
                                             v-on:click="edit_vehicle({{ $vehicle }})">
                                            </i>

                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_vehicle({{$vehicle->id}},{{$index}})"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                        </i>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div :class=" [show_edit ? 'col-md-12 animated fadeInRight' : 'col-md-12 animated fadeOutRight'] "
     v-show="show_edit" >
        <div class="card" id="basic-info-form">
            <div class="card-header " >
                    <h6 v-on:click="$('#m1').click()" style="cursor:pointer"><strong>Renseignements du véhicule</strong>   </h6>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i data-toggle="tooltip" data-placement="top" data-original-title="List des véhicules"
                                class="fa fa-arrow-left text-warning faa-passing-reverse animated" style="font-size:26px" v-on:click="show_edit=false"></i></li>
                        </ul>
                    </div>
            </div>

            <div class="card-block" >
            <strong class="text-danger">Veuillez remplir tous les champs obligatoires (*)</strong>
                <hr>
                <form >
                    <div class="row" >
                        <div class="form-group col-md-4">
                            <label for="brands" class="block">Marque du véhicule <span class="text-danger"> (*)</span></label>
                            <div :class="[errors.vehicle_model_id ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                <select id="brands" class="selectpicker show-tick basic_info" data-live-search="true" title="Marque..." v-model="brand"
                                    data-width="100%" data-size="7" v-on:change="show_models($('#brands').selectpicker('val'))"
                                    :disabled="true" >
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->name}}" v-model="vehicle_model_id" > {{$brand->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-brand-mercedes" data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.vehicle_model_id"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="-date" class="block">Modèle du véhicule <span class="text-danger">(*)</span></label>
                            <div :class="[errors.vehicle_model_id ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top" :data-original-title="errors.vehicle_model_id">
                                <select  id="models" class="selectpicker show-tick basic_info" data-live-search="true" title="Modèle..."
                                    data-width="100%" data-size="7" data-hide-disabled= 'true' style="width:50%"
                                    :disabled="true" >

                                    @foreach ($brands as $brand)
                                    <optgroup label="{{$brand->name}}" disabled>
                                        @foreach ($brand->models as $model)
                                        <option value="{{$model->id}}" v-model="vehicle_model_id"> {{$model->name}}</option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-car" data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.vehicle_model_id"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="energy_types" class="block">Energie <span class="text-danger">(*)</span></label>
                            <div :class="[errors.energy_type_id ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top" :data-original-title="errors.energy_type_id">
                                <select id="energy_types" class="selectpicker show-tick basic_info" title="Energie..."
                                    data-width="100%" :disabled="true" >
                                    @foreach ($energyTypes as $energyType)
                                    <option value="{{$energyType->id}}" > {{$energyType->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-water-drop"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="horsepower" class="block">Puissance <span class="text-danger">(*)</span></label>
                            <div :class="[errors.horsepower ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input id ="horsepower" type="number" class="form-control basic_info" placeholder="Nombre de chevaux..." v-model="horsepower"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.horsepower"
                                     :disabled="true" >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-dashboard"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="engine" class="block">Motorisation <span class="text-danger">(*)</span></label>
                            <div :class="[errors.engine ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input id ="engine" type="text" class="form-control basic_info" placeholder="Type du moteur : 1.2, 1.4, 1,6..." v-model="engine"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.engine" :disabled="true" >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-speed-meter"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                                <label for="-date" class="block">Kilométrage <span class="text-danger">(*)</span></label>
                                <div :class="[errors.kilometrage ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                    <input id="kilometrage" type="number" class="form-control basic_info" placeholder="Kilométrage..." v-model="kilometrage"
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.kilometrage" min="0" :disabled="true" >
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-ui-map"></i>
                                    </span>
                                </div>
                            </div>
                        <div class="form-group col-md-4">
                            <label for="-date" class="block">Numéro de chassis <span class="text-danger">(*)</span></label>
                            <div :class="[errors.identification_number ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input type="text" class="form-control basic_info" placeholder="Numéro de chassis..." v-model="identification_number"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.identification_number" :disabled="true" >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-social-slack"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="-date" class="block">Numéro d'Immatriculation <span class="text-danger">(*)</span></label>
                            <div :class="[errors.licence_plate ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input type="text" class="form-control basic_info" placeholder="Immatriculaton..." v-model="licence_plate"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.licence_plate" :disabled="true" >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-social-slack"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="-date" class="block">Immatriculation ancienne <span class="text-danger">(*)</span></label>
                            <div :class="[errors.old_licence_plate ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input type="text" class="form-control basic_info" placeholder="Immatriculaton Ancienne" v-model="old_licence_plate"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.old_licence_plate" :disabled="true" >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-social-slack"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-5">
                            <label for="-date" class="block">Etat général du Véhicule <span class="text-danger">(*)</span></label>
                            <div :class="[errors.status ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top" :data-original-title="errors.status">
                                <select id="conditions" class="selectpicker show-tick basic_info" title="Etat général..."
                                    data-width="100%" :disabled="true" >
                                    @foreach ($conditions as $condition)
                                    <option value="{{$condition->name}}" v-model="status"> {{$condition->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-checked"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="-date" class="block">Type du véhicule <span class="text-danger">(*)</span></label>
                            <div :class="[errors.vehicle_type_id ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top" :data-original-title="errors.vehicle_type_id">
                                <select id="vehicle-types" class="selectpicker show-tick basic_info" title="Type du véhicule..."
                                    data-width="100%" :disabled="true" >
                                    @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{$vehicleType->id}}" v-model="vehicle_type_id">
                                        {{$vehicleType->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-vehicle-delivery-van"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="-date" class="block">Traqué par GPS <span class="text-danger">(*)</span></label>
                            <div :class="[errors.has_gps_tracker ? 'input-group input-group-danger' : 'input-group input-group-inverse']" >
                                <select id="has_gps_tracker" class="selectpicker show-tick basic_info" title="GPS..." data-width="100%"
                                data-toggle="tooltip" data-placement="top" :data-original-title="errors.has_gps_tracker" :disabled="true"
                               >
                                    <option value="1" v-model="has_gps_tracker"> OUI</option>
                                    <option value="0" v-model="has_gps_tracker"> NON</option>
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-location-pin"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </form>

                <hr>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" :class="[edit_basic_info ? 'btn btn-primary m-r-10' : 'btn btn-disabled disabled m-r-10']"
                             v-on:click="update_vehicle()" >
                                Sauvgarder
                            </button>
                            <button type="submit" class="btn btn-warning" v-on:click="enable_elements('basic_info');edit_basic_info=true">Modifier</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div :class=" [show_edit ? 'col-md-12 animated fadeInRight' : 'col-md-12 animated fadeOutRight'] "  v-show="show_edit" >
        <div class="card" id="edit-insurance-form">
                <div class="card-header">
                        <h6 v-on:click="$('#m2').click()" style="cursor:pointer"><strong>Assurance du véhicule</strong>   </h6>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-plus minimize-card" id="m2"></i></li>
                                <li><i class="feather icon-x close-card"></i></li>
                            </ul>
                        </div>
                    </div>

            <div class="card-block" style="display: none;">
                <strong class="text-danger">Veuillez remplir tous les champs obligatoires (*)</strong>
                <hr>
                <form>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="-date" class="block">Compagnie d'assurance <span class="text-danger">(*)</span></label>
                            <div :class="[errors.insurance_company_id ? ' input-group input-group-danger' : ' input-group input-group-inverse']"
                                data-toggle="tooltip" data-placement="top" :data-original-title="errors.insurance_company_id">
                                <select id="insurance-companies" class="selectpicker show-tick insurance_info" title="Compagnie d'assurance.."
                                    data-width="100%" :disabled="true">
                                    @foreach ($insuranceCompanies as $insuranceCompany)
                                    <option value="{{$insuranceCompany->id}}">{{$insuranceCompany->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-listing-box"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="-date" class="block">Date d'assurance <span class="text-danger">(*)</span></label>
                            <div :class="[errors.insurance_dates ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                                <input id="insurance-dates" type="text" class="form-control insurance_info" placeholder="Date d'assurance..."
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.insurance_dates"
                                    :disabled="true">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="-date" class="block">Numéro du police <span class="text-danger">(*)</span></label>
                            <div :class="[errors.police_number ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                <input type="number" class="form-control insurance_info" placeholder="Numéro du police..." data-toggle="tooltip"
                                :disabled="true" data-placement="top" :data-original-title="errors.police_number" v-model="police_number" min="0">
                                <span class="input-group-addon">
                                    <b class="icofont icofont-police-cap"></b>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="-date" class="block">Coût <span class="text-danger">(*)</span></label>
                            <div :class="[errors.cost ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                <input :disabled="true" type="number" class="form-control insurance_info" placeholder="Coût..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.cost" v-model="cost" min="0">
                                <span class="input-group-addon">
                                    <b class="fa fa-money"></b>
                                </span>
                            </div>
                        </div>

                    </div>
                </form>

                <hr>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" :class="[edit_insurance_info ? 'btn btn-primary m-r-10' : 'btn btn-disabled disabled m-r-10']"
                             v-on:click="update_insurance()" >
                                Sauvgarder
                            </button>
                            <button type="submit" class="btn btn-warning" v-on:click="enable_elements('insurance_info');edit_insurance_info=true">Modifier</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div :class=" [show_edit ? 'col-md-12 animated fadeInRight' : 'col-md-12 animated fadeOutRight'] "  v-show="show_edit" >
        <div class="card" id="edit-affectation-form">
                <div class="card-header">
                        <h6 v-on:click="$('#m3').click()" style="cursor:pointer"><strong>Affectation du véhicule</strong>   </h6>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-plus minimize-card" id="m3"></i></li>
                                <li><i class="feather icon-x close-card"></i></li>
                            </ul>
                        </div>
                    </div>

            <div class="card-block" style="display:none">
                <strong class="text-danger">Veuillez remplir tous les champs obligatoires (*)</strong>
                <hr>
                    <form>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="-date" class="block">Propriétaire du véhicule <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.owner_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.owner_id">
                                    <select id="owners" class="selectpicker show-tick affectation_info" title="Propriétaire du véhicule.."
                                        data-width="100%" :disabled="true">
                                        @foreach ($owners as $owner)
                                        <option value="{{$owner->id}}">{{$owner->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="decision-number" class="block">Numéro du décision d'affectation <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.decision_number ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="decision-number" type="number" class="affectation_info form-control" placeholder="Numéro du décision..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.decision_number"
                                        v-model="decision_number" :disabled="true">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-md-4" >
                                <label for="decision-date" class="block">Date d'affectation <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.assigned_at ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="decision-date" name="birthdate" type="text" class="affectation_info text-center form-control" placeholder="Date d'affectation..."
                                        data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.assigned_at"  :disabled="true">
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-calendar"></i>
                                    </span>
                                </div>
                            </div>

                             <div class="form-group col-md-6"  v-show="edit_affectation_info">
                                <label for="-date" class="block">Décision d'affectation <span class="text-danger">(*) </span></label>
                                <div :class="[errors.uploaded_file ? '  input-group input-group-danger' : ' input-group input-group-inverse']"
                                v-on:click="$('#files').click()" >
                                    <input id="decision-file" name="birthdate" type="text" class="form-control bg-white affectation_info" placeholder="Décison d'affectation scannée..."
                                    data-toggle="tooltip" data-placement="top" :disabled="true"
                                    :data-original-title="errors.uploaded_file" readonly >
                                    <span class="input-group-addon affecation_info" >
                                        <i class="icofont icofont-file-pdf" ></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-md-6"  v-show="!edit_affectation_info">
                                <label for="-date" class="block">Décision d'affectation <span class="text-danger">(*) </span></label>
                                <div>
                                    <a :href="decision_file_path" target="_blank">
                                        <i :class="[decision_file_path == null ? '  icofont icofont-file-pdf f-68 text-default' : 'icofont icofont-file-pdf f-68 text-inverse']" ></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group col-md-6 form-group-danger" style="display:none">
                                <label for="-date" class="block">Décision d'affectation <span class="text-danger">(*) </span></label>
                                <div :class="[errors.uploaded_file ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                                data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.uploaded_file">
                                    <input type="file" id="files" ref="files" name="decision_file"
                                        v-on:change="handleFilesUpload()"  />
                                </div>
                            </div>
                        </div>
                    </form>


                <hr>
                <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" :class="[edit_affectation_info ? 'btn btn-primary m-r-10' : 'btn btn-disabled disabled m-r-10']"
                                 v-on:click="update_affectation()" >
                                    Sauvgarder
                                </button>
                                <button type="submit" class="btn btn-warning" v-on:click="enable_elements('affectation_info');edit_affectation_info=true">Modifier</button>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
    </div>



</div>



@endsection

@section('page_scripts')
<script>
$(document).ready(function() {
    $('#vehicles-table').DataTable({
        dom: 'Bfrtip',
        language: {

        },
        buttons: [{
            extend: 'excelHtml5',
            text: 'EXCEL',
            className: 'btn-inverse ',
            exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }

        }, {

            extend: 'print',
            text: 'IMPRIMER',
            className: 'btn-inverse',
            exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }

        }, {
            extend: 'colvis',
            text: 'AFFICHAGE',
            className: 'btn-inverse',

        }]
    });

    $('#permissions').multiSelect({
                selectableHeader: "<div class='custom-header bg-inverse'>Les permissions disponibles</div>",
                selectionHeader: "<div class='custom-header bg-inverse'>Les permissions sélectionnées</div>",
                selectableOptgroup: true,
                keepOrder: true
            });
            $('#structure-types').select2({
                placeholder: "Type du structure.."
            });
            $('#structures').select2({
                placeholder: "Nom du structure.."
            });
});
</script>

<script>
const app = new Vue({
    el: '#app',
    data() {
        return {
            show_edit :false,
            selected_vehicle_id:'',
            edit_basic_info: false,
            edit_insurance_info: false,
            edit_affectation_info: false,

            brand:'',
            loading: false,
            licence_plate: '',
            old_licence_plate: '',
            status: '',
            has_gps_tracker: '',
            identification_number: '',
            flag: '',
            structure_id: '',
            vehicle_model_id: '',
            vehicle_type_id: '',
            fuel_card_id: '',
            police_number: '',
            kilometrage: '',
            owner_id: '',
            energy_type_id: '',
            insurance_type: '',
            insurance_dates: '',
            started_at: '',
            ended_at: '',
            insurance_company_id: '',
            cost: '',
            decision_number: '',
            decision_date: '',
            decision_file: '',
            decision_file_name: '',
            decision_file_path: '',
            horsepower: '',
            engine: '',
            notifications:[],
            vehicle_id: '',
            number_vehicles : "<?php echo $vehicles->count(); ?>",

            errors: [],
        }
    },
    mounted(){
        this.fetch_notifications();
        $('#decision-date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                "opens": "center",
                "locale": {
                    "format": "DD/MM/YYYY",
                    "daysOfWeek": [
                        "Di",
                        "Lu",
                        "Ma",
                        "Me",
                        "Je",
                        "Ve",
                        "Sa"
                    ],
                    "monthNames": [
                        "Janvier",
                        "Février",
                        "Mars",
                        "Avril",
                        "Peut",
                        "Juin",
                        "Juillet",
                        "Août",
                        "Septembre",
                        "Octobre",
                        "Novembre",
                        "Décembre"
                    ],
                    // "firstDay": 1
                }
            });
            $('#files').filer({
                limit: 1,
                maxSize: 1,
                extensions: ['jpg', 'jpeg', 'png', 'pdf'],
                showThumbs: false,
                addMore: false,
                changeInput: true,
                maxSize: 100,

                captions: {
                    button: "<span class='icofont icofont-file-pdf'> </span>",
                    feedback: "Décision d'affectation scannée...",
                    feedback2: "Fichier sélectionné &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp" +
                        "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",

                    errors: {
                        filesLimit: 'Only ${limit} files are allowed to be uploaded.',
                        filesType: 'Veuillez sélectionner des fichiers de type : PDF, JPG, JPEG, PNG',
                        fileSize: '${name} is too large! Please choose a file up to ${fileMaxSize}MB.',
                        filesSizeAll: 'Files that you chose are too large! Please upload files up to ${maxSize} MB.',
                        fileName: 'File with the name ${name} is already selected.',
                        folderUpload: 'Veuillez sélectionner des fichiers uniquement (pas de dossiers!)'
                    }
                },

            });

            $('#insurance-dates').daterangepicker({
                "autoApply": true,
                "parentEl": "body",
                "opens": "right",
                "drops": "up",
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Ok",
                    "cancelLabel": "Cancel",
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Di",
                        "Lu",
                        "Ma",
                        "Me",
                        "Je",
                        "Ve",
                        "Sa"
                    ],
                    "monthNames": [
                        "Janvier",
                        "Février",
                        "Mars",
                        "Avril",
                        "Peut",
                        "Juin",
                        "Juillet",
                        "Août",
                        "Septembre",
                        "Octobre",
                        "Novembre",
                        "Décembre"
                    ],
                    "firstDay": 1
                },
                "alwaysShowCalendars": true,
            }, function (start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

    },
    methods: {
        fetch_notifications(){
                    var app = this;
                    return axios.get('/getNotifications')
                        .then(function (response) {
                            app.notifications = response.data.notifications;
                            if (app.notifications.length > 0 ) {
                                ion.sound.play("ding_ding", {
                                    loop: 2
                                });
                            }
                        });
                },
        handleFilesUpload() {
                this.decision_file = this.$refs.files.files;
                this.decision_file_name = this.decision_file[0].name;
                $('#decision-file').val(this.decision_file_name);

            },
            block(element) {
                $('#' + element).block({
                    message: '<div class="preloader3 loader-block">' +
                        '<div class="circ1 loader-info"></div>' +
                        '<div class="circ2 loader-info"></div>' +
                        '<div class="circ3 loader-info"></div>' +
                        '<div class="circ4 loader-info"></div>' +
                        '</div>',
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: 0.5,
                        showOverlay: false,
                    }
                });
            },
            unblock(element) {
                $('#' + element).unblock();
            },
        enable_elements(_class) {
            $('.'+_class).removeAttr('disabled');
            $('.selectpicker').selectpicker('refresh');
        },
        disable_elements(_class) {
            $('.'+_class).attr('disabled',true);
            //$('.'+_class).val('');
           // $('.'+_class).selectpicker('val',null);
           // $('.selectpicker').selectpicker('refresh');
        },
        delete_vehicle(id, index) {
            swal({
                    title: "Êtes-vous sûr?",
                    text: "Cette action est irréversible!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Supprimer",
                    cancelButtonText: "Annuler",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        axios.delete('/vehicle_delete/' + id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.vehicles.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');
                                } else if (response.data.success) {
                                    $('#tr_' + index).remove();
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                }
                            });
                    }
                }
            )

        },
        update_vehicle(){
            var app = this;
            app.status = $('#conditions').selectpicker('val');
            app.has_gps_tracker = $('#has_gps_tracker').selectpicker('val');
            app.vehicle_model_id = $('#models').selectpicker('val');
            app.vehicle_type_id = $('#vehicle-types').selectpicker('val');
            app.energy_type_id = $('#energy_types').selectpicker('val');


            app.block('basic-info-form');
            axios.put('/update_vehicle/'+app.selected_vehicle_id,{
            'engine': app.engine,
            'licence_plate': app.licence_plate,
            'old_licence_plate': app.old_licence_plate,
            'status': app.status,
            'has_gps_tracker': app.has_gps_tracker,
            'identification_number': app.identification_number,
            'vehicle_model_id': app.vehicle_model_id,
            'vehicle_type_id': app.vehicle_type_id,
            'kilometrage': app.kilometrage,
            'energy_type_id': app.energy_type_id,
            'horsepower': app.horsepower,
            })

                .then(function (response) {
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.unblock('basic-info-form');
                    console.log(response.data.vehicle);

                        //app.reset_form();

                })
                .catch(function (error) {
                    if (error.response) {
                        app.unblock('basic-info-form');
                        app.$set(app, 'errors', error.response.data.errors);
                        notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'topCenter', 'bounceInDown');
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            },
        update_affectation(){
            var app = this;
            app.status = $('#conditions').selectpicker('val');

            app.owner_id = $('#owners').selectpicker('val');
            app.decision_date = formatDate($('#decision-date').data('daterangepicker').startDate);
            app.decision_file = app.$refs.files.files[0];


            var formData = new FormData();

            formData.append('status', app.status);
            formData.append('kilometrage', app.kilometrage);


            formData.append('owner_id', app.owner_id);
            formData.append('uploaded_file', app.decision_file);
            formData.append('decision_number', app.decision_number);
            formData.append('assigned_at', app.decision_date);
            console.log(app.$refs.files.files[0]);

            app.block('edit-affectation-form');
            axios.post('/add_affectation/'+app.selected_vehicle_id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (response) {
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.unblock('edit-affectation-form');
                    console.log(response.data.affectation);
                    app.decision_file_path = 'storage/'+response.data.affectation.decision_file;
                    app.reset_form();

                })
                .catch(function (error) {
                    if (error.response) {
                        app.unblock('edit-affectation-form');
                        app.$set(app, 'errors', error.response.data.errors);
                        notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'topCenter', 'bounceInDown');
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            },
        update_insurance(){
            var app = this;
            app.insurance_company_id = $('#insurance-companies').selectpicker('val');
            app.started_at = formatDate($('#insurance-dates').data('daterangepicker').startDate);
            app.ended_at = formatDate($('#insurance-dates').data('daterangepicker').endDate);




            app.block('edit-insurance-form');
            axios.put('/add_insurance/'+app.selected_vehicle_id,{
            'started_at': app.started_at,
            'ended_at': app.ended_at,
            'insurrance_company_id': app.insurance_company_id,
            'police_number': app.police_number,
            'cost': app.cost,
                })
                .then(function (response) {
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.unblock('edit-insurance-form');
                    console.log(response.data.vehicle);

                        app.reset_form();

                })
                .catch(function (error) {
                    if (error.response) {
                        app.unblock('edit-insurance-form');
                        app.$set(app, 'errors', error.response.data.errors);
                        notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'topCenter', 'bounceInDown');
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            },
        edit_vehicle(vehicle) {
            // $('#energy_types option').removeAttr("selected");
            // $('#energy_types').selectpicker("refresh");
            $('#energy_types option').prop("selected", false).trigger('change');

            var app = this;
            app.show_edit = true;
            app.reset_form();
            console.log(vehicle);
            app.selected_vehicle_id = vehicle.id;
            $('#conditions').selectpicker('val',vehicle.status);
            $('#has_gps_tracker').selectpicker('val',vehicle.has_gps_tracker);
            $('#brands').selectpicker('val',vehicle.model.brand.name);
            $('#models').selectpicker('val',vehicle.model.id);
            $('#vehicle-types').selectpicker('val',vehicle.vehicle_type_id);
            $('#energy_types').selectpicker('val',vehicle.energy_type_id);
            console.log(vehicle.energy_type_id);
            
            app.horsepower = vehicle.horsepower;
            app.kilometrage = vehicle.kilometrage;
            app.engine = vehicle.engine;
            app.identification_number = vehicle.identification_number;
            app.licence_plate = vehicle.licence_plate;
            app.old_licence_plate = vehicle.old_licence_plate;

            if (vehicle.affectations.length > 0) {
                
            
            app.decision_file_path = 'storage/'+vehicle.affectations[0].decision_file;

            app.decision_number = vehicle.affectations[0].decision_number;
            $('#owners').selectpicker('val',vehicle.owner_id);
            $('#decision-date').data('daterangepicker').setStartDate(reFormatDate(vehicle.affectations[0].assigned_at));
            $('#decision-date').data('daterangepicker').setEndDate(reFormatDate(vehicle.affectations[0].assigned_at));
        }

        if (vehicle.insurances.length > 0) {
            $('#insurance-companies').selectpicker('val',vehicle.insurances[0].insurrance_company_id);
            app.police_number = vehicle.insurances[0].police_number;
            app.cost = vehicle.insurances[0].cost;
            $('#insurance-dates').data('daterangepicker').setStartDate(reFormatDate(vehicle.insurances[0].started_at));
            $('#insurance-dates').data('daterangepicker').setEndDate(reFormatDate(vehicle.insurances[0].ended_at));
        }
            // $('#insurance-dates').data('daterangepicker').startDate);
            // app.ended_at = formatDate($('#insurance-dates').data('daterangepicker').endDate);
            // app.decision_file = app.$refs.files.files[0];


            // let formData = new FormData();
            // formData.append('engine', this.engine);
            // formData.append('licence_plate', this.licence_plate);
            // formData.append('old_licence_plate', this.old_licence_plate);
            // formData.append('status', this.status);
            // formData.append('has_gps_tracker', this.has_gps_tracker);
            // formData.append('identification_number', this.identification_number);
            // formData.append('vehicle_model_id', this.vehicle_model_id);
            // formData.append('vehicle_type_id', this.vehicle_type_id);
            // formData.append('kilometrage', this.kilometrage);
            // formData.append('energy_type_id', this.energy_type_id);
            // formData.append('horsepower', this.horsepower);

            // formData.append('started_at', this.started_at);
            // formData.append('ended_at', this.ended_at);
            // formData.append('insurance_company_id', this.insurance_company_id);
            // formData.append('police_number', this.police_number);
            // formData.append('cost', this.cost);

            // formData.append('owner_id', this.owner_id);
            // formData.append('decision_file', this.decision_file);
            // formData.append('decision_number', this.decision_number);
            // formData.append('decision_date', this.decision_date);

        },

        reset_form(){
            var app = this;
            app.fullname = '';
            app.email = '';
            app.phone = '';
            app.address = '';
            app.vehiclename = '';
            app.password = '';
            app.password_confirmation = '';
            app.structure_id = '';
            app.role_id = '';
            app.permissions = [];
            app.selectedPermissions = '';
            app.vehicle_id = '';

            app.edit_basic_info= false;
            app.edit_insurance_info= false;
            app.edit_affectation_info= false;

            app.disable_elements('affectation_info');
            app.disable_elements('basic_info');
            app.disable_elements('isnurance_info');

            $('#files').val('');



            app.errors = '';

        },
        show_models(brand) {
                //$('#code_wilaya').val('');
                $('#models').find('[label]').attr('disabled',true);
                $('#models').find("[label='"+brand+"']").attr('disabled',false);
                $('#models').selectpicker('refresh');
                },
    },
});

</script>

@endsection
