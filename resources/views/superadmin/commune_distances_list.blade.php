@extends('layouts.base')

@section('page-styles')
<style>

         </style>

@endsection

@section('page_title')
<h4>Configuration de l'application</h4>
{{-- <span>Ajouter, modifer ou supprimer une agence d'assurance </span> --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('commune-distances-list') }}">Configurations</a>
</li>
@endsection


@include('superadmin.navigation')


@section('page_content')
{{-- <div class="row"> --}}
    <div class="modal fade" id="kilometrage-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-model="modal_title">Ajouter</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" >&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-kilometrage-form">
                            <div class="form-group col-md-12 m-t-15">
                                <label for="source_id" class="block">Lieu depart @{{source_id}} <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.source_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.source_id" data-live-search="true">
                                    <select id="sources" class="selectpicker show-tick text-center" title="Depart.."
                                        data-width="100%" v-model="source_id" data-live-search="true">
                                        @foreach ($places as $place)
                                        <option value="{{$place->id}}">{{ $place->name .' - '.$place->state_id }}</option>
                                        @endforeach

                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-12 ">
                                <label for="destinations" class="block">Destination <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.destination_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.destination_id" data-live-search="true">
                                    <select id="destinations" class="selectpicker show-tick text-center" title="Destination.."
                                        data-width="100%" v-model="destination_id" data-live-search="true">
                                        @foreach ($places as $place)
                                        <option value="{{$place->id}}">{{ $place->name .' - '.$place->state_id}}</option>
                                        @endforeach

                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12 ">
                                <label for="distance" class="block">Distance<span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.distance ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="distance" type="number" class="form-control" placeholder="Distance..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.distance"
                                        v-model="distance">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_kilometrage()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_kilometrage()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card" >
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Tableau de kilometrage</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#kilometrage-modal"
                                    v-on:click="operation='add'">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="kilometrage-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Lieu depart</th>
                                <th>Destination</th>
                                <th>Distance</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(kilometrage, index) in commune_distances" :key="index">
                                <td style="width:20px">@{{ index+1}}</td>
                                <td style="width:auto">@{{ kilometrage.source.name }}</td>
                                <td style="width:auto">@{{ kilometrage.destination.name }}</td>
                                <td class="text-center">@{{ kilometrage.distance }}</td>
                                <td>
                                    <div class="text-center">
                                        <span data-toggle="modal" data-target="#kilometrage-modal" v-on:click="edit_kilometrage(kilometrage,index)">
                                            <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Modifier">
                                            </i>
                                        </span>

                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_kilometrage(kilometrage.id,index)"
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

@endsection

@section('page_scripts')
<script>
const app = new Vue({
    el: '#app',
    data() {
        return {
            operation: '',
            commune_distances: '',
            source_id: '',
            destination_id: '',
            distance: '',
            modal_title: '',
            selectedKilometrageId: '',
            selectedKilometrageIndex: '',
            errors: [],
            notifications:[],
            notifications_fetched: false,
        }
    },
    mounted() {
        this.fetch_notifications();
        this.fill_table('/getCommuneDistances', 'kilometrage-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#kilometrage-modal",
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
            this.fetch_commune_distances(url, tableName).then((response) => {
                app.init_table(tableName)
                app.unblock(tableName);
            });
        },
        fetch_commune_distances(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    if (response.data.commune_distances) {
                        app.commune_distances = response.data.commune_distances;
                        console.log(response.data.commune_distances);
                        
                    }
                })
                .catch();
        },
        delete_kilometrage(id, index) {
            var app = this;
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
                        axios.delete('/commune_distances/' + id)
                            .then(function (response) {
                                if (response.data.error) {
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');
                                } else {
                                    app.$delete(app.commune_distances, index, 1);
                                    app.fill_table('/getCommuneDistances', 'commune_distances-table');
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                }
                            });
                    }
                }
            )

        },
        edit_kilometrage(kilometrage, index) {
            this.selectedKilometrageId = kilometrage.id;
            this.selectedKilometrageIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier une distance";
            $('#sources').selectpicker('val',kilometrage.source_id);
            $('#destinations').selectpicker('val',kilometrage.destination_id);
            this.distance = kilometrage.distance;
        },
        add_kilometrage() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter une distance";

            let formData = new FormData();
            formData.append('source_id', this.source_id);
            formData.append('destination_id', this.destination_id);
            formData.append('distance', this.distance);

            axios.post('/commune_distances', formData)
                .then(function (response) {

                    $('#kilometrage-modal').modal('hide');

                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getCommuneDistances', 'commune_distances-table');
                    app.reset_form();
                })
                .catch(function (error) {
                    if (error.response) {
                        app.$set(app, 'errors', error.response.data.errors);
                        notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'bottomCenter', 'bounceInUp');
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
        },
        update_kilometrage() {
            var app = this;
            axios.put('/commune_distances/' + app.selectedKilometrageId, {
                    'source_id': app.source_id,
                    'destination_id': app.destination_id,
                    'distance': app.distance,
                })
                .then(function (response) {
                    $('#kilometrage-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getCommuneDistances', 'commune_distances-table');
                    app.reset_form();
                })
                .catch(function (error) {
                    if (error.response) {
                        app.$set(app, 'errors', error.response.data.errors);
                        notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'bottomCenter', 'bounceInDown');
                    }
                });
        },
        reset_form() {
            this.source_id = '';
            this.destination_id = '';
            this.distance = '';
            this.modal_title = '';
            this.errors = [];
            $('#sources').selectpicker('val',null);
            $('#destinations').selectpicker('val',null);
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
