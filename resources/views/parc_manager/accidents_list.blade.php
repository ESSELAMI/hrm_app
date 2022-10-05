@extends('layouts.base')

@section('page_title')
<h5>Liste des accidents</h5>
<span>Ajouter, modifer ou supprimer un accident </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('accidents.index') }}">Liste des accidents</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="accident-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter un accident</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-accident-form">
                            <div class="form-group col-md-6 m-t-15">
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
                            <div class="form-group col-md-6 m-t-15">
                                <label for="-date" class="block">Chauffeur <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.vehicle_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.vehicle_id">
                                    <select id="drivers" class="selectpicker show-tick text-center" title="Sélectionner un chauffeur.."
                                        data-width="100%" >


                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 m-t-15">
                                <label for="card-number" class="block">Date d'accident<span class="text-danger"> (*)</span></label>
                                <div :class="[errors.bought_at ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="occured_at" type="text" class="form-control date text-center" placeholder="Date d'accident..."
                                        data-toggle="tooltip" data-placement="top" :data-original-title="errors.bought_at"
                                        >
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-8 m-t-15">
                                <label for=location" class="block">Lieu d'accident <span class="text-danger">(*)</span></label>
                                <div :class="[errors.location ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="text" class="form-control " placeholder="Lieu d'accident..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.location" v-model="location" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-12 m-t-15">
                                <label for=details" class="block">Détails de l'accident <span class="text-danger">(*)</span></label>
                                <div :class="[errors.details ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="text" class="form-control " placeholder="Détails de l'accident..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.details" v-model="details" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            {{-- <div class="form-group col-md-5 m-t-15">
                                <label for=cost" class="block">Kilométrage <span class="text-danger">(*)</span></label>
                                <div :class="[errors.cost ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="number" class="form-control " placeholder="Kilométrage..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.cost" v-model="cost" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div> --}}
                            {{-- <div class="form-group col-md-5 m-t-15">
                                <label for=cost" class="block">Nombre de blessés <span class="text-danger">(*)</span></label>
                                <div :class="[errors.cost ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="number" class="form-control " placeholder="Nombre de blessés..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.cost" v-model="cost" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div> --}}
                            {{-- <div class="form-group col-md-5 m-t-15">
                                <label for=cost" class="block">Nombre de morts <span class="text-danger">(*)</span></label>
                                <div :class="[errors.cost ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="number" class="form-control " placeholder="Nombre de morts..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.cost" v-model="cost" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div> --}}

                        <div class="form-group col-sm-6"  >
                            <label for="-date" class="block">Constat de l'accident <span class="text-danger">(*) </span></label>
                            <div :class="[errors.report_file ? '  input-group input-group-danger' : ' input-group input-group-inverse']" v-on:click="$('#files').click()">
                                <input id="report-file" name="reportfile" type="text" class="form-control bg-white" placeholder="Constat d'accident scanné..."
                                data-toggle="tooltip" data-placement="top"
                                :data-original-title="errors.report_file" readonly >
                                <span class="input-group-addon">
                                    <i class="icofont icofont-file-pdf"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 form-group-danger" style="display:none">
                            <label for="reportfile" class="block">Constat de l'accident <span class="text-danger">(*) </span></label>
                            <div :class="[errors.report_file ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.report_file">
                                <input type="file" id="files" ref="files" name="report_file"
                                    v-on:change="handleFilesUpload()"  />
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_accident()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_accident()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des accidents</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un accident">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px" data-toggle="modal" data-target="#accident-modal"
                                    v-on:click="operation='add'">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="accidents-table" class="table  table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:10px">#</th>
                                <th class="text-center">VEHICULE</th>
                                <th class="text-center">CHAUFFEUR</th>
                                <th class="text-center">DATE</th>
                                <th class="text-center">LIEU</th>
                                <th class="text-center">DETAILS</th>
                                {{-- <th class="text-center">MORTS</th> --}}
                                {{-- <th class="text-center">BLESSES</th> --}}
                                <th class="text-center">CONSTAT</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(accident, index) in accidents">
                                    <td style="width:10px">@{{ index+1  }}</td>
                                    <td class="text-center" style="width:200px">@{{ accident.vehicle.model.brand.name.toUpperCase() + ' - '+
                                        accident.vehicle.model.name.toUpperCase() +' - '+accident.vehicle.licence_plate }}</td>
                                    <td class="text-center" style="width:100px">@{{ accident.driver.fullname.toUpperCase() }}</td>
                                    <td class="text-center" style="width:100px">@{{ reFormatDate(accident.occured_at) }}</td>
                                    <td class="text-center" style="width:100px">@{{ accident.location.toUpperCase() }}</td>
                                    <td class="text-left" style="width:100px;white-space:normal;">@{{ accident.details.toUpperCase() }}</td>
                                    <td class="text-center" style="width:100px">
                                        <a :href="'storage/'+accident.report_url" target="_blank" class="text-warning f-17">CONSTAT
                                            <i :class="[report_url == null ? '  icofont icofont-file-pdf  text-default' : 'icofont icofont-file-pdf text-warning f-16']" ></i>
                                        </a></td>
                                    <td style="width:70px">
                                         <div class="text-center">
                                            <span data-toggle="modal" data-target="#accident-modal" v-on:click="edit_accident(accident,index)">
                                                <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="Modifier">
                                                </i>
                                            </span>
                                            <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_accident(accident.id,index)"
                                                data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                            </i>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                        {{-- <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th colspan="2" ><strong >TOTAL :</strong></th>
                                </tr>
                        </tfoot> --}}
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

            location: '',
            details: '',
            report_file: '',
            report_file_name: '',
            report_url: '',
            occured_at: '',
            vehicle_id: '',
            driver_id: '',
            modal_title: '',
            selectedAccidentId:'',
            selectedAccidentIndex:'',
            notifications:[],
            vehicles:[],
            drivers:[],
            accidents:[],
            errors: [],
        }
    },
    mounted() {
        this.fetch_notifications();
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
                    feedback: "Constat d'accident scanné...",
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
        this.fill_table('/getAccidents', 'accidents-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#accident-modal",
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
                    // footer:true,
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
            this.fetch_accidents(url, tableName).then((response) => {
               app.init_table(tableName);
               let voption ='';
               let doption ='';
               app.vehicles.forEach(vehicle => {
                   voption += '<option value="'+vehicle.id+'" >'+
                                vehicle.model.brand.name+' - '+
                                vehicle.model.name+' - '+
                                vehicle.licence_plate+' - '+
                                vehicle.energy_type.name
                            '</option>';
               });
               app.drivers.forEach(driver => {
                   doption += '<option value="'+driver.id+'" >'+
                                driver.fullname+
                            '</option>';
               });

                $('#vehicles').html(voption).selectpicker('refresh');
                $('#drivers').html(doption).selectpicker('refresh');
                app.unblock(tableName);
            });
        },
        fetch_accidents(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    app.accidents = response.data.accidents;
                    app.vehicles = response.data.vehicles;
                    app.drivers = response.data.drivers;
                })
                .catch();
        },
        delete_accident(id, index) {
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
                        axios.delete('/accidents/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.accidents.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');

                                } else {
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    app.fill_table('/getAccidents', 'accidents-table');
                                    app.reset_form();
                                }
                            });
                    }
                }
            )

        },
        edit_accident(accident,index){
            this.selectedAccidentId = accident.id;
            this.selectedAccidentIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier un accident";
            this.vehicle_id = accident.vehicle_id;
            this.driver_id = accident.driver_id;
            this.details = accident.details;
            this.location = accident.location;
            this.occured_at = accident.occured_at;

            app.report_file = 'storage/'+accident.report_url;

            $('#occured_at').data('daterangepicker').setStartDate(reFormatDate(accident.occured_at));
            $('#occured_at').data('daterangepicker').setEndDate(reFormatDate(accident.occured_at));
            $('#vehicles').selectpicker('val',this.vehicle_id);
            $('#drivers').selectpicker('val',this.driver_id);

        },

        add_accident() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter un accident";

            app.occured_at = formatDate($('#occured_at').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');
            app.driver_id = $('#drivers').selectpicker('val');
            app.report_file = app.$refs.files.files[0];

            let formData = new FormData();

            formData.append('vehicle_id', app.vehicle_id);
            formData.append('driver_id', app.driver_id);
            formData.append('occured_at', app.occured_at);
            formData.append('location', app.location);
            formData.append('details', app.details);

            formData.append('report_file', app.report_file);
            axios.post('/accidents', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {

                $('#accident-modal').modal('hide');

                app.fill_table('/getAccidents', 'accidents-table');
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
        update_accident() {
            var app = this;
            app.occured_at = formatDate($('#occured_at').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');
            app.driver_id = $('#drivers').selectpicker('val');

            app.report_file = app.$refs.files.files[0];

            let formData = new FormData();

            formData.append('vehicle_id', app.vehicle_id);
            formData.append('driver_id', app.driver_id);
            formData.append('occured_at', app.occured_at);
            formData.append('location', app.location);
            formData.append('details', app.details);

            formData.append('report_file', app.report_file);

            axios.post('/update_accident/'+app.selectedAccidentId, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(function (response) {
                    $('#accident-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getAccidents', 'accidents-table');
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
            this.vehicle_id = '';
            this.driver_id = '';
            this.occured_at = '';
            this.location = '';
            this.details = '';

            this.report_file='';
            this.modal_title = '';
            this.errors = [];
        },
        handleFilesUpload() {
                this.report_file = this.$refs.files.files;
                this.report_file_name = this.report_file[0].name;
                $('#report-file').val(this.report_file_name);

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
