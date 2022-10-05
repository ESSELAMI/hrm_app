@extends('layouts.base')

@section('page_title')
<h5>Liste des controles techniques</h5>
<span>Ajouter, modifer ou supprimer un controle technique </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('technicalControls.index') }}">Liste des controles techniques</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="technicalControl-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter un controle technique</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-technicalControl-form">
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
                                <label for="startedat" class="block">Date du controle<span class="text-danger"> (*)</span></label>
                                <div :class="[errors.performed_at ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="performed_at" type="text" class="form-control date text-center" placeholder="Date du controle..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.performed_at"
                                        >
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
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
                            {{-- <div class="form-group col-md-12 m-t-15">
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
                            </div> --}}
                            <div class="form-group col-md-7 m-t-15">
                                <label for="ends_at" class="block">Date du prochaine révision<span class="text-danger"> (*)</span></label>
                                <div :class="[errors.ends_at ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="ends_at" type="text" class="form-control date text-center" placeholder="Date du réparationdu prochaine révision..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.ends_at"
                                        >
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            

                            <div class="form-group col-md-12 m-t-15">
                                <label for="details" class="block">SOUS-RESERVES <span class="text-danger">(*) </span></label>
                                <input type="checkbox" class="js-small js-inverse"  v-model="has_details" data-switchery="true"  >
                                <div :class="[errors.details ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <textarea rows="5" cols="5" class="form-control" placeholder="Les résevres..."
                                    placeholder="Détails..." data-toggle="tooltip" data-placement="top"
                                     :data-original-title="errors.details" v-model="details" :disabled="!has_details"></textarea>
                                </div>
                            </div>
                            
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_technicalControl()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_technicalControl()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des controles techniques</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un controle technique">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#technicalControl-modal"
                                    v-on:click="operation='add'">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="technicalControls-table" class="table  table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:10px">#</th>
                                <th class="text-center">VEHICULE</th>
                                <th class="text-center">DATE DU CONTROLE</th>
                                <th class="text-center">COUT</th>
                                <th class="text-center">PROCHAINE REVISION</th>
                                <th class="text-center">ETAT</th>
                                <th class="text-center">LES RESERVES</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(technicalControl, index) in technicalControls">
                                    <td style="width:10px">@{{ index+1  }}</td>
                                    <td class="text-center" style="width:200px">@{{ technicalControl.vehicle.model.brand.name.toUpperCase() +' - '+
                                    technicalControl.vehicle.model.name.toUpperCase() +' - '+technicalControl.vehicle.licence_plate }}</td>
                                    <td class="text-center" style="width:100px">@{{ reFormatDate(technicalControl.performed_at) }}</td>
                                    <td class="text-center" style="width:auto">@{{ technicalControl.cost }}</td>
                                    <td class="text-center" style="width:100px">@{{ reFormatDate(technicalControl.ends_at) }}</td>
                                    <td v-if="!technicalControl.has_details" class="text-center"><i class="icofont icofont-ui-check text-success"></i> <p style="display:none">Oui</p></td>
                                    <td v-else class="text-center"><i class="icofont icofont-ui-close text-danger"></i><p style="display:none">Non</p></td>
                                
                                    <td v-if="technicalControl.details" class="text-left" style="width:200px;white-space:normal;">@{{ technicalControl.details.toUpperCase() }}</td>
                                    <td v-else class="text-left" style="width:100px;white-space:normal;"></td>
                                    
                                    <td style="width:70px">
                                         <div class="text-center">
                                            <span data-toggle="modal" data-target="#technicalControl-modal" v-on:click="edit_technicalControl(technicalControl,index)">
                                                <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="Modifier">
                                                </i>
                                            </span>
                                            <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_technicalControl(technicalControl.id,index)"
                                                data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                            </i>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                        <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th ><strong >TOTAL :</strong></th>
                                    <th colspan="4" ></th>
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
            has_details:false,

            cost: '',
            vehicle_id: '',
            performed_at: '',
            ends_at: '',
            details: '',
            modal_title: '',
            selectedTechnicalControlId:'',
            selectedTechnicalControlIndex:'',
            notifications:[],
            vehicles:[],
            technicalControls:[],
            errors: [],
        }
    },
    mounted() {
        this.fetch_notifications();
    var elemsmall = document.querySelector('.js-small');
	var switchery = new Switchery(elemsmall, { color: '#303548', jackColor: '#fff', size: 'small' });
        this.fill_table('/getTechnicalControls', 'technicalControls-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#technicalControl-modal",
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
            this.fetch_technicalControls(url, tableName).then((response) => {
               app.init_table(tableName);
               let voption ='';
               app.vehicles.forEach(vehicle => {
                   voption += '<option value="'+vehicle.id+'" >'+
                                vehicle.model.brand.name+' - '+
                                vehicle.model.name+' - '+
                                vehicle.licence_plate+' - '+
                                vehicle.energy_type.name
                            '</option>';
               });


                $('#vehicles').html(voption).selectpicker('refresh');
                app.unblock(tableName);
            });
        },
        fetch_technicalControls(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    app.technicalControls = response.data.technicalControls;
                    app.vehicles = response.data.vehicles;
                })
                .catch();
        },
        delete_technicalControl(id, index) {
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
                        axios.delete('/technicalControls/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.technicalControls.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');

                                } else {
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    app.fill_table('/getTechnicalControls', 'technicalControls-table');
                                    app.reset_form();
                                }
                            });
                    }
                }
            )

        },
        edit_technicalControl(technicalControl,index){
            this.reset_form();
            this.selectedTechnicalControlId = technicalControl.id;
            this.selectedTechnicalControlIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier un controle technique";
            this.vehicle_id = technicalControl.vehicle_id;
            this.performed_at = technicalControl.performed_at;
            this.ends_at = technicalControl.ends_at;
            this.details = technicalControl.details;
            this.cost = technicalControl.cost;
            this.has_details = technicalControl.has_details;
            $('#performed_at').data('daterangepicker').setStartDate(reFormatDate(technicalControl.performed_at));
            $('#performed_at').data('daterangepicker').setEndDate(reFormatDate(technicalControl.performed_at));
            $('#ends_at').data('daterangepicker').setStartDate(reFormatDate(technicalControl.ends_at));
            $('#ends_at').data('daterangepicker').setEndDate(reFormatDate(technicalControl.ends_at));
            $('#vehicles').selectpicker('val',this.vehicle_id);
            
        },
        add_technicalControl() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter un controle technique";
            app.performed_at = formatDate($('#performed_at').data('daterangepicker').startDate);
            app.ends_at = formatDate($('#ends_at').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');
            



            axios.post('/technicalControls', {
            'cost': app.cost,
            'performed_at': app.performed_at,
            'ends_at': app.ends_at,
            'has_details': app.has_details,
            'vehicle_id': app.vehicle_id,
            'details': app.details
            })
                .then(function (response) {

                    $('#technicalControl-modal').modal('hide');

                    app.fill_table('/getTechnicalControls', 'technicalControls-table');
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
        update_technicalControl() {
            var app = this;
            app.performed_at = formatDate($('#performed_at').data('daterangepicker').startDate);
            app.ends_at = formatDate($('#ends_at').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');
            

            axios.put('/technicalControls/'+app.selectedTechnicalControlId, {
                'cost': app.cost,
                'performed_at': app.performed_at,
                'ends_at': app.ends_at,
                'has_details': app.has_details,
                'vehicle_id': app.vehicle_id,
                'details': app.details

                })
                .then(function (response) {
                    $('#technicalControl-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getTechnicalControls', 'technicalControls-table');
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
            this.has_details= false;
            this.cost='';
            this.details='';
            this.performed_at='';
            this.ends_at='';
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
