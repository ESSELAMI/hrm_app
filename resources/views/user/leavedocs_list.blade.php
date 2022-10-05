@extends('layouts.base')

@section('page_title')
<h5>Liste des bons de sortie</h5>
<span>Ajouter, modifer ou supprimer un bon de sortie </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('leavedocs.index') }}">Liste des bons de sortie</a>
</li>
@endsection
{{-- <style>
    .table tbody td {
    vertical-align: middle;
    font-size: 12px
  }
</style> --}}

@include('user.navigation')


@section('page_content')
<div class="row ">


    <div class="modal fade" id="leavedoc-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                <h5 class="modal-title"  :title="modal_title">@{{modal_title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row" id="add-leavedoc-form">

                            <div class="form-group col-md-12 m-t-15">
                                <label for="-date" class="block">Agent CNAS <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.agent_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.agent_id"
                                    data-live-search="true">
                                    <select id="agents" class="selectpicker show-tick text-center"
                                        title="Sélectionner un agent.." data-width="100%" data-live-search="true"
                                        data-style="btn-default" data-size="10">
                                        @foreach ($agents as $agent)
                                        <option value="{{$agent->id}}"
                                            >
                                            {{ $agent->firstname .' '. $agent->lastname}}</option>
                                        @endforeach

                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-md-12 ">
                                <label for="leave_date" class="block">Date de sortie<span class="text-danger">
                                        (*)</span></label>
                                <div
                                    :class="[errors.leave_date ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="leave_date" type="text" class="form-control date text-center"
                                        placeholder="Date départ..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.leave_date">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="leave_time" class="block">Heure départ<span class="text-danger">
                                        (*)</span></label>
                                <div
                                    :class="[errors.leave_time ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <div class='input-group'>
                                        <input class="form-control text-center " type="time" id="leave_time"
                                            v-model="leave_time">
                                        <span class="input-group-addon ">
                                            <span class="icofont icofont-ui-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="return_time" class="block">Heure de retour<span class="text-danger">
                                        (*)</span></label>
                                <div
                                    :class="[errors.return_time ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <div class='input-group'>
                                        <input class="form-control text-center " type="time" id="return_time"
                                            v-model="return_time">
                                        <span class="input-group-addon ">
                                            <span class="icofont icofont-ui-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="leave_reason" class="block">Motif <span class="text-danger">
                                        (*)</span></label>
                                <div :class="[errors.leave_reason ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top"
                                    :data-original-title="errors.leave_reason">
                                    <select id="reasons" class="selectpicker show-tick text-center"
                                        title="Motif d'absence..." data-width="100%" v-model="reason"
                                        data-style="btn-default">
                                        <option value="AP">AFFAIRE PERSONNELLE</option>
                                        <option value="RS">RAISON DE SERVICE</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 " v-if="reason == 'RS' ">
                                <label for="details" class="block">L'objet de deplacement
                                    {{-- <span class="text-danger">
                                        (*)</span> --}}
                                </label>
                                <div :class="[errors.details ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.reference">
                                    <input id="details" type="text" class="form-control "
                                        placeholder="L'objet de deplacement..." data-toggle="tooltip"
                                        data-placement="top" v-model='details'
                                        :data-original-title="errors.details">
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_leavedoc()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="update_leavedoc()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>


    <!-- right column start -->
    <div class="col-lg-12 col-xl-12">
        <!-- Filter card start -->
        <div class="card">
            <div class="card-header">
                <h5><i class="icofont icofont-filter m-r-5"></i>Recherche détaillé</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span>
                                <i class="fa fa-refresh faa-spin animated text-warning " data-toggle="tooltip"
                                    data-placement="top" data-original-title="Actualiser" style="font-size:18px"
                                    id="refresh">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">

                <form class="row" action="#">
                    <div class="form-group col-sm-3 ">
                        {{-- <label for="drivers" class="block">Agent CNAS</label> --}}
                        <div class="input-group input-group-inverse">
                            <select id="f-agents" class="selectpicker show-tick text-center"
                                title="Sélectionner un agent CNAS.." data-width="100%" data-style="btn-default"
                                data-size="5">


                            </select>

                            <span class="input-group-addon">
                                <i class="icofont icofont-user"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        {{-- <label for="demo" class="block">Date</label> --}}
                        <div class="input-group input-group-inverse">
                            <input type="text" id="demo" class="form-control" style="height:41px">
                            <span class="input-group-addon">
                                <i class="icofont icofont-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        
                        <div class="input-group input-group-inverse">
                            <select id="f-responsables" class="selectpicker show-tick text-center"
                                title="Sélectionner un responsable.." data-width="100%" data-style="btn-default">


                            </select>

                            <span class="input-group-addon">
                                <i class="icofont icofont-list"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        
                        <div class="input-group input-group-inverse">
                            <select id="f-motif" class="selectpicker show-tick text-center"
                                title="Sélectionner un responsable.." data-width="100%" data-style="btn-default">
                                <option value="AP">AFFAIRE PERSONNELLE</option>
                                <option value="RS">RAISON DE SERVICE</option>

                            </select>

                            <span class="input-group-addon">
                                <i class="icofont icofont-list"></i>
                            </span>
                        </div>
                    </div>


                </form>
            </div>
        </div>
        <!-- Filter card end -->



    </div>
    <!-- right column end -->

    <div class="col-lg-12 col-xl-12 col-md-12">
        <!-- Job description card start -->
        <div class="card " style="overflow-x:hidden;">
            <div class="card-header table-card-header">
                <h5><i class="icofont icofont-list m-r-5"></i>Liste des bons de sortie</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <!-- <li v-on:click="calculate_fees_for_all();
                        ">
                            <span >
                                <i class="fa fa-calculator faa-vertical animated text-info " data-toggle="tooltip"
                                    data-placement="top" data-original-title="Decomptes" style="font-size:22px"
                                    v-on:click="calculate_fees_for_all();
                                    ">
                                </i>
                            </span>
                        </li> -->
                        <li v-on:click="operation='add';
                        clearInputs()">
                            <span data-toggle="modal" data-target="#leavedoc-modal">
                                <i class="fa fa-plus faa-horizontal animated text-success " data-toggle="tooltip"
                                    data-placement="top" data-original-title="Ajouter un bon de sortie"
                                    style="font-size:22px" v-on:click="operation='add';
                                    clearInputs()">
                                </i>
                            </span>
                        </li>


                    </ul>
                </div>
            </div>

            <div class="card-block ">
                <div class="dt-responsive table-responsive ">
                    <table id="leavedocs-table" class="table table-bordered dataex-colvis-exclude "
                        style="width:100%;font-size:12px;">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center noExport">ACTION</th>
                                <th class="text-center ">AGENT</th>
                                <th class="text-center ">RESPONSABLE</th>
                                <th class="text-center">DATE SORTIE</th>
                                <th class="text-center">HEURE SORTIE</th>
                                <th class="text-center">HEURE RETOUR</th>
                                <th class="text-center">MOTIF - OBJET DEPLACEMENT</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <tr v-for="(leavedoc, index) in leavedocs">
                                <td style="width:20px"></td>
                                <td class="text-center ">
                                    <div class="dropdown-secondary dropdown ">
                                        <button
                                            class="btn btn-inverse btn-mini dropdown-toggle waves-light b-none txt-muted "
                                            type="button" id="dropdown11" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"><i class="icofont icofont-options f-16"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdown11"
                                            data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"
                                            x-placement="top-start"
                                            style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a data-toggle="modal" data-target="#leavedoc-modal"
                                                class="dropdown-item waves-light waves-effect clickable"
                                                v-on:click="edit_leavedoc(leavedoc,index)"><i
                                                    class="icofont icofont-ui-edit f-18"></i> Modifier</a>
                                            {{-- <a class="dropdown-item waves-light waves-effect clickable" v-on:click="print_leavedoc_fr(leavedoc)"><i --}}
                                            <a class="dropdown-item waves-light waves-effect clickable"
                                                v-on:click="print_leavedoc_fr(leavedoc)"
                                                {{-- data-toggle="modal" data-target="#leavedoc-preview"><i --}}>
                                                <i class="icofont icofont-print f-18"></i> Imprimer</a>
                                            {{-- <a class="dropdown-item waves-light waves-effect clickable" v-on:click="calculate_fees(leavedoc);"><i
                                                    class="icofont icofont-ui-calculator f-18"></i> Decompte</a> --}}
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-light waves-effect clickable text-danger"
                                                v-on:click="delete_leavedoc(leavedoc.id,index)"><i
                                                    class="feather icon-trash text-danger f-18"></i> Supprimer</a>
                                        </div>
                                        <!-- end of dropdown menu -->
                                    </div>
                                </td>

                                <td class="text-center " style="width:auto;vertical-align:middle">
                                    @{{ leavedoc.agent.firstname.toUpperCase() + ' ' +leavedoc.agent.lastname.toUpperCase()}}

                                </td>

                                <td class="text-center " style="width:auto;vertical-align:middle">
                                    @{{ leavedoc.responsable.fullname.toUpperCase() }}

                                </td>
                                <td class="text-center " style="vertical-align:middle">
                                    @{{ reFormatDate(leavedoc.leave_date) }}
                                </td>
                                <td class="text-center " style="vertical-align:middle">
                                    @{{ reFormatTime(leavedoc.leave_time) }}
                                </td>

                                <td class="text-center " style="vertical-align:middle">
                                    @{{ reFormatTime(leavedoc.return_time) }}
                                </td>

                                <td class="text-center " style="vertical-align:middle" v-if="leavedoc.details">
                                    @{{ leavedoc.reason + ' - ' + leavedoc.details  }}</td>
                                <td class="text-center " style="vertical-align:middle" v-else>
                                    @{{ leavedoc.reason   }}</td>

                            </tr>
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                


                            </tr>
                        </tfoot> --}}
                    </table>
                </div>
            </div>
        </div>


    </div>
    <!-- Left column end -->



