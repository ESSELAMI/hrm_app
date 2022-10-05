@extends('layouts.base')

@section('page-styles')
<style>

         </style>

@endsection

@section('page_title')
<h4>Liste des mécaniciens</h4>
<span>Ajouter, modifer ou supprimer un mécanicien </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('mechanics.index') }}">Liste des mécaniciens</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="mechanic-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-model="modal_title">Ajouter un mécanicien</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-mechanic-form">
                            <div class="form-group col-md-12">
                                <label for="full-name" class="block">Nom et Prénom <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.fullname ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="full-name" type="text" class="form-control" placeholder="Nom et prénom..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.fullname"
                                        v-model="fullname">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
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
                            <div class="form-group col-md-12">
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
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_mechanic()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_mechanic()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des mécaniciens</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un mécanicien">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#mechanic-modal"
                                    v-on:click="operation='add'">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="mechanics-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>NOM - PRENOM</th>
                                <th>TELEPHONE</th>
                                <th>ADRESSE</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(mechanic, index) in mechanics" :key="index">
                                <td>@{{ index+1}}</td>
                                <td>@{{ mechanic.fullname }}</td>
                                <td class="text-center">@{{ mechanic.phone_number }}</td>
                                <td>@{{ mechanic.address }}</td>
                                <td>
                                    <div class="text-center">
                                        <span data-toggle="modal" data-target="#mechanic-modal" v-on:click="edit_mechanic(mechanic,index)">
                                            <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Modifier">
                                            </i>
                                        </span>

                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_mechanic(mechanic.id,index)"
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

            fullname: '',
            address: '',
            phone_number: '',
            modal_title: '',
            selectedMechanicId:'',
            selectedMechanicIndex:'',
            notifications:[],
            mechanics:[],
            errors: [],
        }
    },
    mounted() {
        this.fetch_notifications();
        this.fill_table('/getMechanics', 'mechanics-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#mechanic-modal",
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
            this.fetch_mechanics(url, tableName).then((response) => {
                app.init_table(tableName)
                app.unblock(tableName);
            });
        },
        fetch_mechanics(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    if (response.data.mechanics) {
                        app.mechanics = response.data.mechanics;
                    }
                })
                .catch();
        },
        delete_mechanic(id, index) {
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
                        axios.delete('/mechanics/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.mechanics.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');
                                } else {
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    app.fill_table('/getMechanics', 'mechanics-table');
                                    app.reset_form();
                                }
                            });
                    }
                }
            )

        },
        edit_mechanic(mechanic,index){
            this.selectedMechanicId = mechanic.id;
            this.selectedMechanicIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier un mécanicien";
            this.fullname = mechanic.fullname;
            this.phone_number = mechanic.phone_number;
            this.address = mechanic.address;
        },
        add_mechanic() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter un mécanicien";

            let formData = new FormData();
            formData.append('fullname', this.fullname);
            formData.append('address', this.address);
            formData.append('phone_number', this.phone_number);

            axios.post('/mechanics', formData
                )
                .then(function (response) {

                    $('#mechanic-modal').modal('hide');

                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getMechanics', 'mechanics-table');
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
        update_mechanic() {
            var app = this;
            axios.put('/mechanics/'+app.selectedMechanicId, {
                'fullname': app.fullname,
                'address': app.address,
                'phone_number': app.phone_number,
                })
                .then(function (response) {
                    $('#mechanic-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getMechanics', 'mechanics-table');
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
            this.fullname = '';
            this.address = '';
            this.phone_number = '';
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
