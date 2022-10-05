@extends('layouts.base')

@section('page-styles')
<style>

         </style>

@endsection

@section('page_title')
<h4>Liste des cartes NAFTAL</h4>
<span>Ajouter, modifer ou supprimer une carte NAFTAL </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('fuelCards.index') }}">Liste des cartes NAFTAL</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="fuelCard-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter une carte NAFTAL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-fuelCard-form">
                            <div class="form-group col-md-12 m-t-15">
                                <label for="-date" class="block">Véhicule <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.vehicle_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.vehicle_id">
                                    <select id="vehicles" class="selectpicker show-tick text-center" title="Sélectionner un véhicule.."
                                        data-width="100%" >
                                       
                                            
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-7 m-t-15">
                                <label for=serial_number" class="block">Numéro de la carte <span class="text-danger">(*)</span></label>
                                <div :class="[errors.serial_number ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="text" class="form-control " placeholder="Numéro de la carte" data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.serial_number" v-model="serial_number" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-5 m-t-15">
                                <label for=debit" class="block">Débit <span class="text-danger">(*)</span></label>
                                <div :class="[errors.debit ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="number" class="form-control " placeholder="Débit..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.debit" v-model="debit" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-7 m-t-15">
                                <label for="card-number" class="block">Date d'expiration<span class="text-danger"> (*)</span></label>
                                <div :class="[errors.experation_date ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="experation-date" type="text" class="form-control date text-center" placeholder="Date d'expiration..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.experation_date"
                                        >
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-5 m-t-15">
                                    <label for="credit" class="block">Crédit <span class="text-danger">(*)</span></label>
                                    <div :class="[errors.credit ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                        <input  type="number" class="form-control " placeholder="Crédit..." data-toggle="tooltip"
                                            data-placement="top" :data-original-title="errors.credit" v-model="credit" min="0">
                                        <span class="input-group-addon">
                                            <b class="fa fa-money"></b>
                                        </span>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_fuelCard()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_fuelCard()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des cartes NAFTAL</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter une carte NAFTAL">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#fuelCard-modal"
                                    v-on:click="operation='add'">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="fuelCards-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th class="text-center">NUMERO DU CARTE</th>
                                <th class="text-center">DATE D'EXPIRATION</th>
                                <th class="text-center">DEBIT</th>
                                <th class="text-center">CREDIT</th>
                                <th class="text-center">VEHICULE</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(vehicle, index) in vehicles" :key="index" v-if="vehicle.fuel_card">
                                    <td>@{{ index+1}}</td>
                                    <td class="text-center" style="width:200px">@{{ vehicle.fuel_card.serial_number }}</td>
                                    <td class="text-center" style="width:100px">@{{ reFormatDate(vehicle.fuel_card.experation_date) }}</td>
                                    <td class="text-center" style="width:100px">@{{ vehicle.fuel_card.debit }}</td>
                                    <td class="text-center" style="width:100px">@{{ vehicle.fuel_card.credit }}</td>
                                    <td class="text-center" style="width:200px">@{{ vehicle.model.name.toUpperCase() +' - '+vehicle.licence_plate }}</td>
                                    <td style="width:70px"> 
                                         <div class="text-center">
                                            <span data-toggle="modal" data-target="#fuelCard-modal" v-on:click="edit_fuelCard(vehicle.id,vehicle.fuel_card,index)">
                                                <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="Modifier">
                                                </i>
                                            </span>
    
                                            <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_fuelCard(vehicle.fuel_card.id,index)"
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

            serial_number: '',
            debit: '',
            credit: '',
            experation_date: '',
            vehicle_id: '',
            modal_title: '',
            selectedFuelCardId:'',
            selectedFuelCardIndex:'',
            notifications:[],
            vehicles:[],
            errors: [],
        }
    },
    mounted() {
        this.fetch_notifications();
        this.fill_table('/getFuelCards', 'fuelCards-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#fuelCard-modal",
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
            this.fetch_vehicles(url, tableName).then((response) => {
               app.init_table(tableName);
               let option ='';
               app.vehicles.forEach(vehicle => {
                   option += '<option value="'+vehicle.id+'" >'+
                                vehicle.model.brand.name+' - '+
                                vehicle.model.name+' - '+
                                vehicle.licence_plate+' - '+
                                vehicle.energy_type.name
                            '</option>';
               });
                
                 $('#vehicles').html(option).selectpicker('refresh');
                app.unblock(tableName);
            });
        },
        fetch_vehicles(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    if (response.data.vehicles) {
                    app.vehicles = response.data.vehicles;
                    }
                })
                .catch();
        },
        delete_fuelCard(id, index) {
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
                        axios.delete('/fuelCards/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.fuelCards.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');

                                } else {
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    app.fill_table('/getFuelCards', 'fuelCards-table');
                                    app.reset_form();
                                }
                            });
                    }
                }
            )

        },
        edit_fuelCard(vehicle_id,fuelCard,index){
            this.selectedFuelCardId = fuelCard.id;
            this.selectedFuelCardIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier une carte NAFTAL";
            this.vehicle_id = vehicle_id;
            this.serial_number = fuelCard.serial_number;
            this.debit = fuelCard.debit;
            this.credit = fuelCard.credit;
            $('#experation-date').data('daterangepicker').setStartDate(reFormatDate(fuelCard.experation_date));
            $('#experation-date').data('daterangepicker').setEndDate(reFormatDate(fuelCard.experation_date));
            $('#vehicles').selectpicker('val',vehicle_id);
        },
        add_fuelCard() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter une carte NAFTAL";
            app.experation_date = formatDate($('#experation-date').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');

            

            axios.post('/fuelCards', {
                'serial_number': app.serial_number,
            'debit': app.debit,
            'credit': app.credit,
            'experation_date': app.experation_date,
           'vehicle_id': app.vehicle_id
            })
                .then(function (response) {

                    $('#fuelCard-modal').modal('hide');

                    app.fill_table('/getFuelCards', 'fuelCards-table');
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
        update_fuelCard() {
            var app = this;
            app.experation_date = formatDate($('#experation-date').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');

            axios.put('/fuelCards/'+app.selectedFuelCardId, {
                'serial_number': app.serial_number,
                'debit':  app.debit,
                'credit': app.credit,
                'experation_date': app.experation_date,
                'vehicle_id': app.vehicle_id

                })
                .then(function (response) {
                    $('#fuelCard-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getFuelCards', 'fuelCards-table');
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
            this.serial_number='';
            this.debit='';
            this.credit='';
            this.experation_date='';
            this.vehicle_id='';
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
