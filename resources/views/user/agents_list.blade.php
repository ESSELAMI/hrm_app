@extends('layouts.base')

@section('page-styles')
<style>

         </style>

@endsection

@section('page_title')
<h4>Liste des agents</h4>
<span>Ajouter, modifer ou supprimer un agent </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('agents.index') }}">Liste des agents</a>
</li>
@endsection


@include('user.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="agent-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-model="modal_title">Ajouter un agent</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-agent-form">
                            <div class="form-group col-md-4">
                                <label for="firstname" class="block">Nom <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.firstname ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="firstname" type="text" class="form-control" placeholder="Nom..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.firstname"
                                        v-model="firstname">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lastname" class="block">Prénom <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.lastname ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="lastname" type="text" class="form-control" placeholder="Prénom..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.lastname"
                                        v-model="lastname">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sexe" class="block">Sexe <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.sexe ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.sexe">
                                    <select id="sexe" class="selectpicker show-tick" title="sexe.."
                                        data-width="100%" >
                                        <option value="Homme">Homme</option>
                                        <option value="Femme">Femme</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="address" class="block">Adresse <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.address ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="address" type="text" class="form-control" placeholder="Adresse..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.address"
                                        v-model="address">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="birthdate" class="block">Date naissance <span
                                        class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.birthdate ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="birthdate" name="date" type="text" class="date text-center form-control"
                                        placeholder="Date naissance..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.birthdate">
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="birthplace" class="block">Lieu naissance <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.birthplace ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="birthplace" type="text" class="form-control" placeholder="Lieu naissance..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.birthplace"
                                        v-model="birthplace">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="agent-number" class="block">Numéro d'agent <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.agent_number ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="agent-number" type="text" class="form-control" placeholder="Numéro d'agent..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.agent_number"
                                        v-model="agent_number">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="account-number" class="block">Numéro de compte <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.account_number ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="account-number" type="text" class="form-control" placeholder="Numéro de compte..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.account_number"
                                        v-model="account_number">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="phone-number" class="block">Numéro de téléphone <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.phone_number ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="phone-number" type="text" class="form-control" placeholder="Numéro du téléphone..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.phone_number"
                                        v-model="phone_number">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="vehicle_licence_number" class="block">Vehicule Personnel</label>
                                <div :class="[errors.vehicle_licence_number ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="phone-number" type="text" class="form-control" placeholder="Vehicule Personnel..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.vehicle_licence_number"
                                        v-model="vehicle_licence_number">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="diploma_name" class="block">Diplôme <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.diploma_name ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.diploma_name">
                                    <select id="diplomas" class="selectpicker show-tick" title="Diplôme.."
                                        data-width="100%" >
                                        @foreach ($diplomas as $diploma)
                                        <option value="{{$diploma->id}}">{{ $diploma->designation}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="fonction_name" class="block">QUALIFICATION <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.fonction_name ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.fonction_name">
                                    <select id="fonctions" class="selectpicker show-tick" title="Qualification.."
                                        data-width="100%" data-live-search="true"
                                        v-on:change="category_section = $('#fonctions option:selected').attr('category_')">
                                        @foreach ($fonctions as $fonction)
                            <option value="{{$fonction->id}}" category_="{{ $fonction->category->number.'/'.$fonction->section->number }}" >{{ $fonction->name}}</option>
                            
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="account-number" class="block">Catégorie </label>
                                <div :class="[errors.account_number ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input type="text" class="form-control" placeholder="Catégorie.." 
                                    :value="category_section" readonly>
                                    
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="level_number" class="block">Echlon <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.level_number ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.level_number">
                                    <select id="levels" class="selectpicker show-tick" title="Echlon..."
                                        data-width="100%" >
                                        @foreach ($levels as $level)
                                        <option value="{{$level->id}}" title="{{$level->number}}">{{ 'Echlon '.$level->number}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="subdirectorate_name" class="block">Affectation <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.subdirectorate_name ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.subdirectorate_name">
                                    <select id="subdirectorates" class="selectpicker show-tick" title="Affectation.."
                                        data-width="100%" >
                                        @foreach ($subdirectorates as $subdirectorate)
                                        <option value="{{$subdirectorate->id}}" title="{{$subdirectorate->abbreviation}}">{{ $subdirectorate->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="job_name" class="block">POSTE <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.job_name ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.job_name">
                                    <select id="jobs" class="selectpicker show-tick" title="POSTE.."
                                        data-width="100%" >
                                        @foreach ($jobs as $job)
                                        <option value="{{$job->id}}">{{ $job->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="department_name" class="block">Centre payeur <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.department_name ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.department_name">
                                    <select id="departments" class="selectpicker show-tick" title="Centre payeur.."
                                        data-width="100%" >
                                        @foreach ($departments as $department)
                                        <option value="{{$department->id}}">{{ $department->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            
                      
                            <div class="form-group col-md-4">
                                <label for="diploma_date" class="block">Date d'obtention <span
                                        class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.diploma_date ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="diploma_date" name="date" type="text" class="date text-center form-control"
                                        placeholder="Date d'obtention'..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.diploma_date">
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="recrutment_date" class="block">Date recrutement <span
                                        class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.recrutment_date ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="recrutment_date" name="date" type="text" class="date text-center form-control"
                                        placeholder="Date recrutement..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.recrutment_date">
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_agent()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_agent()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des agents</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span v-on:click="operation='add'" data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un agent">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#agent-modal"
                                  v-on:click='clearInputs()'  >
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="agents-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th >NUMERO D'AGENT</th>
                                <th>NOM - PRENOM</th>
                                <th>DATE NAISSANCE</th>
                                <th>LIEU NAISSANCE</th>
                                <th>SEXE</th>
                                <th>TELEPHONE</th>
                                <th>ADRESSE</th>
                                <th>NUMERO DE COMPTE</th>
                                {{-- <th>DIPLÔME</th> --}}
                                {{-- <th>DATE OBTENTION</th> --}}
                                <th>QUALIFICATION</th>
                                {{-- <th>POSTE</th> --}}
                                {{-- <th>AFFECTATION</th> --}}
                                <th>CP</th>
                                <th>CATEGORIE</th>
                                <th>ECHLON</th>
                                <th>DATE RECRUTEMENT</th>
                                <th>VEHICULE PERSONNEL</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(agent, index) in agents" :key="index" >
                                <td>@{{ index+1}}</td>
                                <td>@{{ agent.agent_number}}</td>
                                <td>@{{ agent.firstname.toUpperCase() + ' ' + agent.lastname.toUpperCase() }}</td>
                                <td class="text-center">@{{ reFormatDate(agent.birthdate) }}</td>
                                <td >@{{ agent.birthplace }}</td>
                                <td class="text-center">@{{ agent.sexe }}</td>
                                <td class="text-center">@{{ agent.phone_number }}</td>
                                <td>@{{ agent.address }}</td>
                                <td >@{{ agent.account_number }}</td>
                                {{-- <td v-if="agent.diploma">@{{ decodeURI(agent.diploma.designation) }}</td> --}}
                                {{-- <td v-else>@{{ '/' }}</td> --}}
                                {{-- <td class="text-center">@{{ reFormatDate(agent.diploma_date) }}</td> --}}
                                <td>@{{ agent.fonction.name }}</td>
                                {{-- <td>@{{ agent.job.name }}</td> --}}
                                {{-- <td>@{{ agent.subdirectorate.name }}</td> --}}
                                <td>@{{ agent.department.name }}</td>
                                <td>@{{ agent.fonction.category.number +' / '+ agent.fonction.section.number}}</td>
                                <td>@{{ agent.level.number }}</td>
                                <td class="text-center">@{{ reFormatDate(agent.recrutment_date) }}</td>
                                <td class="text-center">@{{ agent.vehicle_licence_number }}</td>
                                 <td>
                                    <div class="text-center">
                                        <span data-toggle="modal" data-target="#agent-modal" v-on:click="edit_agent(agent,index)">
                                            <i class="feather icon-edit text-inverse f-18 clickable" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Modifier">
                                            </i>
                                        </span>

                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_agent(agent.id,index)"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                        </i>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('page_scripts')

<script>
const app = new Vue({
    el: '#app',
    data() {
        return {
            operation:'',

            firstname: '',
            lastname: '',
            address: '',
            phone_number: '',
            modal_title: '',
            agent_number: '',
            birthdate: '',
            birthplace:'',
            sexe:'',
            address:'',
            account_number:'',
            diploma_id:'',
            diploma_date:'',
            function_id:'', 
            job_id:'',
            category_section:'',
            subdirectorate_id:'',
            department_id:'',
            category:'',
            section:'',
            level_id:'',
            vehicle_licence_number:'',
            recrutment_date:'',
            notifications: [],
                notifications_fetched: false,
            agents:[],
            errors: [],
        }
    },
    mounted() {
	
        
        this.fill_table('/getAgents', 'agents-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#agent-modal",
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
        // this.fetch_notifications();
    },
    methods: {
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
            $('#' + tableName).DataTable({
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
        },
        fill_table(url, tableName) {
            var app = this;
            this.fetch_agents(url, tableName).then((response) => {
               app.init_table(tableName);
                app.unblock(tableName);
            });
        },
        fetch_agents(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    if (response.data.agents) {
                    app.agents = response.data.agents;
                    console.log(app.agents);

                    }
                })
                .catch();
        },
        delete_agent(id, index) {
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
                        axios.delete('/agents/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.agents.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');
                                } else {
                                    app.fill_table('/getAgents', 'agents-table');
                                    app.reset_form();
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                }
                            });
                    }
                }
            )

        },
        clearInputs() {
            $('#diplomas').selectpicker('val','');
            $('#sexe').selectpicker('val','');
            $('#fonctions').selectpicker('val','');
            $('#jobs').selectpicker('val','');
            $('#levels').selectpicker('val','');
            $('#subdirectorates').selectpicker('val','');
            $('#departments').selectpicker('val','');
            $('#birthdate').val('');
            $('#birthdate').val('');
            $('#recrutment_date').val('');
            $('#recrutment_date').val('');
            $('#diploma_date').val('');
            $('#diploma_date').val('');
            this.selectedAgentId = '';
            this.selectedAgentIndex = '';
            this.firstname = '' ;
            this.lastname = '' ;
            this.phone_number = '' ;
            this.account_number = '' ;
            this.address = '' ;
            this.birthplace = '' ;
            this.agent_number = '' ;
            this.vehicle_licence_number = '' ;
        },
        edit_agent(agent,index){
            console.log(agent.id);
            
            this.selectedAgentId = agent.id;
            this.selectedAgentIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier un agent";
            // $('#diplomas').selectpicker('val',agent.diploma.id);
            $('#sexe').selectpicker('val',agent.sexe);
            $('#fonctions').selectpicker('val',agent.fonction.id);
            // $('#jobs').selectpicker('val',agent.job.id);
            $('#levels').selectpicker('val',agent.level.id);
            // $('#subdirectorates').selectpicker('val',agent.subdirectorate.id);
            $('#departments').selectpicker('val',agent.department.id);
            $('#birthdate').data('daterangepicker').setStartDate(reFormatDate(agent.birthdate));
            $('#birthdate').data('daterangepicker').setEndDate(reFormatDate(agent.birthdate));
            $('#recrutment_date').data('daterangepicker').setStartDate(reFormatDate(agent.recrutment_date));
            $('#recrutment_date').data('daterangepicker').setEndDate(reFormatDate(agent.recrutment_date));
            $('#diploma_date').data('daterangepicker').setStartDate(reFormatDate(agent.diploma_date));
            $('#diploma_date').data('daterangepicker').setEndDate(reFormatDate(agent.diploma_date));
            this.firstname = agent.firstname;
            this.lastname = agent.lastname;
            this.vehicle_licence_number = agent.vehicle_licence_number;
            this.phone_number = agent.phone_number;
            this.account_number = agent.account_number;
            this.address = agent.address;
            this.birthplace = agent.birthplace;
            this.agent_number = agent.agent_number;
            
        },
        add_agent() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter un agent";

            var table = $('#agents-table').DataTable();
            app.sexe = $('#sexe').selectpicker('val');
          
            // app.diploma_id = $('#diplomas').selectpicker('val');
            app.function_id = $('#fonctions').selectpicker('val');
            // app.job_id = $('#jobs').selectpicker('val');
            app.department_id = $('#departments').selectpicker('val');
            // app.subdirectorate_id = $('#subdirectorates').selectpicker('val');
            app.level_id = $('#levels').selectpicker('val');
            app.birthdate = formatDate($('#birthdate').data('daterangepicker').startDate);
            app.diploma_date = formatDate($('#diploma_date').data('daterangepicker').startDate);
            app.recrutment_date = formatDate($('#recrutment_date').data('daterangepicker').startDate);

            let formData = new FormData();
            formData.append('lastname', this.lastname);
            formData.append('firstname', this.firstname);
            formData.append('sexe', this.sexe);
            formData.append('diploma_date', this.diploma_date);
            formData.append('birthdate', this.birthdate);
            formData.append('address', this.address);
            formData.append('vehicle_licence_number', this.vehicle_licence_number);
            formData.append('phone_number', this.phone_number);
            formData.append('account_number', this.account_number);
            formData.append('birthplace', this.birthplace);
            formData.append('recrutment_date', this.recrutment_date);
            formData.append('agent_number', this.agent_number);
            formData.append('function_id', this.function_id);
            formData.append('department_id', this.department_id);
            formData.append('job_id', this.job_id);
            formData.append('diploma_id', this.diploma_id);
            formData.append('subdirectorate_id', this.subdirectorate_id);
            formData.append('level_id', this.level_id);

            axios.post('/agents', formData
                )
                .then(function (response) {

                    $('#agent-modal').modal('hide');

                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getAgents', 'agents-table');
                    app.reset_form();
                })
                .catch(function (error) {
                    if (error.response) {
                        app.$set(app, 'errors', error.response.data.errors);
                        notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'topCenter', 'bounceInDown');
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
        },
        update_agent() {
            var app = this;
            app.sexe = $('#sexe').selectpicker('val');
            app.diploma_id = $('#diplomas').selectpicker('val');
            app.function_id = $('#fonctions').selectpicker('val');
            app.job_id = $('#jobs').selectpicker('val');
            app.department_id = $('#departments').selectpicker('val');
            app.subdirectorate_id = $('#subdirectorates').selectpicker('val');
            app.level_id = $('#levels').selectpicker('val');
            app.birthdate = formatDate($('#birthdate').data('daterangepicker').startDate);
            app.diploma_date = formatDate($('#diploma_date').data('daterangepicker').startDate);
            app.recrutment_date = formatDate($('#recrutment_date').data('daterangepicker').startDate);
            
            axios.put('/agents/'+app.selectedAgentId, {
                'firstname' : this.firstname,
                'lastname' : this.lastname,
                'vehicle_licence_number' : this.vehicle_licence_number,
                'sexe' : this.sexe,
                'diploma_date' : this.diploma_date,
                'birthdate' : this.birthdate,
                'address' : this.address,
                'phone_number' : this.phone_number,
                'account_number' : this.account_number,
                'birthplace' : this.birthplace,
                'recrutment_date' : this.recrutment_date,
                'agent_number' : this.agent_number,
                'function_id' : this.function_id,
                'department_id' : this.department_id,
                'job_id' : this.job_id,
                'diploma_id' : this.diploma_id,
                'subdirectorate_id' : this.subdirectorate_id,
                'level_id' : this.level_id

            })
                .then(function (response) {
                    $('#agent-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getAgents', 'agents-table');
                    app.reset_form();
                })
                .catch(function (error) {
                    if (error.response) {
                        app.$set(app, 'errors', error.response.data.errors);
                        notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'topCenter', 'bounceInDown');
                    }
                });
        },
        reset_form() {
            this.lastname =  '';
            this.firstname =  '';
            this.address=  '';
            this.phone_number=  '';
            this.modal_title=  '';
            this.agent_number=  '';
            this.birthdate=  '';
            this.birthplace=  '';
            this.sexe=  '';
            this.address=  '';
            this.account_number=  '';
            this.diploma_id=  '';
            this.diploma_date=  '';
            this.fonction_id=  ''; 
            this.job_id=  '';
            this.subdirectorate_id=  '';
            this.department_id=  '';
            this.category=  '';
            this.section=  '';
            this.level_number=  '';
            this.recrutment_date=  '';
            this.vehicle_licence_number=  '';
            this.errors=  '';
            
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
