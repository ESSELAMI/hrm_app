@extends('layouts.base')

@section('page_title')
<h5>Liste des fonctions</h5>
<span>Ajouter, modifer ou supprimer une fonction </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('fonctions.index') }}">Liste des fonctions</a>
</li>
@endsection


@include('user.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="fonction-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter une fonction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <div class=" modal-body ">
                    <form>
     
                            <div class="form-group col-md-12 m-t-15">
                                <label for=name" class="block">Nom du fonction <span class="text-danger">(*)</span></label>
                                <div :class="[errors.name ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input  type="text" class="form-control " placeholder="Nom du fonction..." data-toggle="tooltip"
                                    data-placement="top" :data-original-title="errors.name" v-model="name" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 m-t-15">
                                <label for=category" class="block">Categorie <span class="text-danger">(*)</span></label>
                                <div :class="[errors.category ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <select id="categories" class="selectpicker show-tick text-center"
                                    title="Se rendre à..." data-width="100%"  v-model='category_id'
                                    data-live-search="true" data-style="btn-default">
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}" title="{{$category->number}}">{{ $category->number }}</option>
                                    @endforeach

                                </select>
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 m-t-15">
                                <label for=section" class="block">Section <span class="text-danger">(*)</span></label>
                                <div :class="[errors.section ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <select id="sections" class="selectpicker show-tick text-center"
                                    title="Se rendre à..." data-width="100%"  v-model='section_id'
                                    data-live-search="true" data-style="btn-default">
                                    @foreach ($sections as $section)
                                    <option value="{{$section->id}}" title="{{$section->number}}">{{ $section->number }}</option>
                                    @endforeach

                                </select>
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>
                        
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_fonction()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_fonction()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:18px">Liste des fonctions</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span   data-toggle="modal" data-target="#fonction-modal">
                                <i class="fa fa-plus faa-horizontal animated text-success " data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un fonction"
                                 style="font-size:22px" 
                                    v-on:click="operation='add'">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="fonctions-table" class="table  table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:1px">#</th>
                                <th style="width:auto">FONCTION</th>
                                <th style="width:5px">CATEGORIE</th>
                                <th style="width:5px">SECTION</th>
                                
                                <th class="text-center noExport" style="width:10px">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(fonction, index) in fonctions">
                                    <td style="width:10px">@{{ index+1 }}</td>
                                    <td  style="width:auto">@{{ fonction.name.toUpperCase() }}</td>
                                    <td  style="width:5px">@{{ fonction.category.number }}</td>
                                    <td  style="width:5px">@{{ fonction.section.number }}</td>
                                    
                                    <td style="width:20px">
                                         <div class="text-center">
                                            <span data-toggle="modal" data-target="#fonction-modal" v-on:click="edit_fonction(fonction,index)">
                                                <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="Modifier">
                                                </i>
                                            </span>
                                            <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_fonction(fonction.id,index)"
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

            name: '',
            modal_title: '',
            selectedFonctionId:'',
            selectedFonctionIndex:'',
            notifications: [],
                notifications_fetched: false,
            sections:[],
            categories:[],
            section_id:'',
            category_id:'',
            fonctions:[],
            errors: [],
        }
    },
    mounted() {
        
        this.fill_table('/getFonctions', 'fonctions-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#fonction-modal",
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
                
                app.notifications_fetched =  false;
                return axios.get('/getNotifications')
                    .then(function (response) {
                        app.notifications = response.data.notifications;
                        app.notifications_fetched =  true;
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
                    "decimal":        "",
                    "emptyTable":     "Aucun donnée disponible dans la table",
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
            this.fetch_fonctions(url, tableName).then((response) => {
                app.init_table(tableName);
                
                app.unblock(tableName);
            });
        },
        fetch_fonctions(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    app.fonctions = response.data.fonctions;
                   
                })
                .catch();
        },
        delete_fonction(id, index) {
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
                        axios.delete('/fonctions/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.fonctions.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');

                                } else {
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    app.fill_table('/getFonctions', 'fonctions-table');
                                    app.reset_form();
                                }
                            });
                    }
                }
            )

        },
        edit_fonction(fonction,index){
            this.selectedFonctionId = fonction.id;
            this.selectedFonctionIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier une fonction";

            this.name = fonction.name;
              $('#sections').selectpicker('val',fonction.section_id);
            $('#categories').selectpicker('val',fonction.category_id);


           
        },
        add_fonction() {
            var app = this;

            app.operation = 'add';
            app.modal_title = "Ajouter une fonction";
           app.category_id =  $('#categories').selectpicker('val');
           app.section_id = $('#sections').selectpicker('val');


            axios.post('/fonctions', {
            'name': app.name,
            'category_id': app.category_id,
            'section_id': app.section_id,
           
            })
                .then(function (response) {

                    $('#fonction-modal').modal('hide');

                    app.fill_table('/getFonctions', 'fonctions-table');
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
        update_fonction() {
            var app = this;
            app.category_id =  $('#categories').selectpicker('val');
           app.section_id = $('#sections').selectpicker('val');

            axios.put('/fonctions/'+app.selectedFonctionId, {
                
                'name':  app.name,
                'category_id':  app.category_id,
                'section_id':  app.section_id,
                

                })
                .then(function (response) {
                    $('#fonction-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getFonctions', 'fonctions-table');
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
            
            this.name='';
             $('#categories').selectpicker('val',null);
           $('#sections').selectpicker('val',null);
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
