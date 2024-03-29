@extends('layouts.base')

@section('page_title')
<h5>Liste des vignettes</h5>
<span>Ajouter, modifer ou supprimer une vignette </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('annualTaxes.index') }}">Liste des vignettes</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="annualTax-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter une vignette</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-annualTax-form">
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
                            <div class="form-group col-md-5 m-t-15">
                                <label for=cost" class="block">Coût <span class="text-danger">(*)</span></label>
                                <div :class="[errors.cost ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="number" class="form-control " placeholder="Coût..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.cost" v-model="cost" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-7 m-t-15">
                                <label for="card-number" class="block">Date d'achat<span class="text-danger"> (*)</span></label>
                                <div :class="[errors.bought_at ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="experation-date" type="text" class="form-control date text-center" placeholder="Date d'expiration..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.bought_at"
                                        >
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
                        v-on:click="add_annualTax()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_annualTax()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des vignettes</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter une vignette">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#annualTax-modal"
                                    v-on:click="operation='add'">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="annualTaxes-table" class="table  table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:10px">#</th>
                                <th class="text-center">VEHICULE</th>
                                <th class="text-center">DATE D'ACHAT DU VIGNETTE</th>
                                <th class="text-center">COUT</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(annual_tax, index) in annualTaxes">
                                    <td style="width:10px">@{{ index+1  }}</td>
                                    <td class="text-center" style="width:200px">@{{ annual_tax.vehicle.model.name.toUpperCase() +' - '+annual_tax.vehicle.licence_plate }}</td>
                                    <td class="text-center" style="width:100px">@{{ reFormatDate(annual_tax.bought_at) }}</td>
                                    <td class="text-center" style="width:200px">@{{ annual_tax.cost }}</td>
                                    <td style="width:70px"> 
                                         <div class="text-center">
                                            <span data-toggle="modal" data-target="#annualTax-modal" v-on:click="edit_annualTax(annual_tax.vehicle.id,annual_tax,index)">
                                                <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="Modifier">
                                                </i>
                                            </span>
                                            <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_annualTax(annual_tax.id,index)"
                                                data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                            </i>
                                        </div> 
                                    </td>
                                </tr> 
                        </tbody>
                        <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th colspan="2" ><strong >TOTAL :</strong></th>
                                </tr>
                        </tfoot>
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
            
            cost: '',
            bought_at: '',
            vehicle_id: '',
            modal_title: '',
            selectedAnnualTaxId:'',
            selectedAnnualTaxIndex:'',
            notifications:[],
            vehicles:[],
            annualTaxes:[],
            errors: [],
        }
    },
    mounted() {
        this.fetch_notifications();
        this.fill_table('/getAnnualTaxes', 'annualTaxes-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#annualTax-modal",
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
                "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
               'TOTAL : '+  formatMoney(pageTotal) +' DA ' +'<br>'+ ' (TOTAL GLOBAL : '+ formatMoney(total) +' DA )'
            );
        },      
                dom: 'Bfrtip',
                language: {
                },
                buttons: [{
                    extend: 'excelHtml5',
                    text: 'EXCEL',
                    className: 'btn-inverse ',
                    footer:true,
                    exportOptions: {
                        columns: "thead th:not(.noExport)",
                    }

                }, {

                    extend: 'print',
                    text: 'IMPRIMER',
                    className: 'btn-inverse',
                    footer:true,
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
            this.fetch_annualTaxes(url, tableName).then((response) => {
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
        fetch_annualTaxes(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    app.annualTaxes = response.data.annualTaxes;
                    app.vehicles = response.data.vehicles;
                })
                .catch();
        },
        delete_annualTax(id, index) {
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
                        axios.delete('/annualTaxes/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.annualTaxes.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');

                                } else {
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    app.fill_table('/getAnnualTaxes', 'annualTaxes-table');
                                    app.reset_form();
                                }
                            });
                    }
                }
            )

        },
        edit_annualTax(vehicle_id,annualTax,index){
            this.selectedAnnualTaxId = annualTax.id;
            this.selectedAnnualTaxIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier une vignette";
            this.vehicle_id = vehicle_id;
            this.serial_number = annualTax.serial_number;
            this.cost = annualTax.cost;
            this.credit = annualTax.credit;
            $('#experation-date').data('daterangepicker').setStartDate(reFormatDate(annualTax.bought_at));
            $('#experation-date').data('daterangepicker').setEndDate(reFormatDate(annualTax.bought_at));
            $('#vehicles').selectpicker('val',vehicle_id);
        },
        add_annualTax() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter une vignette";
            app.bought_at = formatDate($('#experation-date').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');

            

            axios.post('/annualTaxes', {
            'cost': app.cost,
            'bought_at': app.bought_at,
            'vehicle_id': app.vehicle_id
            })
                .then(function (response) {

                    $('#annualTax-modal').modal('hide');

                    app.fill_table('/getAnnualTaxes', 'annualTaxes-table');
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
        update_annualTax() {
            var app = this;
            app.bought_at = formatDate($('#experation-date').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');

            axios.put('/annualTaxes/'+app.selectedAnnualTaxId, {
                'serial_number': app.serial_number,
                'cost':  app.cost,
                'credit': app.credit,
                'bought_at': app.bought_at,
                'vehicle_id': app.vehicle_id

                })
                .then(function (response) {
                    $('#annualTax-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getAnnualTaxes', 'annualTaxes-table');
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
            this.cost='';
            this.credit='';
            this.bought_at='';
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
