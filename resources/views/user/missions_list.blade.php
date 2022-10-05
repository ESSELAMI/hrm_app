@extends('layouts.base')

@section('page_title')
<h5>Liste des missions</h5>
<span>Ajouter, modifer ou supprimer une mission </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('missions.index') }}">Liste des missions</a>
</li>
@endsection
{{-- <style>
    .table tbody td {
    vertical-align: middle;
    font-size: 12px
  }
</style> --}}

@include('user.navigation')


@section('page_content')
<div class="row ">

    <div class="modal fade" id="mission-preview" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Impression Ordre Mission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
<div class="col-xl-12 text-center bg-default container">
                <img src="{{asset('images/print/ordre_mission/bg_fr.png')}}" alt="" width="400" height="600" style="
                top: 50%;
                left: 50%;border:1px ;border-style:dashed;border-color:red">
                <strong class="text-dark f-12 " style="position: absolute; 
                top: 50mm; 
                left: 32mm" v-if="(selected_mission)">@{{selected_mission.agent.firstname  }}</strong>
                <strong class="text-dark f-12 " style="position: absolute; 
                top: 56mm; 
                left: 36mm" v-if="(selected_mission)">@{{selected_mission.agent.lastname}}</strong>
                <strong class="text-dark f-12 " style="position: absolute; 
                top: 62mm; 
                left: 47mm" v-if="(selected_mission)">@{{selected_mission.agent.fonction.name}}</strong>
            </div></div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_mission()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_mission()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mission-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="width:120%;margin-left:-10%">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter une mission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row" id="add-mission-form">
                            <div class="form-group col-md-4 m-t-15">
                                <label for="reference" class="block">Réference
                                    {{-- <span class="text-danger">
                                        (*)</span> --}}
                                </label>
                                <div :class="[errors.reference ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.reference">
                                    <input id="reference" type="text" class="form-control " placeholder="Réference..."
                                        data-toggle="tooltip" data-placement="top" v-model='reference'
                                        :data-original-title="errors.reference">
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-8 m-t-15">
                                <label for="-date" class="block">Agent CNAS <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.agent_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.agent_id"
                                    data-live-search="true">
                                    <select id="agents" class="selectpicker show-tick text-center"
                                        title="Sélectionner un agent.." data-width="100%" data-live-search="true"
                                        data-style="btn-default"
                                        data-size="10">
                                        @foreach ($agents as $agent)
                                        <option value="{{$agent->id}}" >
                                            {{ $agent->firstname .' '. $agent->lastname}}</option>
                                        @endforeach

                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-sm-5 ">
                                <label for="-date" class="block">Demande scannée
                                    {{-- <span class="text-danger">(*)
                                    </span> --}}
                                </label>
                                <div :class="[errors.request_scan ? '  input-group input-group-danger' : ' input-group input-group-inverse']"
                                    v-on:click="$('#files').click()">
                                    <input id="request-file" name="requestfile" type="text"
                                        class="form-control bg-white" placeholder="Demande d'ordre de mission..."
                                        data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.request_scan" readonly>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-file-pdf"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-sm-5  form-group-danger" style="display:none">
                                <label for="requestfile" class="block">Demande scannée <span class="text-danger">(*)
                                    </span></label>
                                <div :class="[errors.request_scan ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.request_scan">
                                    <input type="file" id="files" ref="files" name="request_scan"
                                        v-on:change="handleFilesUpload()" />
                                </div>
                            </div>

                            <div class="form-group col-md-4 ">
                                <label for="reason" class="block">Motif <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.reason ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.reason">
                                    <select id="reasons" class="selectpicker show-tick" title="Séléctionner.."
                                        data-width="100%" data-style="btn-default">
                                        @foreach ($reasons as $reason)
                                        <option value="{{$reason->name}}">{{ $reason->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-3 ">
                                <label for="supported" class="block">Prise en charge <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.supported ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.supported">
                                    <select id="supported" class="selectpicker show-tick" title="Séléctionner.."
                                        data-width="100%" data-style="btn-default" v-model="supported">

                                        <option value="0">SANS</option>
                                        <option value="1">AVEC</option>

                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-5 ">
                                <label for="source_id" class="block">Résidence administrative <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.source_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.source_id"
                                    data-live-search="true">
                                    <select id="source" class="selectpicker show-tick text-center"
                                        title="Lieu de départ..." data-width="100%" data-style="btn-default"
                                        data-live-search="true">
                                        @foreach ($places as $place)
                                        <option value="{{$place->id}}">{{ $place->name . ' - '.$place->state->name}}</option>
                                        @endforeach

                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 ">
                                <label for="started_at" class="block">Date départ<span class="text-danger">
                                        (*)</span></label>
                                <div
                                    :class="[errors.started_at ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="started_at" type="text" class="form-control date text-center"
                                        placeholder="Date départ..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.started_at">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="started_time" class="block">Heure départ<span class="text-danger">
                                        (*)</span></label>
                                <div
                                    :class="[errors.started_time ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <div class='input-group'>
                                        <input class="form-control text-center "  type="time" id="started_time" v-model="started_time">
                                        <span class="input-group-addon ">
                                            <span class="icofont icofont-ui-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-5 ">
                                <label for="destinations" class="block">Destination <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.destinations ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.destinations" data-live-search="true">
                                    <select id="destinations" class="selectpicker show-tick text-center"
                                        title="Se rendre à..." data-width="100%" multiple v-model='destinations'
                                        data-live-search="true" data-style="btn-default">
                                        @foreach ($places as $place)
                                        <option value="{{$place->id}}" title="{{$place->name}}">{{ $place->name . ' - '.$place->state->name}}</option>
                                        @endforeach

                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 ">
                                <label for="ended_at" class="block">Date retour<span class="text-danger">
                                        (*)</span></label>
                                <div
                                    :class="[errors.ended_at ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="ended_at" type="text" class="form-control date text-center"
                                        placeholder="Date retour..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.ended_at">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ended_time" class="block">Heure retour<span class="text-danger">
                                        (*)</span></label>
                                <div
                                    :class="[errors.ended_time ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <div class='input-group'>
                                        <input class="form-control text-center " type="time" id="ended_time" v-model="ended_time" >
                                        <span class="input-group-addon ">
                                            <span class="icofont icofont-ui-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="tronsportation" class="block">Moyen de transport <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.tronsportation ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.tronsportation">
                                    <select id="transportation" class="selectpicker show-tick text-center"
                                        title="Moyen de transport..." data-width="100%" v-model="trsp"
                                        v-on:change="getDriverName()" data-style="btn-default">
                                        <option value="VS">VEHICULE SERVICE</option>
                                        <option value="VP">VEHICULE PERSONNEL</option>
                                        <option value="AU">AUTRE MOYEN</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 " v-show="trsp == 'VP' || trsp == 'VS'">
                                <label for="-date" class="block">Chauffeur <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.driver_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.driver_id"
                                    data-live-search="true">
                                    <select id="drivers" class="selectpicker show-tick text-center"
                                        title="Sélectionner un agent.." data-width="100%" data-live-search="true"
                                        data-style="btn-default"
                                        v-on:change="agent_vehicle_licence_number = $('#drivers option:selected').attr('agent_vehicle_licence_number_')">
                                        @foreach ($agents as $agent)
                                        <option value="{{$agent->id}}" agent_vehicle_licence_number_="{{ $agent->vehicle_licence_number}}" >
                                {{ $agent->firstname .' '. $agent->lastname  }}</option>
                                        
                                        @endforeach

                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 " v-if="trsp == 'VP' ">
                                <label for="Immatriculation" class="block">Immatriculation<span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.Immatriculation ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.Immatriculation">
                                    <input id="vp_licence" type="text" class="form-control "
                                        placeholder="Immatriculation..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.Immatriculation" v-model="agent_vehicle_licence_number">
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 " v-show="trsp == 'VS'">
                                <label for="Immatriculation_" class="block">Immatriculation <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.licence_number ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.licence_number" data-live-search="true">
                                    <select id="vehicles" class="selectpicker show-tick text-center"
                                        title="Sélectionner un vehicule.." data-width="100%" data-live-search="true"
                                        data-style="btn-default" v-model="agency_vehicle_licence_number">
                                        <option value="00858-111-14" >RENAULT - FLUENCE - 00858-111-14</option>
                                        <option value="03354-313-14" >RENAULT - KANGOO - 03354-313-14</option>
                                        <option value="00282-104-14" >TOYOTA - COROLLA - 00282-104-14</option>
                                        <option value="05516-314-14" >ISUZU - ISUZU - 05516-314-14</option>
                                        <option value="02071-117-14" >HYUNDAI - ELANTRA - 02071-117-14</option>
                                        <option value="00837-111-14" >RENAULT - KANGOO - 00837-111-14</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-sm-6 ">
                                <label for="-date" class="block">Rapport scannée<span class="text-danger">(*)
                                    </span></label>
                                <div :class="[errors.report_scan ? '  input-group input-group-danger' : ' input-group input-group-inverse']"
                                    v-on:click="$('#files_').click()">
                                    <input id="report-file" name="raportfile" type="text" class="form-control bg-white"
                                        placeholder="Rapport de mission..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.report_scan" readonly>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-file-pdf"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-sm-6  form-group-danger" style="display:none">
                                <label for="raportfile" class="block">Rapport scannée <span class="text-danger">(*)
                                    </span></label>
                                <div :class="[errors.report_scan ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.report_scan">
                                    <input type="file" id="files_" ref="files_" name="report_scan"
                                        v-on:change="handleFiles_Upload()" />
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_mission()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_mission()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>


    <!-- right column start -->
    <div class="col-lg-12 col-xl-12">
        <!-- Filter card start -->
        <div class="card">
            <div class="card-header">
                <h5><i class="icofont icofont-filter m-r-5"></i>Recherche détaillé</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span>
                                <i class="fa fa-refresh faa-spin animated text-warning " data-toggle="tooltip"
                                    data-placement="top" data-original-title="Actualiser" style="font-size:18px"
                                    id="refresh">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">

                <form class="row" action="#">
                    <div class="form-group col-sm-3 ">
                        {{-- <label for="drivers" class="block">Agent CNAS</label> --}}
                        <div class="input-group input-group-inverse">
                            <select id="f-agents" class="selectpicker show-tick text-center"
                                title="Sélectionner un agent CNAS.." data-width="100%" data-style="btn-default" data-size="5">


                            </select>

                            <span class="input-group-addon">
                                <i class="icofont icofont-user"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        {{-- <label for="demo" class="block">Date</label> --}}
                        <div class="input-group input-group-inverse">
                            <input type="text" id="demo" class="form-control" style="height:41px">
                            <span class="input-group-addon">
                                <i class="icofont icofont-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        {{-- <label for="drivers" class="block">Agent CNAS</label> --}}
                        <div class="input-group input-group-inverse">
                            <select id="f-reasons" class="selectpicker show-tick text-center"
                                title="Sélectionner un motif.." data-width="100%" data-style="btn-default">


                            </select>

                            <span class="input-group-addon">
                                <i class="icofont icofont-list"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        {{-- <label for="drivers" class="block">Agent CNAS</label> --}}
                        <div class="input-group input-group-inverse">
                            <select id="f-status" class="selectpicker show-tick text-center"
                                title="Sélectionner l'état.." data-width="100%" data-style="btn-default">


                            </select>

                            <span class="input-group-addon">
                                <i class="icofont icofont-checked"></i>
                            </span>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- Filter card end -->



    </div>
    <!-- right column end -->

    <div class="col-lg-12 col-xl-12 col-md-12">
        <!-- Job description card start -->
        <div class="card " style="overflow-x:hidden;">
            <div class="card-header table-card-header">
                <h5><i class="icofont icofont-list m-r-5"></i>Liste des missions</h5> 
                {{-- added this just to push my project to the cloud... --}}
                <div class="card-header-right">
                    <ul class="list-unstyled card-option" >
                        <li v-on:click="calculate_fees_for_all();
                        ">
                            <span >
                                <i class="fa fa-trash faa-vertical animated text-danger " data-toggle="tooltip"
                                    data-placement="top" data-original-title="Supprimer tous" style="font-size:22px"
                                    v-on:click="delete_all();
                                    ">
                                </i>
                            </span>
                        </li>
                        <li v-on:click="operation='add';
                        clearInputs();
                        $('#reasons').selectpicker('val','TRAVAIL');
                                    $('#supported').selectpicker('val','0');">
                            <span data-toggle="modal" data-target="#mission-modal">
                                <i class="fa fa-plus faa-horizontal animated text-success " data-toggle="tooltip"
                                    data-placement="top" data-original-title="Ajouter une mission" style="font-size:22px"
                                    v-on:click="operation='add';
                                    clearInputs();
                                    $('#reasons').selectpicker('val','TRAVAIL');
                                    $('#supported').selectpicker('val','0');
                                    ">
                                </i>
                            </span>
                        </li>

                        
                    </ul>
                </div>
            </div>

            <div class="card-block ">
                <div class="dt-responsive table-responsive ">
                    <table id="missions-table" class="table table-bordered dataex-colvis-exclude "
                        style="width:100%;font-size:12px;">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center noExport">ACTION</th>
                                <th class="text-center">ETAT</th>
                                <th class="text-center ">CODE AGENT</th>
                                <th class="text-center ">NOM AGENT</th>
                                {{-- <th class="text-center">DEMANDE</th> --}}
                                <th class="text-center">LIEU DEPART</th>
                                <th class="text-center">DATE DEPART</th>
                                <th class="text-center" style="white-space:normal;width:100px">DESTINATION</th>
                                <th class="text-center">DATE ARRIVE</th>
                                <th class="text-center">MONTANT</th>
                                <th class="text-center">TRANSPORT</th>
                                <th class="text-center">CHAUFFEUR</th>
                                <th class="text-center">MOTIF</th>

                                <th class="text-center">PRISE EN CHARGE</th>

                                {{-- <th class="text-center">CHAUFFEUR</th> --}}
                                {{-- <th class="text-center">RAPPORT</th> --}}
                                {{-- <th class="text-center">DECOMPTE</th> --}}
                                {{-- <th class="text-center">MECANICIEN</th>
                                    <th class="text-center">TYPE D'ENTRETIENS</th>--}}
                                {{-- <th class="text-center noExport">ACTION</th> --}}
                            </tr>
                        </thead>
                        <tbody class="">
                            <tr v-for="(mission, index) in missions">
                                <td style="width:20px"></td>
                                <td class="text-center ">
                                    <div class="dropdown-secondary dropdown ">
                                        <button
                                            class="btn btn-inverse btn-mini dropdown-toggle waves-light b-none txt-muted "
                                            type="button" id="dropdown11" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"><i class="icofont icofont-options f-16"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdown11"
                                            data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"
                                            x-placement="top-start"
                                            style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a data-toggle="modal" data-target="#mission-modal"
                                                class="dropdown-item waves-light waves-effect clickable"
                                                v-on:click="edit_mission(mission,index)"><i
                                                    class="icofont icofont-ui-edit f-18"></i> Modifier</a>
                                            {{-- <a class="dropdown-item waves-light waves-effect clickable" v-on:click="print_mission_fr(mission)"><i --}}
                                            <a class="dropdown-item waves-light waves-effect clickable" v-on:click="print_mission_fr(mission)"
                                            {{-- data-toggle="modal" data-target="#mission-preview"><i --}}
                                            ><i
                                                    class="icofont icofont-print f-18"></i> Ordre de mission</a>
                                            <a class="dropdown-item waves-light waves-effect clickable" v-on:click="calculate_fees(mission);"><i
                                                    class="icofont icofont-ui-calculator f-18"></i> Decompte</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-light waves-effect clickable text-danger"
                                                v-on:click="delete_mission(mission.id,index)"><i
                                                    class="feather icon-trash text-danger f-18"></i> Supprimer</a>
                                        </div>
                                        <!-- end of dropdown menu -->
                                    </div>
                                </td>
                                <td class="text-center f-14" style="vertical-align:middle" > 
                                    <span v-if=" mission.status  == 'DEPOSE'" class="label label-warning">@{{ mission.status.toString() }}</span>
                                
                                   
                                    <span class="label label-info" v-else-if=" mission.status  == 'CALCULE'">@{{ mission.status.toString() }}</span>
                                
                                    
                                    <span class="label label-success" v-else=" mission.status  == 'PAYE'">
                                         @{{ mission.status.toString() }} </span>
                                        </td>
                                <td class="text-center " style="width:auto;vertical-align:middle">
                                    @{{ mission.agent.agent_number}}
                                    
                                </td>
                                <td class="text-center " style="width:auto;vertical-align:middle">
                                    @{{ mission.agent.firstname.toUpperCase() + ' ' +mission.agent.lastname.toUpperCase()}}
                                    
                                </td>

                                {{-- <td class="text-center" v-if="mission.request_scan"><a
                                            :href="'storage/'+mission.request_scan" target="_blank"
                                            class="text-warning f-17">
                                            <i
                                                :class="[mission.request_scan == null ? '  icofont icofont-file-pdf  text-default' : 'icofont icofont-file-pdf text-success f-20']"></i>
                                        </a> </td> --}}
                                {{-- <td class="text-center" v-else></td> --}}
                                <td class="text-center " style="vertical-align:middle">@{{ mission.source.name }}</td>
                                <td class="text-center " style="vertical-align:middle">
                                    @{{ reFormatDate(mission.started_at) + ' - ' + reFormatTime(mission.started_time) }}
                                </td>
                                <td class="" style="white-space:normal;width:100px">
                                    @{{ mission.destinations.map(d =>d.name).toString() }}</td>
                                <td class="text-center " style="vertical-align:middle">
                                    @{{ reFormatDate(mission.ended_at) + ' - ' + reFormatTime(mission.ended_time) }}
                                </td>
                                <td class="text-center " style="vertical-align:middle" v-if="mission.total!=null">@{{ mission.total.toFixed(2) }}</td>
                                <td class="text-center " style="vertical-align:middle" v-else>@{{ mission.total }}</td>
                                <td class="text-center " style="vertical-align:middle">@{{ mission.transportation }}
                                </td>
                                <td v-if="mission.driver!=null" class="text-center " style="vertical-align:middle">@{{ mission.driver.firstname + ' '+mission.driver.lastname  }}</td>
                                <td v-else class="text-center " style="vertical-align:middle"></td>
                                <td class="text-center " style="vertical-align:middle">@{{ mission.reason }}</td>

                                <td class="text-center " v-if="mission.supported" style="vertical-align:middle"><i
                                        class="icofont icofont-ui-check text-success"></i>
                                    <p style="display:none">Oui</p>
                                </td>
                                <td class="text-center " style="vertical-align:middle" v-else><i
                                        class="icofont icofont-ui-close text-danger"></i>
                                    <p style="display:none">Non</p>
                                </td>

                                {{-- <td class="text-center" style="width:100px">@{{ mission.driver_name }}</td> --}}
                                {{-- <td class="text-center" v-if="mission.report_scan"><a
                                            :href="'storage/'+mission.report_scan" target="_blank"
                                            class="text-warning f-17">
                                            <i
                                                :class="[mission.report_scan == null ? '  icofont icofont-file-pdf  text-default' : 'icofont icofont-file-pdf text-success f-20']"></i>
                                        </a> </td> --}}

                                {{-- // <td class="text-center" style="width:100px">@{{ mission.mechanic.fullname.toUpperCase() }}
                                </td> --}}
                                {{-- // <td class="text-left" style="width:100px;white-space:normal;" >@{{ mission.details.toUpperCase() }}
                                </td> --}}
                                {{-- <td class="text-center" style="width:200px">@{{ mission.cost }}</td> --}}
                                {{-- <td style="width:70px">
                                        <div class="text-center">
                                            <span data-toggle="modal" data-target="#mission-modal"
                                                v-on:click="edit_mission(mission,index)">
                                                <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="Modifier">
                                                </i>
                                            </span>
                                            <i class="feather icon-trash text-danger f-18 clickable"
                                                v-on:click="delete_mission(mission.id,index)" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Supprimer">
                                            </i>
                                        </div>
                                    </td> --}}
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                               
                                <th colspan="1"></th>
                                <th colspan="8"></th>
                               
                                <th colspan="1"></th>
                                <th colspan="4"></th>
                                


                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <button v-on:click="qrcode_generator()"> click me </button>
    <img id='itf' style="display: none" />
   

</div>


@endsection

@section('page_scripts')


<script>
    document.onkeydown = keydown;

function keydown(evt){
  if (!evt) evt = event;
  if (evt.ctrlKey && evt.keyCode==86){ //CTRL+ALT+F4
    alert("CTRL+ALT+F4"); 
  }
 
}
    const app = new Vue({
        el: '#app',
        data() {
            return {
                operation: '',
                selected_mission:'',
                supported:'',
                reference: '',
                report_scan: '',
                agent_name: '',
                driver_name: '',
                report_url: '',
                request_scan: '',
                request_scan_name: '',
                request_url: '',
                cost: '',
                started_at: '',
                agent_id: '',
                started_time: '',
                ended_time: '',
                transportation: '',
                agent_vehicle_licence_number: '',
                agency_vehicle_licence_number: '',
                licence_number: '',
                source_id: '',
                destinations: '',
                modal_title: '',
                selectedMissionId: '',
                selectedMissionIndex: '',
                notifications: [],
                notifications_fetched: false,
                reason: [],
                mechanics: [],
                missionTypes: [],
                missions: [],
                maxDistance : 0,
                km_fees : 0, // (0, 3, 12)
                travel_allowances:[],
                food_allowances:[],
                km_total:0,
                food_total : 0,
                meals : 0,
                nights : 0,
                total  : 0,
                trsp  : '',
                trnsp  : '',
                dates : [],
                nights_total : 0,
                lunch_total : 0,
                km_top_position : 0,
                errors: [],
            }
        },

        mounted() {
            
            
            $(document).ready(function () {
                $(document).ready(function(){
                $(".date").inputmask("99/99/9999",{ "placeholder": "*" });
                });
                $('#refresh').on('click', function () {
                    $('#demo').data('daterangepicker').setStartDate('01/01/1900')
                    $('#demo').data('daterangepicker').setEndDate(new Date())
                    $('#demo').val("");
                    $("#missions-table").DataTable().search("").draw();
                    $('#f-agents').selectpicker('val', null);
                    $('#f-reasons').selectpicker('val', null);
                     $('#f-status').selectpicker('val',null);
                });
                $('#demo').on('cancel.daterangepicker', function (ev, picker) {
                    $('#demo').data('daterangepicker').setStartDate('01/01/1900')
                    $('#demo').data('daterangepicker').setEndDate(new Date())
                    $('#demo').val("");
                });
                $('#demo').on("change", function () {


                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {

                            var min = new Date($('#demo').data('daterangepicker').startDate
                                .format('YYYY-MM-DD'));
                            var max = new Date($('#demo').data('daterangepicker').endDate
                                .format('YYYY-MM-DD'));
                            min = moment(min).format('YYYY-MM-DD');
                            max = moment(max).format('YYYY-MM-DD');
                            app.filterFrom = min;
                            app.filterTo = max;
                            // var max = $('#max').datepicker("getDate");
                            var d = data[5];
                            console.log(d);

                            d = d.split(' - ');
                            d = d[0].split('/');
                            console.log(d);

                            var start = [d[2], d[1], d[0]].join('-');
                            start = moment(new Date(start)).format('YYYY-MM-DD');

                            console.log(moment(min).format('YYYY-MM-DD'));
                            console.log(max);
                            console.log(start);

                            if (start <= app.filterTo && start >= app.filterFrom) {
                                return true;
                            }
                            return false;

                        }
                    );
                    $('#missions-table').DataTable().draw();

                });
            });
            $('#demo').daterangepicker({
                "autoApply": true,
                "locale": {
                    "applyLabel": "Filtrer",
                    "cancelLabel": "Annuler",
                    "fromLabel": "Du",
                    "toLabel": "Au",
                    "customRangeLabel": "Filtrage personnalisé",
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
                        "Mai",
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
                ranges: {
                    "Aujourd'hui": [moment(), moment()],
                    'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 derniers jours': [moment().subtract(6, 'days'), moment()],
                    '30 Derniers jours': [moment().subtract(29, 'days'), moment()],
                    'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                    'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment()
                        .subtract(1, 'month').endOf('month')
                    ]
                },
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
                    feedback: "Demande d'ordre de mission...",
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
            $('#files_').filer({
                limit: 1,
                maxSize: 1,
                extensions: ['jpg', 'jpeg', 'png', 'pdf'],
                showThumbs: false,
                addMore: false,
                changeInput: true,
                maxSize: 100,

                captions: {
                    button: "<span class='icofont icofont-file-pdf'> </span>",
                    feedback: "Rapport de mission...",
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
            
            this.fill_table('/getMissions', 'missions-table');

            $('.date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                "timePicker": false,
                "parentEl": "#mission-modal",
                "opens": "right",
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
                        "Mai",
                        "Juin",
                        "Juillet",
                        "Août",
                        "Septembre",
                        "Octobre",
                        "Novembre",
                        "Décembre"
                    ],
                    "firstDay": 1
                }
            });
            //  this.fetch_notifications();
        },
        methods: {
            qrcode_generator(){
                JsBarcode("#itf", "12345678901237", {format: "itf"});

                const img = document.querySelector('img#itf');

                var doc = new jsPDF();
                doc.setFontSize(40);
                
                doc.addImage(img.src, 'JPEG', 15, 40, 100, 50);
                 doc.save('my.pdf');
            }
            ,
            get_max_distance(source_id,destinations_ids){

            },
            calculate_fees(mission){ //check error when more than 1 day (number of meals...)
                // console.log(mission.destinations.map(d =>d.id));
                var app = this;
                if (mission.started_time && mission.ended_time && mission.started_at
                && mission.ended_at && mission.transportation && mission.reason && mission.source
                && mission.destinations) {
                    app.maxDistance = 0;
                    app.km_fees = 0; // (0, 3, 12)
                    app.travel_allowances;
                    app.food_allowances;
                    app.km_total=0;
                    app.food_total = 0;
                    app.meals = 0;
                    app.nights = 0;
                    app.total  = 0;
                    app.dates = [];
                    app.nights_total = 0;
                    app.lunch_total = 0;
                    app.km_top_position = 0;
                    var supported_meals = 0;

                    
                    switch (mission.transportation.slice(0, 2)) {
                        case 'AU':
                           app.km_fees = 3;
                           km_top_position = 126;
                            break;
                        case 'VS':
                           app.km_fees = 0;
                           km_top_position = 103;
                            break;
                        case 'VP':
                           app.km_fees =12;
                           km_top_position = 103;
                            break;
                    }


                    axios.post('/getDistances/',{
                        'source_id' : mission.source_id,
                        'destinations_ids' :mission.destinations.map(d =>d.id),
                        'grade_id' : mission.agent.fonction.grade_id
                        }
                    ).then(function (response) {
                        if (response.data.error) {
                            // app.missions.splice(index,1)
                            notify('Erreur', response.data.error, 'red', 'topCenter',
                                'bounceInDown');

                        } else {
                            console.log('distances',response.data.distances);
                            
                            app.maxDistance = Math.max(...response.data.distances);
                            app.travel_allowances = response.data.travel_allowances.map(d =>d.cost);
                            app.food_allowance_intervals = response.data.food_allowances.map(d =>[d.starts_at,d.ends_at]);
                        //    console.log(food_allowances);
                           
                             console.log(app.travel_allowances);
                             console.log(app.food_allowance_intervals);
                            // console.log(maxDistance);
                            // console.log(maxDistance);
                    
                    if(app.maxDistance < 30){
                       app.total = 0;
                    } else if(app.maxDistance >= 30 && app.maxDistance < 50){
                        app.food_total = 0;
                        app.km_total = (app.maxDistance * app.km_fees) * 2;
                        app.total = app.km_total + app.food_total;
                    //    console.log(total);
                       
                    }else if(app.maxDistance >= 50){
                        app.dates = getDates(mission.started_at,mission.ended_at);
                        // meals = dates.length *2;
                        // nights = dates.length;
                        app.km_total = (app.maxDistance * app.km_fees) * 2;
                        // food total
                        
                        if (app.dates.length < 2) {// same day
                        let timeSegments = [];
                        timeSegments.push([mission.started_time, mission.ended_time]);
                        timeSegments.push(app.food_allowance_intervals[0]);
                        console.log( overlap(timeSegments) ); // true
                        ( overlap(timeSegments) ? app.meals += 1 : app.meals +=0);

                        timeSegments = [];
                        timeSegments.push([mission.started_time, mission.ended_time]);
                        timeSegments.push(app.food_allowance_intervals[1]);
                        console.log( overlap(timeSegments) ); // true
                        ( overlap(timeSegments) ? app.meals += 1 : app.meals +=0);

                        // timeSegments = [];
                        // timeSegments.push([mission.started_time, mission.ended_time]);
                        // timeSegments.push(food_allowance_intervals[2]);
                        // console.log( overlap(timeSegments) ); // true
                        // ( overlap(timeSegments) ? nights += 1 : nights +=0);
                        
                        }
                        else {//more than 1 day
                       console.log(mission.started_time, app.food_allowance_intervals[1][1],mission.started_time <= app.food_allowance_intervals[1][1]);
                       
                        var da = [];
                        da.push(app.dates[0],app.dates[app.dates.length-1]);
                       
                        if(mission.started_time < app.food_allowance_intervals[0][1]) {
                            console.log('app.food_allowance_intervals[0][1] ==> ' + app.food_allowance_intervals[0][1]);
                            app.meals += 2; 
                            if(mission.supported == '1') supported_meals +=1;
                        }
                        // else  if (mission.started_time <= food_allowance_intervals[1][0]){
                        //     meals += 1; 
                           
                        // } 
                        else  if (mission.started_time < app.food_allowance_intervals[1][1]){
                            app.meals += 1; 
                            if(mission.supported == '1') supported_meals +=0;
                        } 

                        console.log('meals of start',app.meals);
                        var end_meals = 0;
                        var start_meals = app.meals;
                        if(mission.ended_time <= app.food_allowance_intervals[0][0]){ // <= 11:00
                            app.meals += 0; 
                        }else if(mission.ended_time <= app.food_allowance_intervals[1][0]){ // <= 18:00
                            app.meals += 1; 
                            end_meals +=1;
                            if(mission.supported == '1') supported_meals +=1;
                        }else if(moment(app.food_allowance_intervals[2][0],'HH:mm').diff(moment(mission.ended_time,'HH:mm')) < 0 ){ // <= 00:00
                            app.meals += 2; 
                            end_meals +=2;
                            if(mission.supported == '1') supported_meals +=1;
                        }
                        console.log('meals of end',end_meals);
                        app.nights+= (app.dates.length -2) +1;

                        

                        

                        // console.log('meals of start and end',meals);
                        
                        app.meals += (app.dates.length -2)*2;
                        if(mission.supported == '1') supported_meals += (app.dates.length -2)*2;

                       
                        }
                        
                        if(mission.supported == '1'){
                            console.log('app_meals ==> ' + app.meals);
                            console.log('supported_meals ==> ' + supported_meals);
                            app.meals = app.meals - supported_meals;
                            console.log(app.meals);
                            app.nights = 0;
                        }
                        app.food_total = (app.meals * app.travel_allowances[0]) + (app.nights * app.travel_allowances[2]);
                       
                        app.km_total = (app.maxDistance * app.km_fees) * 2;    
                       
                        app.total = app.food_total+app.km_total;
                        console.log('number of meals', app.meals);
                        console.log('number of nights',app.nights);
                        app.nights_total = app.nights * app.travel_allowances[2];
                        app.lunch_total = app.meals * app.travel_allowances[0];
                        console.log( 'food total' ,app.food_total);
                        console.log( 'km total' ,app.km_total);
                        console.log( 'TOTAL' ,app.total);

                    }
                    console.log('number of meals', app.meals);
                        console.log('number of nights',app.nights);
                        
                        console.log( 'food total' ,app.food_total);
                        console.log( 'km total' ,app.km_total);
                        console.log( 'TOTAL' ,app.total);   
                        }



                        axios.put('/updateDecompte/' + mission.id, 
                {
                'total': app.total.toFixed(2),
                'status': 'CALCULE'
               
                // 'status': 'DEPOSE',
            }
                    )
                    .then(function (response) {

                        
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                        app.fill_table('/getMissions', 'missions-table');

                    })
                    .catch(function (error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                            notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red',
                                'topCenter', 'bounceInDown');
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
                    swal({
                        title: "Impression du decompte?",
                        text: "Voulez-vous imprimer ce decompte!",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Imprimer",
                        cancelButtonText: "Annuler",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            app.print_decompte_fr(mission);
                                    
            
                                    }
                                    
                                    
                                });
                       
                    
                                  
                        
                    });
                    
                }else{
                    notify('Erreurs!', 'Veuillez assurer que toutes les informations sont introduites', 'red',
                                'topCenter', 'bounceInDown');
                }
            },
            print_decompte_fr(mission){
                var doc = new jsPDF();
                        // var doc = new jsPDF("p", "mm", "a4");
                        new jsPDF('p', 'mm', [210, 133]);

                        doc.setFont("courier");
                        doc.setFontType("normal");
                        // doc.setFont("wwDigital");
                        doc.setFontSize(10);
                        doc.setFontType("bold");
                        doc.text('AIN DEFLA', 62.5, 14.3);
                        doc.text('SIEGE', 82, 21.2);
                        doc.text('REFERENCE          /2022', 48.5, 27);
                        doc.text(mission.agent.firstname + ' ' +mission.agent.lastname , 92, 42);
                        doc.text(mission.agent.fonction.name.toUpperCase(), 62, 48);
                        doc.text(mission.source.name.toUpperCase(), 87, 54);
                        doc.text(mission.reason.toUpperCase(), 82, 60);
                        doc.text(mission.destinations.map(d =>d.name).toString().toUpperCase(), 81, 66);
                        doc.text(reFormatDate(mission.started_at) +'    à    '+reFormatTime(mission.started_time) , 85, 72);
                        doc.text(reFormatDate(mission.ended_at) +'    à    '+reFormatTime(mission.ended_time) , 85, 78);
                        doc.text(mission.transportation, 92, 84);

                        doc.text(app.travel_allowances[2].toString(), 115, 121);
                        doc.text(app.nights.toString(), 135, 121);
                        doc.text(app.nights_total.toFixed(2).toString(), 151, 121);

                        doc.text(app.travel_allowances[0].toString(), 115, 132);
                        doc.text(app.meals.toString(), 135, 132);
                        doc.text(app.lunch_total.toFixed(2).toString(), 151, 132);

                        doc.text(app.maxDistance.toString() + '(km) X '+app.km_fees.toString() +'(da)' , 56, km_top_position);
                        doc.text(app.km_total.toFixed(2).toString(), 90, km_top_position);
                        doc.setFontSize(11);
                        doc.setFontType("bold");
                        doc.text(app.food_total.toFixed(2).toString(), 143, 149);
                        doc.text(app.km_total.toFixed(2).toString(), 80, 149);
                        doc.setFontSize(11.5);
                        doc.setFontType("bold");
                        doc.text(app.total.toFixed(2).toString(), 112, 158);


                        doc.setFontSize(10);
                        doc.setFontType("bold");
                        console.log(app.total);
                        
                        doc.text(ConvNumberLetter(app.total,0,0).toUpperCase() + 'DA ET ZERO CTS', 45, 172);
                        doc.text('AIN DEFLA', 110, 195);
                        doc.text(reFormatDate(new Date()), 144, 195);

                        doc.autoPrint();
                        window.open(doc.output('bloburl'), '_blank');
            },
            print_mission_fr(mission){
                
                this.selected_mission = mission;
            var doc = new jsPDF();
            JsBarcode("#itf", "12345678901237", {format: "codabar",displayValue: false});

                const img = document.querySelector('img#itf');

               
              
                
                // doc.addImage(img.src, 'JPEG', 140, 12, 40, 10);
                
            new jsPDF('p', 'mm', [210, 133]);
            doc.setFontSize(9);
            doc.setFontType("bold");
            doc.text('AGENCE AIN DEFLA', 42, 12);
            doc.text('REFERENCE                 /2022', 42, 20);
            doc.text(mission.agent.firstname, 68.5, 70.5);
            doc.text(mission.agent.lastname, 73, 78);
            doc.text( mission.agent.fonction.name, 87.5, 85.5);
            doc.text(mission.source.name, 99, 93);
            
            doc.text(mission.destinations.map(d =>d.name).toString(), 78.5, 108.5);
            doc.text(mission.reason, 68, 116);
            // doc.text(mission.agent.fullname, 65, 123); 
            doc.text(reFormatDate(mission.started_at), 88, 131);
            doc.text(reFormatDate(mission.ended_at), 88.2, 137.8);
            doc.text(mission.transportation, 101, 146);
            // doc.text(mission.agent.transportation, 65, 154);
           if (mission.driver) {
            doc.text(mission.driver.firstname + ' '+ mission.driver.lastname , 108, 161.5);
           } 
            // doc.text(mission.agent.fullname, 65, 169);
            doc.text('AIN DEFLA', 98, 176.5);
            doc.text(reFormatDate(new Date()), 126, 176.5);
            // var imgData = 'data:image/png;base64,"images/bg.png";
            // var imgData = 'images/bg.png';
            // doc.addImage(imgData, 'PNG', 15, 40, 180, 160)
            //  doc.save('Test.pdf');
             doc.autoPrint();
             window.open(doc.output('bloburl'), '_blank');
            // window.open(doc.output('bloburl'))
            },

calculate_fees_for_all() {

var app = this;
var missions_ = [];
app.missions.map(function(mission) {
        
    if (mission.started_time && mission.ended_time && mission.started_at &&
        mission.ended_at && mission.transportation && mission.reason && mission.source &&
        mission.destinations) {
        app.maxDistance = 0;
        app.km_fees = 0; // (0, 3, 12)
        app.travel_allowances;
        app.food_allowances;
        app.km_total = 0;
        app.food_total = 0;
        app.meals = 0;
        app.nights = 0;
        app.total = 0;
        app.dates = [];
        app.nights_total = 0;
        app.lunch_total = 0;
        app.km_top_position = 0;



        switch (mission.transportation.slice(0, 2)) {
            case 'AU':
                app.km_fees = 3;
                km_top_position = 126;
                break;
            case 'VS':
                app.km_fees = 0;
                km_top_position = 103;
                break;
            case 'VP':
                app.km_fees = 12;
                km_top_position = 103;
                break;
        }


        axios.post('/getDistances/', {
            'source_id': mission.source_id,
            'destinations_ids': mission.destinations.map(d => d.id),
            'grade_id': mission.agent.fonction.grade_id
        }).then(function (response) {
                if (response.data.error) {
                    // app.missions.splice(index,1)
                    notify('Erreur', response.data.error, 'red', 'topCenter',
                        'bounceInDown');

                } else {
                    console.log('distances', response.data.distances);

                    app.maxDistance = Math.max(...response.data.distances);

                    app.travel_allowances = response.data.travel_allowances.map(d => d.cost);
                    app.food_allowance_intervals = response.data.food_allowances.map(d => [d.starts_at, d.ends_at]);
                    //    console.log(food_allowances);

                    console.log(app.travel_allowances);
                    console.log(app.food_allowance_intervals);
                    // console.log(maxDistance);
                    // console.log(maxDistance);

                    if (app.maxDistance < 30) {
                        app.total = 0;
                    } else if (app.maxDistance >= 30 && app.maxDistance < 50) {
                        app.food_total = 0;
                        app.km_total = (app.maxDistance * app.km_fees) * 2;
                        app.total = app.km_total + app.food_total;
                        //    console.log(total);

                    } else if (app.maxDistance >= 50) {
                        app.dates = getDates(mission.started_at, mission.ended_at);
                        // meals = dates.length *2;
                        // nights = dates.length;
                        app.km_total = (app.maxDistance * app.km_fees) * 2;
                        // food total

                        if (app.dates.length < 2) { // same day
                            let timeSegments = [];
                            timeSegments.push([mission.started_time, mission.ended_time]);
                            timeSegments.push(app.food_allowance_intervals[0]);
                            console.log(overlap(timeSegments)); // true
                            (overlap(timeSegments) ? app.meals += 1 : app.meals += 0);

                            timeSegments = [];
                            timeSegments.push([mission.started_time, mission.ended_time]);
                            timeSegments.push(app.food_allowance_intervals[1]);
                            console.log(overlap(timeSegments)); // true
                            (overlap(timeSegments) ? app.meals += 1 : app.meals += 0);

                            // timeSegments = [];
                            // timeSegments.push([mission.started_time, mission.ended_time]);
                            // timeSegments.push(food_allowance_intervals[2]);
                            // console.log( overlap(timeSegments) ); // true
                            // ( overlap(timeSegments) ? nights += 1 : nights +=0);

                        } else { //more than 1 day
                            console.log(mission.started_time, app.food_allowance_intervals[1][1], mission.started_time <= app.food_allowance_intervals[1][1]);

                            var da = [];
                            da.push(app.dates[0], app.dates[app.dates.length - 1]);

                            if (mission.started_time < app.food_allowance_intervals[0][1]) {
                                app.meals += 2;

                            }
                            // else  if (mission.started_time <= food_allowance_intervals[1][0]){
                            //     meals += 1; 

                            // } 
                            else if (mission.started_time < app.food_allowance_intervals[1][1]) {
                                app.meals += 1;

                            }

                            console.log('meals of start', app.meals);
                            if (mission.ended_time <= app.food_allowance_intervals[0][0]) { // <= 11:00
                                app.meals += 0;
                            } else if (mission.ended_time <= app.food_allowance_intervals[1][0]) { // <= 18:00
                                app.meals += 1;
                            } else if (moment(app.food_allowance_intervals[2][0], 'HH:mm').diff(moment(mission.ended_time, 'HH:mm')) < 0) { // <= 00:00
                                app.meals += 2;
                            }
                            app.nights += (app.dates.length - 2) + 1;





                            // console.log('meals of start and end',meals);

                            app.meals += (app.dates.length - 2) * 2;



                        }

                        app.food_total = (app.meals * app.travel_allowances[0]) + (app.nights * app.travel_allowances[2]);
                        app.km_total = (app.maxDistance * app.km_fees) * 2;

                        app.total = app.food_total + app.km_total;
                        console.log('number of meals', app.meals);
                        console.log('number of nights', app.nights);
                        app.nights_total = app.nights * app.travel_allowances[2];
                        app.lunch_total = app.meals * app.travel_allowances[0];
                        console.log('food total', app.food_total);
                        console.log('km total', app.km_total);
                        console.log('TOTAL', app.total);

                    }
                    console.log('number of meals', app.meals);
                    console.log('number of nights', app.nights);

                    console.log('food total', app.food_total);
                    console.log('km total', app.km_total);
                    console.log('TOTAL', app.total);
                }


     missions_.push({'total' : app.total.toFixed(2),'status' : 'CALCULE'}
        );

    // axios.put('/updateDecompte/' + mission.id, {
    //         'total': app.total.toFixed(2),
    //         'status': 'CALCULE'

    //         // 'status': 'DEPOSE',
    //     })
    //     .then(function (response) {

    //     app.maxDistance = 0;
    //     app.km_fees = 0; // (0, 3, 12)
    //     app.travel_allowances;
    //     app.food_allowances;
    //     app.km_total = 0;
    //     app.food_total = 0;
    //     app.meals = 0;
    //     app.nights = 0;
    //     app.total = 0;
    //     app.dates = [];
    //     app.nights_total = 0;
    //     app.lunch_total = 0;
    //     app.km_top_position = 0;
    //                     notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');


    //                 })
    //                 .catch(function (error) {
    //                     if (error.response) {
    //                         app.$set(app, 'errors', error.response.data.errors);
    //                         notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red',
    //                             'topCenter', 'bounceInDown');
    //                     } else if (error.request) {
    //                         console.log(error.request);
    //                     } else {
    //                         console.log('Error', error.message);
    //                     }
    //                 });




            });
        }
    });
    console.log(missions_);
    
},
                        
            clearInputs() {
            $('#drivers').selectpicker('val','');
            $('#reasons').selectpicker('val','');
            $('#agents').selectpicker('val','');
            $('#vehicles').selectpicker('val','');
            $('#supported').selectpicker('val','');
            $('#source').selectpicker('val','');
            $('#destinations').selectpicker('val','');
            $('#transportation').selectpicker('val','');
            $('#started_at').val('');
            $('#ended_at').val('');
            $('#started_time').val('');
            $('#ended_time').val('');
            
                this.supported ='';
                this.reference = '';
                this.report_scan = '';
                this.agent_name = '';
                this.agent_id = '';
                this.driver_id = '';
                this.driver_name = '';
                this.report_url = '';
                this.request_scan = '';
                this.request_scan_name = '';
                this.request_url = '';
                this.cost = '';
                this.started_at = '';
                this.agent_id = '';
                this.started_time = '';
                this.ended_time = '';
                this.transportation = '';
                this.agent_vehicle_licence_number = '';
                this.agency_vehicle_licence_number = '';
                this.licence_number = '';
                this.source_id = '';
                this.selectedMissionId = '';
                this.selectedMissionIndex = '';
                this.trsp = '';
                this.trnsp = '';
        },
            getDriverName() {
                if (this.trsp == 'VP') {
                    $('#drivers').selectpicker('val', $('#agents').selectpicker('val'));
                    // this.driver_name = this.agent_name;
                    this.licence_number = this.agent_vehicle_licence_number;

                } else if(this.trsp == 'VS'){
                    // this.driver_name = '';
                    // this.licence_number = this.agency_vehicle_licence_number;
                }
            },
            handleFilesUpload() {
                this.request_scan = this.$refs.files.files;
                this.request_scan_name = this.request_scan[0].name;
                $('#request-file').val(this.request_scan_name);

            },
            handleFiles_Upload() {
                this.report_scan = this.$refs.files_.files;
                this.report_scan_name = this.report_scan[0].name;
                $('#report-file').val(this.report_scan_name);

            },
            fff() {
                console.log(this.$refs.files.files[0]);
                console.log(this.$refs.files_.files[0]);

            },
            fetch_notifications() {
                var app = this;
                
                app.notifications_fetched =  false;
                return axios.get('/getNotifications')
                    .then(function (response) {
                        app.notifications = response.data.notifications;
                        app.notifications_fetched =  true;
                        if (app.notifications.length > 0) {
                            ion.sound.play("ding_ding", {
                                loop: 2
                            });
                        }
                    });
            },
            init_table(tableName) {

                new $.fn.dataTable.Responsive($('#' + tableName).DataTable({

                    scrollX: false,
                    scrollCollapse: false,
                    scroller: false,
                    responsive: {
                        details: {
                            type: 'column'
                        }
                    },
                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }, {
                        orderable: false,
                        targets: 1
                    }],
                    order: [3, 'asc'],

                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(),
                            data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column(9)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Total over this page
                        pageTotal = api
                            .column(9, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Update footer
                        $(api.column(9).footer()).html(
                            'TOTAL : ' + formatMoney(pageTotal) + ' DA ' + '<br>' +
                            ' (GLOBAL : ' + formatMoney(total) + ' DA)'
                        );
                    },
                    initComplete: function () {

                        this.api().columns([3]).every(function () {

                            var column = this;

                            column.data().unique().sort().each(function (d, j) {
                                $('#f-agents').append('<option value="' + d +
                                    '">' +
                                    d + '</option>')
                            });
                        });

                        $('#f-agents').selectpicker('refresh').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            $("#missions-table").DataTable().columns([3])
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                        this.api().columns([11]).every(function () {

                            var column = this;

                            column.data().unique().sort().each(function (d, j) {
                                $('#f-reasons').append('<option value="' + d +
                                    '">' +
                                    d + '</option>')
                            });
                        });
                        $('#f-reasons').selectpicker('refresh').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            $("#missions-table").DataTable().columns([11])
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                        this.api().columns([2]).every(function () {

                            var column = this;

                            column.data().unique().sort().each(function (d, j) {
                                str = d.split('">');
                                $('#f-status').append('<option value="' +str[1].replace('</span>','')+
                                    '">' +
                                    str[1].replace('</span>','')+ '</option>')
                            });
                        });
                        $('#f-status').selectpicker('refresh').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            $("#missions-table").DataTable().columns([2])
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                        // $('#f-drivers').selectpicker('refresh').on('change', function() {
                        //             var val = $.fn.dataTable.util.escapeRegex(
                        //                 $(this).val()
                        //             );

                        //             $("#petrolCoupons-table").DataTable().columns([2])
                        //                 .search(val ? '^' + val + '$' : '', true, false)
                        //                 .draw();
                        //         });
                    },
                    'dom': 'Bfrtip',
                    "colVis": {
                        aiExclude: [1],
                    },
                    language: {
                        "decimal": "",
                        "emptyTable": "Aucune donnée disponible dans la table",
                        "info": "Affichage de _START_ à _END_ depuis _TOTAL_ entrées ",
                        "infoEmpty": "Affichange du 0 au 0 depuis 0 entrées",
                        "infoFiltered": "(Filtrage du _MAX_ entrées totales)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Affichage _MENU_ entrées",
                        "loadingRecords": "Loading...",
                        "processing": "Processing...",
                        "search": "Rechercher:",
                        "zeroRecords": "Aucun enregistrement correspondant trouvé",
                        "paginate": {
                            "first": "Premier",
                            "last": "Dernier",
                            "next": "Suivant",
                            "previous": "Précédent"
                        },
                    },

                    buttons: [{
                            extend: 'excelHtml5',
                            text: 'EXCEL',
                            className: 'btn-inverse ',
                            footer: true,
                            exportOptions: {
                                columns: "thead th:not(.noExport)",
                            }

                        }, {

                            extend: 'print',
                            text: 'IMPRIMER',
                            className: 'btn-inverse',
                            footer: true,
                            exportOptions: {
                                columns: "thead th:not(.noExport)"
                            }

                        },
                        // {
                        //     extend: 'colvis',
                        //     text: 'AFFICHAGE',
                        //     className: 'btn-inverse',
                        //     targets: [1,2] 
                        // }
                    ]

                }));

            },
            fill_table(url, tableName) {
                var app = this;
                this.fetch_missions(url, tableName).then((response) => {
                    app.init_table(tableName);
                    app.unblock(tableName);
                });
            },
            fetch_missions(url, tableName) {
                var app = this;
                app.block(tableName);
                $('#' + tableName).DataTable().destroy();
                return axios.get(url)
                    .then(function (response) {
                        app.missions = response.data.missions;
                    })
                    .catch();
            },
            delete_all() {
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
                            axios.delete('/missions/')
                                .then(function (response) {
                                    if (response.data.error) {
                                        // app.missions.splice(index,1)
                                        notify('Erreur', response.data.error, 'red', 'topCenter',
                                            'bounceInDown');

                                    } else {
                                        notify('Succès', response.data.success, 'green', 'topCenter',
                                            'bounceInDown');
                                        app.fill_table('/getMissions', 'missions-table');
                                        app.clearInputs();
                                    }
                                });
                        }
                    }
                )

            },
            delete_mission(id, index) {
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
                            axios.delete('/missions/' + id)
                                .then(function (response) {
                                    if (response.data.error) {
                                        // app.missions.splice(index,1)
                                        notify('Erreur', response.data.error, 'red', 'topCenter',
                                            'bounceInDown');

                                    } else {
                                        notify('Succès', response.data.success, 'green', 'topCenter',
                                            'bounceInDown');
                                        app.fill_table('/getMissions', 'missions-table');
                                        app.clearInputs();
                                    }
                                });
                        }
                    }
                )

            },
            edit_mission(mission, index) {
                this.selectedMissionId = mission.id;
                this.selectedMissionIndex = index;
                this.operation = 'edit';
                this.modal_title = "Modifier une mission";
                this.agent_id = mission.agent_id;
                this.reason = mission.reason;
                this.destinations = mission.destinations.map(d => d.id);
                console.log(mission.transportation);

                // this.cost = mission.cost;
                $('#started_at').data('daterangepicker').setStartDate(reFormatDateTime(mission.started_at));
                $('#started_at').data('daterangepicker').setEndDate(reFormatDateTime(mission.started_at));

                $('#ended_at').data('daterangepicker').setStartDate(reFormatDateTime(mission.ended_at));
                $('#ended_at').data('daterangepicker').setEndDate(reFormatDateTime(mission.ended_at));

                $('#ended_at').data('daterangepicker').setEndDate(reFormatDateTime(mission.ended_at));
                this.started_time = mission.started_time;
                this.ended_time = mission.ended_time;
                $('#agents').selectpicker('val', this.agent_id);
                $('#destinations').selectpicker('val', this.destinations);
                $('#source').selectpicker('val', mission.source_id);
                $('#reasons').selectpicker('val', this.reason);
                $('#supported').selectpicker('val', mission.supported);
                this.trsp = mission.transportation.slice(0,2);
               
                console.log(this.trsp);
                
                // this.transportation = mission.transportation;
                
                
                if(this.trsp == 'VS') {
                    $('#transportation').selectpicker('val', 'VS');
                    $('#vehicles').selectpicker('val',mission.transportation.split(' - ')[1]);
                    $('#drivers').selectpicker('val',mission.driver_id);

                } else if (this.trsp == 'VP') {
                    $('#drivers').selectpicker('val',mission.agent_id);
                    $('#transportation').selectpicker('val', 'VP');
                    this.agency_vehicle_licence_number = mission.transportation.split(' - ')[1];
                } else if (this.trsp == 'AU'){
                    $('#transportation').selectpicker('val', 'AU');
                    this.licence_number = '';
                }
            },
            add_mission() {
                var app = this;
                
                app.operation = 'add';
                app.modal_title = "Ajouter une mission";

                app.started_at = formatDate($('#started_at').data('daterangepicker').startDate);
                app.ended_at = formatDate($('#ended_at').data('daterangepicker').startDate);
                app.agent_id = $('#agents').selectpicker('val');
                app.driver_id = $('#drivers').selectpicker('val');
                app.source_id = $('#source').selectpicker('val');
                app.reason = $('#reasons').selectpicker('val');
               
                app.destinations = $('#destinations').selectpicker('val');
                if($('#transportation').selectpicker('val') == 'VP') {
                    app.licence_number = 'VP - ' + app.agent_vehicle_licence_number;
                     app.driver_id = $('#drivers').selectpicker('val');
                    $('#destinations').selectpicker('val');
                } else if($('#transportation').selectpicker('val') == 'VS' ) {
                    app.driver_id = $('#drivers').selectpicker('val');
                    app.licence_number = 'VS - '+$('#vehicles').selectpicker('val');
                } else if($('#transportation').selectpicker('val') =='AU') app.licence_number = 'AUTRE MOYEN'
                console.log(app.destinations);
                // console.log(app.started_time);
                // console.log(app.destinations);
                // console.log(app.licence_number);


                
                // app.report_scan = app.$refs.files.files[0];

                let formData = new FormData();

                formData.append('agent_id', app.agent_id);
                formData.append('driver_id', app.driver_id);
                formData.append('started_at', app.started_at);
                formData.append('ended_at', app.ended_at);
                formData.append('source_id', app.source_id);
                formData.append('started_time', app.started_time);
                formData.append('ended_time', app.ended_time);
                formData.append('destinations', app.destinations);
                formData.append('reason', app.reason);
                formData.append('reference', app.reference);
                formData.append('transportation', app.licence_number);
                formData.append('supported', app.supported);
                formData.append('status', 'DEPOSE');

                // formData.append('report_scan', app.report_scan);
                axios.post('/missions', formData,
                //  {
                //         headers: {
                //             'Content-Type': 'multipart/form-data'
                //         }
                //     }
                    )
                    .then(function (response) {

                        $('#mission-modal').modal('hide');
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                        $('#f-agents').selectpicker('refresh');
                        app.fill_table('/getMissions', 'missions-table');
                        app.clearInputs();
                        console.log(response.data.m);
                        

                    })
                    .catch(function (error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                            notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red',
                                'topCenter', 'bounceInDown');
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            update_mission() {
                var app = this;

                app.operation = 'add';
                // app.modal_title = "Modi une mission";

                app.started_at = formatDate($('#started_at').data('daterangepicker').startDate);
                app.ended_at = formatDate($('#ended_at').data('daterangepicker').startDate);
                app.agent_id = $('#agents').selectpicker('val');
                app.driver_id = $('#drivers').selectpicker('val');
                app.source_id = $('#source').selectpicker('val');
                app.reason = $('#reasons').selectpicker('val');
                app.supported = $('#supported').selectpicker('val');
               
                app.destinations = $('#destinations').selectpicker('val');
                app.trsp = $('#transportation').selectpicker('val');
                if(app.trsp == 'VP') {
                    app.licence_number = 'VP - ' + app.agent_vehicle_licence_number;
                    app.driver_id = $('#drivers').selectpicker('val');
                } else if(app.trsp == 'VS' ) {
                    app.driver_id = $('#drivers').selectpicker('val');
                    app.licence_number = 'VS - '+$('#vehicles').selectpicker('val');
                } else if(app.trsp == 'AU' ) app.licence_number = 'AUTRE MOYEN'
                console.log('app.trsp',app.trsp);
                // console.log(app.started_time);
                // console.log(app.destinations);
                // console.log(app.licence_number);


                
                // app.report_scan = app.$refs.files.files[0];

                let formData = new FormData();

                

                // formData.append('report_scan', app.report_scan);
                axios.put('/missions/' + app.selectedMissionId, 
                {
                'agent_id': app.agent_id,
                'driver_id': app.driver_id,
                'started_at': app.started_at,
                'ended_at': app.ended_at,
                'source_id': app.source_id,
                'started_time': app.started_time,
                'ended_time': app.ended_time,
                'destinations': app.destinations,
                'reason': app.reason,
                'reference': app.reference,
                'transportation': app.licence_number,
                'supported': app.supported,
                // 'status': 'DEPOSE',
            }
                    )
                    .then(function (response) {

                        $('#mission-modal').modal('hide');
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                        app.fill_table('/getMissions', 'missions-table');
                        app.reset_form();

                    })
                    .catch(function (error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                            notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red',
                                'topCenter', 'bounceInDown');
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },

            reset_form() {
                this.mechanic_id = '';
                this.cost = '';
                this.details = '';
                this.started_at = '';
                this.agent_id = '';
                this.modal_title = '';
                this.errors = [];
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

        },
    });

</script>

@endsection
