@extends('layouts.base')

@section('page_title')
<h5>Liste des services</h5>
<span>Ajouter, modifer ou supprimer une service </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('services.index') }}">Liste des services</a>
</li>
@endsection


@include('admin.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="service-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter une service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class=" modal-body ">
                    <form>

                        <div class="form-group col-md-12 m-t-15">
                            <label for=name" class="block">Nom du service <span class="text-danger">(*)</span></label>
                            <div :class="[errors.name ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                <input type="text" class="form-control " placeholder="Nom du service..." data-toggle="tooltip" data-placement="top" :data-original-title="errors.name" v-model="name" min="0">
                                <span class="input-group-addon">
                                    <b class="fa fa-money"></b>
                                </span>
                            </div>
                        </div>



                    </form>
                </div>

                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light " v-on:click="add_service()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light " v-on:click="update_service()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="row col-md-12 center">

    <div class="card col-md-5">
        <div class="card-header table-card-header">
            <h5 style="font-size:18px">Liste des services</h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li>
                        <span data-toggle="modal" data-target="#service-modal">
                            <i class="fa fa-plus faa-horizontal animated text-success " data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un service" style="font-size:22px" v-on:click="operation='add'">
                            </i>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="services-table" class="table  table-bordered ">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:1px">#</th>
                            <th style="width:auto">SERVICE</th>


                            <th class="text-center noExport" style="width:10px">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(service, index) in services" v-on:click="get_rubriques(service)">
                            <td style="width:10px">@{{ index+1 }}</td>
                            <td style="width:auto">@{{ service.name.toUpperCase() }}</td>



                            <td style="width:20px">
                                <div class="text-center">
                                    <span data-toggle="modal" data-target="#service-modal" v-on:click="edit_service(service,index)">
                                        <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip" data-placement="top" data-original-title="Modifier">
                                        </i>
                                    </span>
                                    <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_service(service.id,index)" data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                    </i>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

    </div>


    <div class="card col-md-5">
        <div class="card-header table-card-header">
            <h5 style="font-size:18px">Liste des rubriques</h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li>
                        <span data-toggle="modal" data-target="#rubrique-modal">
                            <i class="fa fa-plus faa-horizontal animated text-success " data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un service" style="font-size:22px" v-on:click="operation='add'">
                            </i>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="rubriques-table" class="table  table-bordered ">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:1px">#</th>
                            <th style="width:auto">SERVICE</th>


                            <th class="text-center noExport" style="width:10px">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(rubrique, index) in rubriques">
                            <td style="width:10px">@{{ index+1 }}</td>
                            <td style="width:auto">@{{ rubrique.name.toUpperCase() }}</td>



                            <td style="width:20px">
                                <div class="text-center">
                                    <span data-toggle="modal" data-target="#rubrique-modal" v-on:click="edit_service(service,index)">
                                        <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip" data-placement="top" data-original-title="Modifier">
                                        </i>
                                    </span>
                                    <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_service(service.id,index)" data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
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

                name: '',
                modal_title: '',
                selectedServiceId: '',
                selectedServiceIndex: '',
                notifications: [],
                notifications_fetched: false,
                service: null,

                rubriques: [],
                services: [],
                errors: [],
            }
        },
        mounted() {

            this.fill_table('/getServices', 'services-table');
            $('.date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                "parentEl": "#service-modal",
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
            // this.fetch_notifications();
        },
        methods: {
            fetch_notifications() {
                var app = this;

                app.notifications_fetched = false;
                return axios.get('/getNotifications')
                    .then(function(response) {
                        app.notifications = response.data.notifications;
                        app.notifications_fetched = true;
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
                        "decimal": "",
                        "emptyTable": "Aucun donnée disponible dans la table",
                        "info": "Affichage de _START_ à _END_ depuis _TOTAL_ entrées ",
                        "infoEmpty": "Affichange du 0 au 0 depuis 0 entrées",
                        "infoFiltered": "(Filtrage du _MAX_ entrées totales)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Affichage _MENU_ entrées",
                        "loadingRecords": "Loading...",
                        "processing": "Processing...",
                        "search": "Rechercher:",
                        "zeroRecords": "Aucun enregistrement correspondant trouvé",
                        "paginate": {
                            "first": "Premier",
                            "last": "Dernier",
                            "next": "Suivant",
                            "previous": "Précédent"
                        },
                    },

                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'EXCEL',
                        className: 'btn-inverse ',
                        footer: true,
                        exportOptions: {
                            columns: "thead th:not(.noExport)",
                        }

                    }, {

                        extend: 'print',
                        text: 'IMPRIMER',
                        className: 'btn-inverse',
                        footer: true,
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
                this.fetch_services(url, tableName).then((response) => {
                    app.init_table(tableName);

                    app.unblock(tableName);
                });
            },
            fetch_services(url, tableName) {
                var app = this;
                app.block(tableName);
                $('#' + tableName).DataTable().destroy();
                return axios.get(url)
                    .then(function(response) {
                        app.services = response.data.services;

                    })
                    .catch();
            },
            delete_service(id, index) {
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
                            axios.delete('/services/' + id)
                                .then(function(response) {
                                    if (response.data.error) {
                                        // app.services.splice(index,1)
                                        notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');

                                    } else {
                                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                        app.fill_table('/getServices', 'services-table');
                                        app.reset_form();
                                    }
                                });
                        }
                    }
                )

            },
            edit_service(service, index) {
                this.selectedServiceId = service.id;
                this.selectedServiceIndex = index;
                this.operation = 'edit';
                this.modal_title = "Modifier une service";
                this.service = this.services[this.selectedServiceId];
                console.log(this.service);
                this.name = service.name;





            },
            get_rubriques(service, index) {
                this.selectedServiceId = service.id;
                this.selectedServiceIndex = index;
                console.log(this.service);
                this.rubriques = service.rubriques;
                console.log(this.rubriques);





            },
            add_service() {
                var app = this;

                app.operation = 'add';
                app.modal_title = "Ajouter une service";



                axios.post('/services', {
                        'name': app.name,


                    })
                    .then(function(response) {

                        $('#service-modal').modal('hide');

                        app.fill_table('/getServices', 'services-table');
                        app.reset_form();

                    })
                    .catch(function(error) {
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
            update_service() {
                var app = this;


                axios.put('/services/' + app.selectedServiceId, {

                        'name': app.name,



                    })
                    .then(function(response) {
                        $('#service-modal').modal('hide');
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                        app.fill_table('/getServices', 'services-table');
                        app.reset_form();
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                            notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'topCenter', 'bounceInDown');
                        }
                    });
            },
            reset_form() {

                this.name = '';

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