</div>


@endsection

@section('page_scripts')


<script>
    const app = new Vue({
        el: '#app',
        data() {
            return {
                operation: '',
                selected_leavedoc: '',
                reason: '',
                reference: '',
                details: '',
                // responsable: '',
                leave_time: '',
                agent_id: '',
                return_time: '',
                leave_date: '',

                modal_title: '',
                selectedLeaveDocId: '',
                selectedLeaveDocIndex: '',
                notifications: [],

                notifications_fetched:false,

                leavedocs: [],

                errors: [],
            }
        },

        mounted() {
            $(document).ready(function () {

                $('#refresh').on('click', function () {
                    // $('#demo').data('daterangepicker').setStartDate('01/01/1900')
                    // $('#demo').data('daterangepicker').setEndDate(new Date())
                    $('#demo').val("");
                    $("#leavedocs-table").DataTable().search("").draw();
                    $('#f-agents').selectpicker('val', null);
                    $('#f-motif').selectpicker('val', null);
                    $('#f-responsables').selectpicker('val', null);

                });
                $('#demo').on('cancel.daterangepicker', function (ev, picker) {
                    $('#demo').data('daterangepicker').setStartDate('01/01/1900')
                    $('#demo').data('daterangepicker').setEndDate(new Date())
                    $('#demo').val("");
                });
                $('#demo').on("change", function () {


                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {

                            var min = new Date($('#demo').data('daterangepicker').startDate
                                .format('YYYY-MM-DD'));
                            var max = new Date($('#demo').data('daterangepicker').endDate
                                .format('YYYY-MM-DD'));
                            min = moment(min).format('YYYY-MM-DD');
                            max = moment(max).format('YYYY-MM-DD');
                            app.filterFrom = min;
                            app.filterTo = max;
                            // var max = $('#max').datepicker("getDate");
                            var d = data[4];
                            console.log(d);

                            // d = d.split(' - ');
                            d = d.split('/');
                            console.log(d);

                            var start = [d[2], d[1], d[0]].join('-');
                            start = moment(new Date(start)).format('YYYY-MM-DD');

                            console.log(moment(min).format('YYYY-MM-DD'));
                            console.log(max);
                            console.log(start);

                            if (start <= app.filterTo && start >= app.filterFrom) {
                                return true;
                            }
                            return false;

                        }
                    );
                    $('#leavedocs-table').DataTable().draw();

                });
                $('#f-motif').on("change", function () {


                    var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            $("#leavedocs-table").DataTable().columns([7])
                                .search(val , true, false)
                                .draw();

                });
            });
            $('#demo').daterangepicker({
                "autoApply": true,
                "locale": {
                    "applyLabel": "Filtrer",
                    "cancelLabel": "Annuler",
                    "fromLabel": "Du",
                    "toLabel": "Au",
                    "customRangeLabel": "Filtrage personnalisé",
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
                },
                ranges: {
                    "Aujourd'hui": [moment(), moment()],
                    'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 derniers jours': [moment().subtract(6, 'days'), moment()],
                    '30 Derniers jours': [moment().subtract(29, 'days'), moment()],
                    'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                    'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment()
                        .subtract(1, 'month').endOf('month')
                    ]
                },
            });
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
                    feedback: "Demande d'ordre de leavedoc...",
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
            $('#files_').filer({
                limit: 1,
                maxSize: 1,
                extensions: ['jpg', 'jpeg', 'png', 'pdf'],
                showThumbs: false,
                addMore: false,
                changeInput: true,
                maxSize: 100,

                captions: {
                    button: "<span class='icofont icofont-file-pdf'> </span>",
                    feedback: "Rapport de leavedoc...",
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
            
            this.fill_table('/getLeaveDocs', 'leavedocs-table');

            $('.date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                "timePicker": false,
                "parentEl": "#leavedoc-modal",
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
            // this.fetch_notifications();
        },
        methods: {
            get_max_distance(source_id, destinations_ids) {

            },
            calculate_fees(leavedoc) { //check error when more than 1 day (number of meals...)
                // console.log(leavedoc.destinations.map(d =>d.id));
                var app = this;
                if (leavedoc.leave_time && leavedoc.return_time && leavedoc.leave_date &&
                    leavedoc.ended_at && leavedoc.transportation && leavedoc.reason && leavedoc.source &&
                    leavedoc.destinations) {
                    app.maxDistance = 0;
                    app.km_fees = 0; // (0, 3, 12)
                    app.travel_allowances;
                    app.food_allowances;
                    app.km_total = 0;
                    app.food_total = 0;
                    app.meals = 0;
                    app.nights = 0;
                    app.total = 0;
                    app.dates = [];
                    app.nights_total = 0;
                    app.lunch_total = 0;
                    app.km_top_position = 0;



                    switch (leavedoc.transportation.slice(0, 2)) {
                        case 'AU':
                            app.km_fees = 3;
                            km_top_position = 126;
                            break;
                        case 'VS':
                            app.km_fees = 0;
                            km_top_position = 103;
                            break;
                        case 'VP':
                            app.km_fees = 12;
                            km_top_position = 103;
                            break;
                    }


                    axios.post('/getDistances/', {
                        'source_id': leavedoc.source_id,
                        'destinations_ids': leavedoc.destinations.map(d => d.id),
                        'grade_id': leavedoc.agent.fonction.grade_id
                    }).then(function (response) {
                        if (response.data.error) {
                            // app.leavedocs.splice(index,1)
                            notify('Erreur', response.data.error, 'red', 'topCenter',
                                'bounceInDown');

                        } else {
                            console.log('distances', response.data.distances);

                            app.maxDistance = Math.max(...response.data.distances);
                            app.travel_allowances = response.data.travel_allowances.map(d => d.cost);
                            app.food_allowance_intervals = response.data.food_allowances.map(d => [d
                                .starts_at, d.ends_at
                            ]);
                            //    console.log(food_allowances);

                            console.log(app.travel_allowances);
                            console.log(app.food_allowance_intervals);
                            // console.log(maxDistance);
                            // console.log(maxDistance);

                            if (app.maxDistance < 30) {
                                app.total = 0;
                            } else if (app.maxDistance >= 30 && app.maxDistance < 50) {
                                app.food_total = 0;
                                app.km_total = (app.maxDistance * app.km_fees) * 2;
                                app.total = app.km_total + app.food_total;
                                //    console.log(total);

                            } else if (app.maxDistance >= 50) {
                                app.dates = getDates(leavedoc.leave_date, leavedoc.ended_at);
                                // meals = dates.length *2;
                                // nights = dates.length;
                                app.km_total = (app.maxDistance * app.km_fees) * 2;
                                // food total

                                if (app.dates.length < 2) { // same day
                                    let timeSegments = [];
                                    timeSegments.push([leavedoc.leave_time, leavedoc.return_time]);
                                    timeSegments.push(app.food_allowance_intervals[0]);
                                    console.log(overlap(timeSegments)); // true
                                    (overlap(timeSegments) ? app.meals += 1 : app.meals += 0);

                                    timeSegments = [];
                                    timeSegments.push([leavedoc.leave_time, leavedoc.return_time]);
                                    timeSegments.push(app.food_allowance_intervals[1]);
                                    console.log(overlap(timeSegments)); // true
                                    (overlap(timeSegments) ? app.meals += 1 : app.meals += 0);

                                    // timeSegments = [];
                                    // timeSegments.push([leavedoc.leave_time, leavedoc.return_time]);
                                    // timeSegments.push(food_allowance_intervals[2]);
                                    // console.log( overlap(timeSegments) ); // true
                                    // ( overlap(timeSegments) ? nights += 1 : nights +=0);

                                } else { //more than 1 day
                                    console.log(leavedoc.leave_time, app.food_allowance_intervals[1][
                                            1], leavedoc.leave_time <= app
                                        .food_allowance_intervals[1][1]);

                                    var da = [];
                                    da.push(app.dates[0], app.dates[app.dates.length - 1]);

                                    if (leavedoc.leave_time < app.food_allowance_intervals[0][1]) {
                                        app.meals += 2;

                                    }
                                    // else  if (leavedoc.leave_time <= food_allowance_intervals[1][0]){
                                    //     meals += 1; 

                                    // } 
                                    else if (leavedoc.leave_time < app.food_allowance_intervals[1][
                                        1]) {
                                        app.meals += 1;

                                    }

                                    console.log('meals of start', app.meals);
                                    if (leavedoc.return_time <= app.food_allowance_intervals[0][
                                        0]) { // <= 11:00
                                        app.meals += 0;
                                    } else if (leavedoc.return_time <= app.food_allowance_intervals[1][
                                        0]) { // <= 18:00
                                        app.meals += 1;
                                    } else if (moment(app.food_allowance_intervals[2][0], 'HH:mm').diff(
                                            moment(leavedoc.return_time, 'HH:mm')) < 0) { // <= 00:00
                                        app.meals += 2;
                                    }
                                    app.nights += (app.dates.length - 2) + 1;





                                    // console.log('meals of start and end',meals);

                                    app.meals += (app.dates.length - 2) * 2;



                                }

                                app.food_total = (app.meals * app.travel_allowances[0]) + (app.nights *
                                    app.travel_allowances[2]);
                                app.km_total = (app.maxDistance * app.km_fees) * 2;

                                app.total = app.food_total + app.km_total;
                                console.log('number of meals', app.meals);
                                console.log('number of nights', app.nights);
                                app.nights_total = app.nights * app.travel_allowances[2];
                                app.lunch_total = app.meals * app.travel_allowances[0];
                                console.log('food total', app.food_total);
                                console.log('km total', app.km_total);
                                console.log('TOTAL', app.total);

                            }
                            console.log('number of meals', app.meals);
                            console.log('number of nights', app.nights);

                            console.log('food total', app.food_total);
                            console.log('km total', app.km_total);
                            console.log('TOTAL', app.total);
                        }



                        axios.put('/updateDecompte/' + leavedoc.id, {
                                'total': app.total.toFixed(2),
                                'status': 'CALCULE'

                                // 'status': 'DEPOSE',
                            })
                            .then(function (response) {


                                notify('Succès', response.data.success, 'green', 'topCenter',
                                    'bounceInDown');
                                app.fill_table('/getLeaveDocs', 'leavedocs-table');

                            })
                            .catch(function (error) {
                                if (error.response) {
                                    app.$set(app, 'errors', error.response.data.errors);
                                    notify('Erreurs!',
                                        'Veuillez vérifier les informations introduites', 'red',
                                        'topCenter', 'bounceInDown');
                                } else if (error.request) {
                                    console.log(error.request);
                                } else {
                                    console.log('Error', error.message);
                                }
                            });
                        swal({
                                title: "Impression du decompte?",
                                text: "Voulez-vous imprimer ce decompte!",
                                type: "info",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Imprimer",
                                cancelButtonText: "Annuler",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    app.print_decompte_fr(leavedoc);


                                }


                            });




                    });

                } else {
                    notify('Erreurs!', 'Veuillez assurer que toutes les informations sont introduites', 'red',
                        'topCenter', 'bounceInDown');
                }
            },
            print_decompte_fr(leavedoc) {
                var doc = new jsPDF();
                // var doc = new jsPDF("p", "mm", "a4");
                new jsPDF('p', 'mm', [210, 133]);

                doc.setFont("courier");
                doc.setFontType("normal");
                // doc.setFont("wwDigital");
                doc.setFontSize(10);
                doc.setFontType("bold");
                doc.text('AIN DEFLA', 60, 14.5);
                doc.text('SIEGE', 82, 21.5);
                doc.text('REFERENCE          /2022', 48, 27);
                doc.text(leavedoc.agent.firstname + ' ' + leavedoc.agent.lastname, 92, 42);
                doc.text(leavedoc.agent.fonction.name.toUpperCase(), 62, 48);
                doc.text(leavedoc.source.name.toUpperCase(), 87, 54);
                doc.text(leavedoc.reason.toUpperCase(), 82, 60);
                doc.text(leavedoc.destinations.map(d => d.name).toString().toUpperCase(), 81, 66);
                doc.text(reFormatDate(leavedoc.leave_date) + '    à    ' + reFormatTime(leavedoc.leave_time),
                    85, 72);
                doc.text(reFormatDate(leavedoc.ended_at) + '    à    ' + reFormatTime(leavedoc.return_time), 85,
                    78);
                doc.text(leavedoc.transportation, 92, 84);

                doc.text(app.travel_allowances[2].toString(), 115, 121);
                doc.text(app.nights.toString(), 135, 121);
                doc.text(app.nights_total.toFixed(2).toString(), 151, 121);

                doc.text(app.travel_allowances[0].toString(), 115, 132);
                doc.text(app.meals.toString(), 135, 132);
                doc.text(app.lunch_total.toFixed(2).toString(), 151, 132);

                doc.text(app.maxDistance.toString() + ' X ' + app.km_fees.toString(), 57, km_top_position);
                doc.text(app.km_total.toFixed(2).toString(), 90, km_top_position);
                doc.setFontSize(11);
                doc.setFontType("bold");
                doc.text(app.food_total.toFixed(2).toString(), 143, 149);
                doc.text(app.km_total.toFixed(2).toString(), 80, 149);
                doc.setFontSize(11.5);
                doc.setFontType("bold");
                doc.text(app.total.toFixed(2).toString(), 112, 158);


                doc.setFontSize(10);
                doc.setFontType("bold");
                console.log(app.total);

                doc.text(ConvNumberLetter(app.total, 0, 0).toUpperCase() + 'DA ET ZERO CTS', 45, 172);
                doc.text('AIN DEFLA', 110, 195);
                doc.text(reFormatDate(new Date()), 144, 195);

                doc.autoPrint();
                window.open(doc.output('bloburl'), '_blank');
            },
            print_leavedoc_fr(leavedoc) {

                this.selected_leavedoc = leavedoc;
                var doc = new jsPDF();
                // var doc = new jsPDF("p", "mm", "a4");
                new jsPDF('p', 'mm', [210, 133]);
                doc.setFontSize(10);
                doc.setFontType("bold");
                // doc.text('AGENCE AIN DEFLA', 42, 12);
                // doc.text('REFERENCE                 /2020', 42, 20);
                doc.text(leavedoc.agent.firstname, 59, 59.5);
                doc.text(leavedoc.agent.lastname, 119, 59.5);
                doc.text(leavedoc.agent.fonction.name, 65, 66.2);
               

                
                if(leavedoc.reason == 'AP') {
                    doc.text('_____________________________________________', 48, 105.5);
                } else if(leavedoc.reason == 'RS'){
                    doc.text('______________________', 48.5, 100.5);
                }
                
                // doc.text(leavedoc.agent.fullname, 65, 123); 
                var date = reFormatDate(leavedoc.leave_date).split('/');
                console.log(date);
                
                
                console.log(hashCode( leavedoc.responsable.fullname+' - '+ reFormatDate(new Date())));
                
                var day = date[0]; 
                var month = date[1]; 
                var year = date[2].slice(2,4); 
                doc.setFontSize(11);
                doc.text(day, 91.5, 73.8);
                doc.text(month, 102.5, 73.8);
                doc.text(year, 114, 73.8);

                doc.text(reFormatTime(leavedoc.leave_time), 77.5, 80.7);
               if(leavedoc.return_time) doc.text(reFormatTime(leavedoc.return_time), 128.5, 80.7);
                doc.setFontSize(10);
                // doc.text(leavedoc.agent.transportation, 65, 154);
                if (leavedoc.details) {
                    doc.text(leavedoc.details, 51.5, 113.5);
                }
                // doc.text(leavedoc.agent.fullname, 65, 169);
                doc.text('AIN DEFLA', 104, 150);
                doc.text(reFormatDate(new Date()), 138.5, 150);
                // var imgData = 'data:image/png;base64,"images/bg.png";
                // var imgData = 'images/bg.png';
                // doc.addImage(imgData, 'PNG', 15, 40, 180, 160)
                //  doc.save('Test.pdf');
                doc.autoPrint();
                window.open(doc.output('bloburl'), '_blank');
                // window.open(doc.output('bloburl'))
            },

            calculate_fees_for_all() {
                var app = this;
                app.leavedocs.map(function (leavedoc) {

                    if (leavedoc.leave_time && leavedoc.return_time && leavedoc.leave_date &&
                        leavedoc.ended_at && leavedoc.transportation && leavedoc.reason && leavedoc
                        .source &&
                        leavedoc.destinations) {
                        app.maxDistance = 0;
                        app.km_fees = 0; // (0, 3, 12)
                        app.travel_allowances;
                        app.food_allowances;
                        app.km_total = 0;
                        app.food_total = 0;
                        app.meals = 0;
                        app.nights = 0;
                        app.total = 0;
                        app.dates = [];
                        app.nights_total = 0;
                        app.lunch_total = 0;
                        app.km_top_position = 0;



                        switch (leavedoc.transportation.slice(0, 2)) {
                            case 'AU':
                                app.km_fees = 3;
                                km_top_position = 126;
                                break;
                            case 'VS':
                                app.km_fees = 0;
                                km_top_position = 103;
                                break;
                            case 'VP':
                                app.km_fees = 12;
                                km_top_position = 103;
                                break;
                        }


                        axios.post('/getDistances/', {
                            'source_id': leavedoc.source_id,
                            'destinations_ids': leavedoc.destinations.map(d => d.id),
                            'grade_id': leavedoc.agent.fonction.grade_id
                        }).then(function (response) {
                            if (response.data.error) {
                                // app.leavedocs.splice(index,1)
                                notify('Erreur', response.data.error, 'red', 'topCenter',
                                    'bounceInDown');

                            } else {
                                console.log('distances', response.data.distances);

                                app.maxDistance = Math.max(...response.data.distances);
                                app.travel_allowances = response.data.travel_allowances.map(d =>
                                    d.cost);
                                app.food_allowance_intervals = response.data.food_allowances
                                    .map(d => [d.starts_at, d.ends_at]);
                                //    console.log(food_allowances);

                                console.log(app.travel_allowances);
                                console.log(app.food_allowance_intervals);
                                // console.log(maxDistance);
                                // console.log(maxDistance);

                                if (app.maxDistance < 30) {
                                    app.total = 0;
                                } else if (app.maxDistance >= 30 && app.maxDistance < 50) {
                                    app.food_total = 0;
                                    app.km_total = (app.maxDistance * app.km_fees) * 2;
                                    app.total = app.km_total + app.food_total;
                                    //    console.log(total);

                                } else if (app.maxDistance >= 50) {
                                    app.dates = getDates(leavedoc.leave_date, leavedoc
                                    .ended_at);
                                    // meals = dates.length *2;
                                    // nights = dates.length;
                                    app.km_total = (app.maxDistance * app.km_fees) * 2;
                                    // food total

                                    if (app.dates.length < 2) { // same day
                                        let timeSegments = [];
                                        timeSegments.push([leavedoc.leave_time, leavedoc
                                            .return_time
                                        ]);
                                        timeSegments.push(app.food_allowance_intervals[0]);
                                        console.log(overlap(timeSegments)); // true
                                        (overlap(timeSegments) ? app.meals += 1 : app.meals +=
                                            0);

                                        timeSegments = [];
                                        timeSegments.push([leavedoc.leave_time, leavedoc
                                            .return_time
                                        ]);
                                        timeSegments.push(app.food_allowance_intervals[1]);
                                        console.log(overlap(timeSegments)); // true
                                        (overlap(timeSegments) ? app.meals += 1 : app.meals +=
                                            0);

                                        // timeSegments = [];
                                        // timeSegments.push([leavedoc.leave_time, leavedoc.return_time]);
                                        // timeSegments.push(food_allowance_intervals[2]);
                                        // console.log( overlap(timeSegments) ); // true
                                        // ( overlap(timeSegments) ? nights += 1 : nights +=0);

                                    } else { //more than 1 day
                                        console.log(leavedoc.leave_time, app
                                            .food_allowance_intervals[1][1], leavedoc
                                            .leave_time <= app.food_allowance_intervals[1]
                                            [1]);

                                        var da = [];
                                        da.push(app.dates[0], app.dates[app.dates.length - 1]);

                                        if (leavedoc.leave_time < app
                                            .food_allowance_intervals[0][1]) {
                                            app.meals += 2;

                                        }
                                        // else  if (leavedoc.leave_time <= food_allowance_intervals[1][0]){
                                        //     meals += 1; 

                                        // } 
                                        else if (leavedoc.leave_time < app
                                            .food_allowance_intervals[1][1]) {
                                            app.meals += 1;

                                        }

                                        console.log('meals of start', app.meals);
                                        if (leavedoc.return_time <= app.food_allowance_intervals[
                                                0][0]) { // <= 11:00
                                            app.meals += 0;
                                        } else if (leavedoc.return_time <= app
                                            .food_allowance_intervals[1][0]) { // <= 18:00
                                            app.meals += 1;
                                        } else if (moment(app.food_allowance_intervals[2][0],
                                                'HH:mm').diff(moment(leavedoc.return_time,
                                                'HH:mm')) < 0) { // <= 00:00
                                            app.meals += 2;
                                        }
                                        app.nights += (app.dates.length - 2) + 1;





                                        // console.log('meals of start and end',meals);

                                        app.meals += (app.dates.length - 2) * 2;



                                    }

                                    app.food_total = (app.meals * app.travel_allowances[0]) + (
                                        app.nights * app.travel_allowances[2]);
                                    app.km_total = (app.maxDistance * app.km_fees) * 2;

                                    app.total = app.food_total + app.km_total;
                                    console.log('number of meals', app.meals);
                                    console.log('number of nights', app.nights);
                                    app.nights_total = app.nights * app.travel_allowances[2];
                                    app.lunch_total = app.meals * app.travel_allowances[0];
                                    console.log('food total', app.food_total);
                                    console.log('km total', app.km_total);
                                    console.log('TOTAL', app.total);

                                }
                                console.log('number of meals', app.meals);
                                console.log('number of nights', app.nights);

                                console.log('food total', app.food_total);
                                console.log('km total', app.km_total);
                                console.log('TOTAL', app.total);
                            }



                            axios.put('/updateDecompte/' + leavedoc.id, {
                                    'total': app.total.toFixed(2),
                                    'status': 'CALCULE'

                                    // 'status': 'DEPOSE',
                                })
                                .then(function (response) {

                                    app.maxDistance = 0;
                                    app.km_fees = 0; // (0, 3, 12)
                                    app.travel_allowances;
                                    app.food_allowances;
                                    app.km_total = 0;
                                    app.food_total = 0;
                                    app.meals = 0;
                                    app.nights = 0;
                                    app.total = 0;
                                    app.dates = [];
                                    app.nights_total = 0;
                                    app.lunch_total = 0;
                                    app.km_top_position = 0;
                                    notify('Succès', response.data.success, 'green',
                                        'topCenter', 'bounceInDown');


                                })
                                .catch(function (error) {
                                    if (error.response) {
                                        app.$set(app, 'errors', error.response.data.errors);
                                        notify('Erreurs!',
                                            'Veuillez vérifier les informations introduites',
                                            'red',
                                            'topCenter', 'bounceInDown');
                                    } else if (error.request) {
                                        console.log(error.request);
                                    } else {
                                        console.log('Error', error.message);
                                    }
                                });




                        });
                    }
                });
            },

            clearInputs() {
                $('#agents').selectpicker('val', '');
                // $('#responsable').selectpicker('val', '');


                $('#leave_date').val('');
                $('#return_time').val('');
                $('#leave_time').val('');



                this.reference = '';

                this.agent_id = '';
                // this.responsable = '';

                this.leave_date = '';

                this.leave_time = '';
                this.return_time = '';
                this.reason = '';
                this.details = '';

                this.selectedLeaveDocId = '';
                this.selectedLeaveDocIndex = '';
            },
            
            handleFilesUpload() {
                this.request_scan = this.$refs.files.files;
                this.request_scan_name = this.request_scan[0].name;
                $('#request-file').val(this.request_scan_name);

            },
            handleFiles_Upload() {
                this.report_scan = this.$refs.files_.files;
                this.report_scan_name = this.report_scan[0].name;
                $('#report-file').val(this.report_scan_name);

            },
            fff() {
                console.log(this.$refs.files.files[0]);
                console.log(this.$refs.files_.files[0]);

            },
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

                new $.fn.dataTable.Responsive($('#' + tableName).DataTable({

                    scrollX: false,
                    scrollCollapse: false,
                    scroller: false,
                    responsive: {
                        details: {
                            type: 'column'
                        }
                    },
                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }, {
                        orderable: false,
                        targets: 1
                    }],
                    order: [3, 'asc'],

                    // "footerCallback": function (row, data, start, end, display) {
                    //     var api = this.api(),
                    //         data;

                    //     // Remove the formatting to get integer data for summation
                    //     var intVal = function (i) {
                    //         return typeof i === 'string' ?
                    //             i.replace(/[\$,]/g, '') * 1 :
                    //             typeof i === 'number' ?
                    //             i : 0;
                    //     };

                    //     // Total over all pages
                    //     total = api
                    //         .column(8)
                    //         .data()
                    //         .reduce(function (a, b) {
                    //             return intVal(a) + intVal(b);
                    //         }, 0);

                    //     // Total over this page
                    //     pageTotal = api
                    //         .column(8, {
                    //             page: 'current'
                    //         })
                    //         .data()
                    //         .reduce(function (a, b) {
                    //             return intVal(a) + intVal(b);
                    //         }, 0);

                    //     // Update footer
                    //     $(api.column(8).footer()).html(
                    //         'TOTAL : ' + formatMoney(pageTotal) + ' DA ' + '<br>' +
                    //         ' (GLOBAL : ' + formatMoney(total) + ' DA)'
                    //     );
                    // },
                    initComplete: function () {

                        this.api().columns([2]).every(function () {

                            var column = this;

                            column.data().unique().sort().each(function (d, j) {
                                $('#f-agents').append('<option value="' + d +
                                    '">' +
                                    d + '</option>')
                            });
                        });

                        $('#f-agents').selectpicker('refresh').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            $("#leavedocs-table").DataTable().columns([2])
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                        this.api().columns([3]).every(function () {

                            var column = this;

                            column.data().unique().sort().each(function (d, j) {
                                $('#f-responsables').append('<option value="' + d +
                                    '">' +
                                    d + '</option>')
                            });
                        });

                        $('#f-responsables').selectpicker('refresh').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            $("#leavedocs-table").DataTable().columns([3])
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                       
                        // $('#f-drivers').selectpicker('refresh').on('change', function() {
                        //             var val = $.fn.dataTable.util.escapeRegex(
                        //                 $(this).val()
                        //             );

                        //             $("#petrolCoupons-table").DataTable().columns([2])
                        //                 .search(val ? '^' + val + '$' : '', true, false)
                        //                 .draw();
                        //         });
                    },
                    'dom': 'Bfrtip',
                    "colVis": {
                        aiExclude: [1],
                    },
                    language: {
                        "decimal": "",
                        "emptyTable": "Aucune donnée disponible dans la table",
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

                        },
                        // {
                        //     extend: 'colvis',
                        //     text: 'AFFICHAGE',
                        //     className: 'btn-inverse',
                        //     targets: [1,2] 
                        // }
                    ]

                }));

            },
            fill_table(url, tableName) {
                var app = this;
                this.fetch_leavedocs(url, tableName).then((response) => {
                    app.init_table(tableName);
                    app.unblock(tableName);
                });
            },
            fetch_leavedocs(url, tableName) {
                var app = this;
                app.block(tableName);
                $('#' + tableName).DataTable().destroy();
                return axios.get(url)
                    .then(function (response) {
                        app.leavedocs = response.data.leave_docs;
                    })
                    .catch();
            },
            delete_leavedoc(id, index) {
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
                            axios.delete('/leavedocs/' + id)
                                .then(function (response) {
                                    if (response.data.error) {
                                        // app.leavedocs.splice(index,1)
                                        notify('Erreur', response.data.error, 'red', 'topCenter',
                                            'bounceInDown');

                                    } else {
                                        notify('Succès', response.data.success, 'green', 'topCenter',
                                            'bounceInDown');
                                        app.fill_table('/getLeaveDocs', 'leavedocs-table');
                                        app.clearInputs();
                                    }
                                });
                        }
                    }
                )

            },
            edit_leavedoc(leavedoc, index) {
                var app = this;
                app.selectedLeaveDocId = leavedoc.id;
                app.selectedLeaveDocIndex = index;
                app.operation = 'edit';
                app.modal_title = "Modifier un bon de sortie";
                app.agent_id = leavedoc.agent_id;
                app.reason = leavedoc.reason;
                app.leave_date = leavedoc.leave_date;
                app.leave_time = leavedoc.leave_time;
                app.return_time = leavedoc.return_time;
                

                // this.cost = leavedoc.cost;
                $('#leave_date').data('daterangepicker').setStartDate(reFormatDateTime(leavedoc.leave_date));
                $('#leave_date').data('daterangepicker').setEndDate(reFormatDateTime(leavedoc.leave_date));

   

                $('#agents').selectpicker('val', leavedoc.agent_id);

                $('#reasons').selectpicker('val', leavedoc.reason);
         
                

                

                // this.transportation = leavedoc.transportation;


                if (app.reason == 'RS') {
                    app.details = leavedoc.details;

                } 
            },
            add_leavedoc() {
                var app = this;

                app.operation = 'add';
                app.modal_title = "Ajouter un bon de sortie";

                app.leave_date = formatDate($('#leave_date').data('daterangepicker').startDate);

                app.agent_id = $('#agents').selectpicker('val');
                // app.responsable = $('#responsable').selectpicker('val');

                app.reason = $('#reasons').selectpicker('val');





                // app.report_scan = app.$refs.files.files[0];

                let formData = new FormData();

                formData.append('agent_id', app.agent_id);
                // formData.append('responsable', app.responsable);
                formData.append('leave_date', app.leave_date);
                formData.append('leave_time', app.leave_time);
                formData.append('return_time', app.return_time);
                formData.append('details', app.details);
                formData.append('reason', app.reason);
                formData.append('reference', app.reference);


                // formData.append('report_scan', app.report_scan);
                axios.post('/leavedocs', formData,
                        //  {
                        //         headers: {
                        //             'Content-Type': 'multipart/form-data'
                        //         }
                        //     }
                    )
                    .then(function (response) {

                        $('#leavedoc-modal').modal('hide');
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                        $('#f-agents').selectpicker('refresh');
                        app.fill_table('/getLeaveDocs', 'leavedocs-table');
                        app.clearInputs();
                        console.log(response.data.m);


                    })
                    .catch(function (error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                            notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red',
                                'topCenter', 'bounceInDown');
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            update_leavedoc() {
                var app = this;

                // app.operation = 'edit';
                // app.modal_title = "Modi une leavedoc";

                app.leave_date = formatDate($('#leave_date').data('daterangepicker').startDate);

                app.agent_id = $('#agents').selectpicker('val');
                // app.responsable = $('#responsable').selectpicker('val');

                app.reason = $('#reasons').selectpicker('val');


                console.log(app.operation);


                // app.report_scan = app.$refs.files.files[0];

                let formData = new FormData();



                // formData.append('report_scan', app.report_scan);
                axios.put('/leavedocs/' + app.selectedLeaveDocId, {
                        'agent_id': app.agent_id,
                        // 'responsable': app.responsable,
                        'leave_date': app.leave_date,
                        'return_time': app.return_time,

                        'leave_time': app.leave_time,


                        'reason': app.reason,
                        'reference': app.reference,
                        'details': app.licence_number,

                    })
                    .then(function (response) {

                        $('#leavedoc-modal').modal('hide');
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                        app.fill_table('/getLeaveDocs', 'leavedocs-table');
                        app.clearInputs();

                    })
                    .catch(function (error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                            notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red',
                                'topCenter', 'bounceInDown');
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
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
