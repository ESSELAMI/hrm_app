@extends('layouts.base')

@section('page_styles')

<link rel="stylesheet" type="text/css" href="{{ asset('pages/list-scroll/list.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/stroll/css/stroll.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/demo.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/j-pro-modern.css') }}">


@endsection

@section('page_title')
<h4>Liste des services</h4>
<span>Ajouter, modifer ou supprimer un service </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('services-list') }}">Liste des services</a>
</li>
@endsection


@include('admin.navigation')


@section('page_content')
<div class="row">
    <!-- Modal static-->
    <div class="modal fade" id="add-service-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" :class="[errors.name ? 'form-control form-control-danger' : 'form-control form-control-success']" placeholder="Entrer le nom du service..." maxlength="25" v-model="newService" required v-on:input="errors.name=null" />
                    <p class="text-danger m-t-5" v-if="errors.name">@{{errors.name.toString()}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" v-on:click="add_service()">Sauvgarder</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-service-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifer un service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" :class="[errors.name ? 'form-control form-control-danger' : 'form-control form-control-success']" maxlength="25" required v-on:input="errors.name=null" :placeholder="selectedServiceName" v-model="roleName" />
                    <p class="text-danger m-t-5" v-if="errors.name">@{{errors.name.toString()}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" v-on:click="update_service(roleName,selectedServiceIndex)">Sauvgarder</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="assign-rubriques-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"> Atrribuer des rubriques pour le service : <span v-if="selectedServiceName" class="label label-info"> <strong> @{{selectedServiceName}} </strong></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select multiple="multiple" id="test" v-model="selectedRubriques" style="height:400px">
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" v-on:click="assign_rubriques()">Sauvgarder</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">

        <div class="card">
            <div class="card-header table-card-header">

                <h5>Liste des services</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un service">
                                <i class="feather icon-plus text-success md-trigger" data-toggle="modal" data-target="#add-service-modal">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal static-->
            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="services-table" class="table table-hover table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Rôle</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(service, index) in services" v-bind:key="index" :class="{'selected-row': selectedServiceName === service.name}" v-on:click="showRubriques(service, service.rubriques),selectedServiceIndex = index">
                                <td>@{{ index+1}}</td>
                                <td>@{{ service.name }}</td>
                                <td>
                                    <div class="text-center">
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="Modifier">
                                            <i class="feather icon-edit text-custom f-18 clickable md-trigger" data-toggle="modal" data-target="#edit-service-modal" v-on:click="roleName=service.name">
                                            </i>
                                        </span>
                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="deleteService(service.id, index)" data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                        </i>
                                        <i class="feather icon-lock text-warning f-18 clickable" v-on:click="showRubriques(service, service.rubriques)" data-toggle="tooltip" data-placement="top" data-original-title="Afficher les Rubriques">
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

    <div class="col-md-7">
        <div class="card">
            <div class="card-header table-card-header">

                <h5>Liste des rubriques associées pour le service: <span class="label label-info" v-if="selectedServiceName"> <strong>@{{selectedServiceName}} </strong></span> </h5>

                <div class="card-header-right" v-if="selectedServiceName">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="left" data-original-title="Attribuer des rubriques">
                                <i class="feather icon-plus text-success md-trigger" data-toggle="modal" data-target="#assign-rubriques-modal" v-on:click="get_selected_rubriques()">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal static-->
            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="rubriques-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Rubriques</th>
                                <th style="width:50px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(rubrique, index) in role_rubriques" :key="index">
                                <td>@{{ index+1}}</td>
                                <td>@{{ rubrique.name }}</td>
                                <td>
                                    <div class="text-center">
                                        <i class="feather icon-trash text-danger f-18 clickable" data-toggle="tooltip" data-placement="top" data-original-title="Supprimer" v-on:click="revoke_rubrique(rubrique.id,index)">
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


    {{-- <div class="col-sm-5">
            <select name="from" id="optgroup" class="form-control" size="8" multiple="multiple">

        <option v-for="(rubrique, index) in rubriques" value="rubrique.id">@{{rubrique.name}}</option>


    </select>
</div>

<div class="col-sm-2">
    <button type="button" id="optgroup_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
    <button type="button" id="optgroup_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
    <button type="button" id="optgroup_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
    <button type="button" id="optgroup_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
</div>

<div class="col-sm-5">
    <select name="to" id="optgroup_to" class="form-control" size="8" multiple="multiple">
    </select>
</div> --}}



</div>


@endsection

@section('page_scripts')
<script type="text/javascript" src="{{ asset('bower_components/bootstrap-maxlength/js/bootstrap-maxlength.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#test').multiSelect({
            selectableHeader: "<div class='custom-header'>Les rubriques disponibles</div>",
            selectionHeader: "<div class='custom-header'>Les rubriques sélectionnées</div>",

        });

        $('#assign-rubriques-modal').on('hide.bs.modal', function() {
            $('#test').multiSelect('deselect_all');
        });
    });
