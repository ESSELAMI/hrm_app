@extends('layouts.base')

@section('page-styles')
<style>

         </style>

@endsection

@section('page_title')
<h4>Liste des chauffeurs</h4>
<span>Ajouter, modifer ou supprimer un chauffeur </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('drivers.index') }}">Liste des chauffeurs</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="driver-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-model="modal_title">Ajouter un chauffeur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-driver-form">
                            <div class="form-group col-md-6">
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
                            <div class="form-group col-md-6">
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
                            <div class="form-group col-md-6">
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
                            <div class="form-group col-md-6">
                                <label for="licence-types" class="block">Type de permis <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.licence_type ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.licence_type">
                                    <select id="licence-types" class="selectpicker show-tick" title="Type du permis.."
                                        data-width="100%" multiple>
                                        @foreach ($licenceTypes as $type)
                                        <option value="{{$type->name}}">{{ "Catégorie ".$type->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="licence_delivery_date" class="block">Date de livraision du permis <span
                                        class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.licence_delivery_date ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="licence-delivery-date" name="date" type="text" class="date text-center form-control"
                                        placeholder="Date de livraision..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.licence_delivery_date">
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="licence-experation-date" class="block">Date d'expiration du permis <span
                                        class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.licence_experation_date ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="licence-experation-date" name="date" type="text" class="date text-center form-control"
                                        placeholder="Date d'expiration..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.licence_experation_date">
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
                        v-on:click="add_driver()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_driver()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des chauffeurs</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span v-on:click="operation='add'" data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un chauffeur">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#driver-modal"
                                    >
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="drivers-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>NOM - PRENOM</th>
                                <th>TELEPHONE</th>
                                <th>ADRESSE</th>
                                <th>TYPE DE PERMIS</th>
                                <th>DATE LIVRAISON DU PERMIS</th>
                                <th>DATE EXPIRATION DU PERMIS</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(driver, index) in drivers" :key="index" >
                                <td>@{{ index+1}}</td>
                                <td>@{{ driver.fullname.toUpperCase() }}</td>
                                <td class="text-center">@{{ driver.phone_number }}</td>
                                <td>@{{ driver.address }}</td>
                                <td class="text-center">@{{ driver.licence_type }}</td>
                                <td class="text-center">@{{ reFormatDate(driver.licence_delivery_date) }}</td>
                                <td class="text-center">@{{ reFormatDate(driver.licence_experation_date) }}</td>
                                 <td>
                                    <div class="text-center">
                                        <span data-toggle="modal" data-target="#driver-modal" v-on:click="edit_driver(driver,index)">
                                            <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Modifier">
                                            </i>
                                        </span>

                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_driver(driver.id,index)"
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
            licence_delivery_date: '',
            licence_experation_date: '',
            licence_type: '',
            selectedDriverId:'',
            selectedDriverIndex:'',
            notifications:[],
            drivers:[],
            errors: [],
        }
    },
    mounted() {
        this.fetch_notifications();
        this.fill_table('/getDrivers', 'drivers-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#driver-modal",
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
            this.fetch_drivers(url, tableName).then((response) => {
               app.init_table(tableName);
                app.unblock(tableName);
            });
        },
        fetch_drivers(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    if (response.data.drivers) {
                    app.drivers = response.data.drivers;
                    console.log(app.drivers);

                    }
                })
                .catch();
        },
        delete_driver(id, index) {
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
                        axios.delete('/drivers/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.drivers.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');
                                } else {
                                    app.fill_table('/getDrivers', 'drivers-table');
                                    app.reset_form();
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                }
                            });
                    }
                }
            )

        },
        edit_driver(driver,index){
            this.selectedDriverId = driver.id;
            this.selectedDriverIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier un chauffeur";
            $('#licence-types').selectpicker('val',driver.licence_type.split(',').map(p=>p+''));
            $('#licence-experation-date').data('daterangepicker').setStartDate(reFormatDate(driver.licence_experation_date));
            $('#licence-experation-date').data('daterangepicker').setEndDate(reFormatDate(driver.licence_experation_date));
            $('#licence-delivery-date').data('daterangepicker').setStartDate(reFormatDate(driver.licence_delivery_date));
            $('#licence-delivery-date').data('daterangepicker').setEndDate(reFormatDate(driver.licence_delivery_date));
            this.fullname = driver.fullname;
            this.phone_number = driver.phone_number;
            this.address = driver.address;
        },
        add_driver() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter un chauffeur";

            var table = $('#drivers-table').DataTable();
            app.licence_type = $('#licence-types').selectpicker('val');
            app.licence_experation_date = formatDate($('#licence-experation-date').data('daterangepicker').startDate);
            app.licence_delivery_date = formatDate($('#licence-delivery-date').data('daterangepicker').startDate);

            let formData = new FormData();
            formData.append('fullname', this.fullname);
            formData.append('licence_type', this.licence_type);
            formData.append('licence_delivery_date', this.licence_delivery_date);
            formData.append('licence_experation_date', this.licence_experation_date);
            formData.append('address', this.address);
            formData.append('phone_number', this.phone_number);

            axios.post('/drivers', formData
                )
                .then(function (response) {

                    $('#driver-modal').modal('hide');

                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getDrivers', 'drivers-table');
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
        update_driver() {
            var app = this;
            app.licence_type = $('#licence-types').selectpicker('val');
            app.licence_experation_date = formatDate($('#licence-experation-date').data('daterangepicker').startDate);
            app.licence_delivery_date = formatDate($('#licence-delivery-date').data('daterangepicker').startDate);

            axios.put('/drivers/'+app.selectedDriverId, {
                'fullname': app.fullname,
                'licence_type': this.licence_type.toString(),
                'licence_delivery_date': app.licence_delivery_date,
                'licence_experation_date' : app.licence_experation_date,
                'address': app.address,
                'phone_number': app.phone_number,
                })
                .then(function (response) {
                    $('#driver-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getDrivers', 'drivers-table');
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
            this.licence_delivery_date = '';
            this.licence_experation_date = '';
            this.licence_type = '';
            this.errors = [];
            $('#licence-types').selectpicker('val', null);
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
