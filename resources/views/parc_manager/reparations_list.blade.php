@extends('layouts.base')

@section('page_title')
<h5>Liste des réparations</h5>
<span>Ajouter, modifer ou supprimer une réparation </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('reparations.index') }}">Liste des réparations</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="reparation-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter une réparation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-reparation-form">
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
                            <div class="form-group col-md-12 m-t-15">
                                <label for="-date" class="block">Mécanicien <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.mechanic_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.mechanic_id">
                                    <select id="mechanics" class="selectpicker show-tick text-center" title="Sélectionner un mécanicien.."
                                        data-width="100%" >


                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-12 m-t-15">
                                <label for=details" class="block">Détails <span class="text-danger">(*)</span></label>
                                <div :class="[errors.details ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="text" class="form-control " placeholder="Détails..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.details" v-model="details" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 m-t-15">
                                <label for=total" class="block">Coût <span class="text-danger">(*)</span></label>
                                <div :class="[errors.total ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="number" class="form-control " placeholder="Coût..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.total" v-model="total" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 m-t-15">
                                <label for="startedat" class="block">Date<span class="text-danger"> (*)</span></label>
                                <div :class="[errors.started_at ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="started_at" type="text" class="form-control date text-center" placeholder="Date du réparation..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.started_at"
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
                        v-on:click="add_reparation()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_reparation()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des réparations</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter une réparation">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#reparation-modal"
                                    v-on:click="operation='add'">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="reparations-table" class="table  table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:10px">#</th>
                                <th class="text-center">VEHICULE</th>
                                <th class="text-center">DATE DU REPARATION</th>
                                <th class="text-center">MECANICIEN</th>
                                <th class="text-center">DETAILS</th>
                                <th class="text-center">COUT</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(reparation, index) in reparations">
                                    <td style="width:10px">@{{ index+1  }}</td>
                                    <td class="text-center" style="width:200px">@{{ reparation.vehicle.model.brand.name.toUpperCase() +' - '+
                                    reparation.vehicle.model.name.toUpperCase() +' - '+reparation.vehicle.licence_plate }}</td>
                                    <td class="text-center" style="width:100px">@{{ reFormatDate(reparation.started_at) }}</td>
                                    <td class="text-center" style="width:100px">@{{ reparation.mechanic.fullname.toUpperCase() }}</td>
                                    <td class="text-left" style="width:100px;white-space:normal;">@{{ reparation.details.toUpperCase() }}</td>
                                    <td class="text-center" style="width:200px">@{{ reparation.total }}</td>
                                    <td style="width:70px">
                                         <div class="text-center">
                                            <span data-toggle="modal" data-target="#reparation-modal" v-on:click="edit_reparation(reparation,index)">
                                                <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="Modifier">
                                                </i>
                                            </span>
                                            <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_reparation(reparation.id,index)"
                                                data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                            </i>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                        <tfoot>
                                <tr>
                                    <th colspan="5"></th>
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

            total: '',
            started_at: '',
            vehicle_id: '',
            mechanic_id: '',
            details: '',
            modal_title: '',
            selectedReparationId:'',
            selectedReparationIndex:'',
            notifications:[],
            vehicles:[],
            mechanics:[],
            reparations:[],
            errors: [],
        }
    },
    mounted() {
        this.fetch_notifications();
        this.fill_table('/getReparations', 'reparations-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#reparation-modal",
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
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
               'TOTAL : '+  formatMoney(pageTotal) +' DA ' +'<br>'+ ' (TOTAL GLOBAL : '+ formatMoney(total) +' DA )'
            );
        },
                dom: 'Bfrtip',
                language: {
                    "decimal":        "",
                    "emptyTable":     "Aucune donnée disponible dans la table",
                    "info":           "Affichage de _START_ à _END_ depuis _TOTAL_ entrées ",
                    "infoEmpty":      "Affichange du 0 au 0 depuis 0 entrées",
                    "infoFiltered":   "(Filtrage du _MAX_ entrées totales)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Affichage _MENU_ entrées",
                    "loadingRecords": "Loading...",
                    "processing":     "Processing...",
                    "search":         "Rechercher:",
                    "zeroRecords":    "Aucun enregistrement correspondant trouvé",
                    "paginate": {
                        "first":      "Premier",
                        "last":       "Dernier",
                        "next":       "Suivant",
                        "previous":   "Précédent"
                    },
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
            this.fetch_reparations(url, tableName).then((response) => {
               app.init_table(tableName);
               let voption ='';
               let moption ='';
               app.vehicles.forEach(vehicle => {
                   voption += '<option value="'+vehicle.id+'" >'+
                                vehicle.model.brand.name+' - '+
                                vehicle.model.name+' - '+
                                vehicle.licence_plate+' - '+
                                vehicle.energy_type.name
                            '</option>';
               });
               app.mechanics.forEach(mechanic => {
                   moption += '<option value="'+mechanic.id+'" >'+
                                mechanic.fullname+
                            '</option>';
               });

                $('#vehicles').html(voption).selectpicker('refresh');
                $('#mechanics').html(moption).selectpicker('refresh');
                app.unblock(tableName);
            });
        },
        fetch_reparations(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    app.reparations = response.data.reparations;
                    app.vehicles = response.data.vehicles;
                    app.mechanics = response.data.mechanics;
                })
                .catch();
        },
        delete_reparation(id, index) {
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
                        axios.delete('/reparations/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.reparations.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');

                                } else {
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    app.fill_table('/getReparations', 'reparations-table');
                                    app.reset_form();
                                }
                            });
                    }
                }
            )

        },
        edit_reparation(reparation,index){
            this.selectedReparationId = reparation.id;
            this.selectedReparationIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier une réparation";
            this.vehicle_id = reparation.vehicle_id;
            this.mechanic_id = reparation.mechanic_id;
            this.details = reparation.details;
            this.total = reparation.total;
            $('#started_at').data('daterangepicker').setStartDate(reFormatDate(reparation.started_at));
            $('#started_at').data('daterangepicker').setEndDate(reFormatDate(reparation.started_at));
            $('#vehicles').selectpicker('val',this.vehicle_id);
            $('#mechanics').selectpicker('val',this.mechanic_id);
        },
        add_reparation() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter une réparation";
            app.started_at = formatDate($('#started_at').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');
            app.mechanic_id = $('#mechanics').selectpicker('val');



            axios.post('/reparations', {
            'total': app.total,
            'started_at': app.started_at,
            'vehicle_id': app.vehicle_id,
            'mechanic_id': app.mechanic_id,
            'details': app.details
            })
                .then(function (response) {

                    $('#reparation-modal').modal('hide');

                    app.fill_table('/getReparations', 'reparations-table');
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
        update_reparation() {
            var app = this;
            app.started_at = formatDate($('#started_at').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');
            app.mechanic_id = $('#mechanics').selectpicker('val');

            axios.put('/reparations/'+app.selectedReparationId, {
                'mechanic_id': app.mechanic_id,
                'total':  app.total,
                'details': app.details,
                'started_at': app.started_at,
                'vehicle_id': app.vehicle_id

                })
                .then(function (response) {
                    $('#reparation-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getReparations', 'reparations-table');
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
            this.mechanic_id='';
            this.total='';
            this.details='';
            this.started_at='';
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