</script>
<script>
    const app = new Vue({
        el: '#app',
        data() {
            return {
                selectedService: '',
                roleName: '',
                newService: '',
                selectedServiceName: '',
                selectedServiceIndex: '',
                role_rubriques: [],
                services: [],
                rubriques: [],
                selectedRubriques: [],
                errors: [],
                notifications: [],
                notifications_fetched: false,
            }
        },
        computed: {
            //  ...mapGetters ({
            //     allservices :'ALL_ROLES',
            //     //'role_rubriques',
            //  })
            get_services() {
                return this.services;
            }
        },
        methods: {
            showRubriques(service, rubriques) {
                app.role_rubriques = rubriques;
                console.log(rubriques);
                app.selectedService = service.id;
                app.selectedServiceName = service.name;
                console.log(app.selectedService);
            },
            deleteService(id, index) {
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
                    function(isConfirm) {
                        if (isConfirm) {
                            axios.delete('/role_delete/' + id)
                                .then(function(response) {
                                    if (response.data.success) {
                                        app.services.splice(index, 1)
                                        app.selectedServiceName = '';
                                        app.selectedServiceIndex = '';
                                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    } else {
                                        notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');
                                    }
                                });
                        }
                    }
                );

            },

            fetch_services() {
                return axios.get('/getServices')
                    .then(response => this.services = response.data.services)
                    .catch();


            },
            fetch_rubriques() {
                return axios.get('/getRubriques')
                    // .then(response => this.rubriques = response.data.rubriques)
                    .then(function(response) {
                        this.rubriques = response.data.rubriques;
                        this.rubriques.forEach(rubrique => {
                            $('#test').multiSelect(
                                'addOption', {
                                    value: rubrique.id,
                                    text: rubrique.name
                                },
                            );
                        });
                    })
                    .catch();
            },
            add_service() {
                axios.post('/role_add', {
                        'name': app.newService
                    })
                    .then(function(response) {
                        app.services.push(response.data.role);
                        $('#add-service-modal').modal('toggle');
                        app.newService = '';
                        app.selectedServiceName = '';
                        app.selectedServiceIndex = '';
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            update_service(name, index) {
                axios.put('/role_edit/' + this.selectedService, {
                        'name': name
                    })
                    .then(function(response) {
                        app.$set(app.services, index, response.data.role);
                        $('#edit-service-modal').modal('toggle');
                        app.roleName = '';
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });

            },
            assign_rubriques() {
                this.selectedRubriques = $('#test').multiSelect().val();
                var rubriques = this.selectedRubriques.toString().split(',').map(Number);
                axios.post('/role_assign_rubriques/' + this.selectedService, {
                        'rubriques': rubriques
                    })
                    .then(function(response) {
                        // app.$set(app.services,index,response.data.role);
                        // app.fetch_services();
                        $('#assign-rubriques-modal').modal('toggle');
                        app.role_rubriques = response.data.rubriques;
                        console.log(response.data.services);
                        console.log(app.services);

                        app.services = response.data.services;
                        console.log(app.services);
                        app.selectedRubriques = '';
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            revoke_rubrique(id, index) {
                console.log(app.services[0].rubriques);
                console.log(this.selectedService);
                console.log(this.selectedServiceIndex);
                console.log(index);

                axios.post('/role_revoke_rubrique/' + this.selectedService, {
                        'rubrique': id
                    })
                    .then(function(response) {
                        console.log(app.role_rubriques);

                        app.$delete(app.role_rubriques, index, 1);
                        console.log(app.role_rubriques);


                        app.services[app.selectedServiceIndex].rubriques.slice(index, 1);
                        //app.fetch_services();
                        // app.selectedService = '';
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            get_selected_rubriques() {
                $('#test').multiSelect('select', app.role_rubriques.map(p => p.id + ''));

            },
        },
        created() {
            console.log('ServicesList created..');
            this.fetch_services();
            this.fetch_rubriques();
            console.log(this.rubriques);
            this.fetch_rubriques()
        },
        mounted() {
            $('#optgroup').multiSelect();
            this.fetch_rubriques();
        }
    });
    $('#optgroup').multiSelect({
        selectableHeader: "<div class='custom-header'>Selectable items</div>",
        selectionHeader: "<div class='custom-header'>Selection items</div>"
    });
</script>

@endsection