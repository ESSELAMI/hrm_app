@extends('layouts.base')

@section('page_title')
<h5>Attribution des bons d'essence</h5>
{{-- <span>Ajouter, modifer ou supprimer une attribution </span> --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('petrolCoupons.index') }}">Attribution des bons d'essence</a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">
    <div class="modal fade" id="petrolCoupon-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-model="modal_title">Ajouter une attribution</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12 ">
                    <form>
                        <div class="row" id="add-petrolCoupon-form">
                            <div class="form-group col-md-6 m-t-15">
                                <label for="-date" class="block">Véhicule <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.vehicle_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.vehicle_id">
                                    <select id="vehicles" class="selectpicker show-tick text-center" title="Sélectionner un véhicule.."
                                        data-width="100%">


                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 m-t-15">
                                <label for="drivers" class="block">Chauffeur <span class="text-danger"> (*)</span></label>
                                <div :class="[errors.driver_id ? '  input-group input-group-danger' : '  input-group input-group-inverse']"
                                    data-toggle="tooltip" data-placement="top" :data-original-title="errors.driver_id">
                                    <select id="drivers" class="selectpicker show-tick text-center" title="Sélectionner un chauffeur.."
                                        data-width="100%">


                                    </select>
                                    <span class="input-group-addon">
                                        <i class="icofont icofont-id-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-5 ">
                                <label for=kilometrage" class="block">DERNIER KILOMTRAGE <span class="text-danger">(*)</span></label>
                                <div :class="[errors.kilometrage ? '  input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input type="number" class="form-control " placeholder="Kilométrage..." data-toggle="tooltip"
                                        data-placement="top" :data-original-title="errors.kilometrage" v-model="kilometrage" min="0">
                                    <span class="input-group-addon">
                                        <b class="fa fa-money"></b>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-md-7 ">
                                <label for="card-number" class="block">Date d'attribution<span class="text-danger"> (*)</span></label>
                                <div :class="[errors.assigned_at ? ' input-group input-group-danger' : ' input-group input-group-inverse']">
                                    <input id="assigned_at" type="text" class="form-control date text-center"
                                        placeholder="Date d'expiration..." data-toggle="tooltip" data-placement="top"
                                        :data-original-title="errors.assigned_at">
                                    <span class="input-group-addon">
                                        <strong class="icofont icofont-social-slack"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-12 demo-wrapper"  id="simple-clone">
                                <label for="coupon_number" class="block">NUMERO DU BON <span class="text-danger">(*)</span></label>
                                    <div  class="input-group input-group-inverse toclone">
                                        <span class="input-group-addon delete">
                                            <b class="fa fa-minus"></b>
                                        </span>
                                        <input type="text" class="form-control coupons" placeholder="Numéro du bon..." data-toggle="tooltip"
                                            data-placement="top" :data-original-title="errors.coupon_number"  min="0">
                                        <span class="input-group-addon clone">
                                            <b class="fa fa-plus"></b>
                                        </span>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" >
                    <button v-if="operation=='add'" type="button" class="btn btn-primary waves-effect waves-light "
                        v-on:click="add_petrolCoupon()">Sauvguarder</button>
                    <button v-if="operation=='edit'" type="button" class="btn btn-primary waves-effect waves-light"
                        v-on:click="update_petrolCoupon()">Sauvguarder</button>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 style="font-size:16px"><i class="icofont icofont-filter m-r-5"></i>Recherche détaillé</h5>
                </div>
                <div class="card-block">
                    <form class="row">
                        <div class="form-group col-md-4 ">
                            <label for="drivers" class="block">Véhicule</label>
                            <div class="input-group input-group-inverse">
                                <select id="f-vehicles" class="selectpicker show-tick text-center" title="Sélectionner un véhicule.."
                                    data-width="100%">


                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-id-card"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4 ">
                            <label for="drivers" class="block">Chauffeur</label>
                            <div class="input-group input-group-inverse">
                                <select id="f-drivers" class="selectpicker show-tick text-center" title="Sélectionner un chauffeur.."
                                    data-width="100%">


                                </select>
                                <span class="input-group-addon">
                                    <i class="icofont icofont-id-card"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-3 ">
                            <label for="demo" class="block">Date</label>
                            <div class="input-group input-group-inverse">
                                <input type="text" id="demo" class="form-control" style="height:41px">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-id-card"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-1 ">
                            <label for="demo" class="block" style="visibility:hidden">Date</label>
                            <div class="input-group input-group-warning">
                                <input type="text" class="form-control"
                                style="display:none" >
                                <span class="input-group-addon" style="height:41px" id="refresh" data-toggle="tooltip"
                                data-placement="top" data-original-title="Actualiser">
                                    <i class="icofont icofont-refresh"></i>
                                </span>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    <div class="col-md-12">

        <div class="card">
            <div class="card-header table-card-header">
                <h5 style="font-size:16px">Attribution des bons d'essence</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter une attribution">
                                <i class="fa fa-plus faa-horizontal animated text-success " style="font-size:22px"
                                    data-toggle="modal" data-target="#petrolCoupon-modal" v-on:click="operation='add';
                                    $('.coupons').val('')">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="petrolCoupons-table" class="table  table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:10px">#</th>
                                <th class="text-center ">VEHICULE</th>
                                <th class="text-center">CHAUFFEUR</th>
                                <th class="text-center">DATE D'ATTRIBUTION</th>
                                <th class="text-center">NUMERO DU BON(S)</th>
                                <th class="text-center">KILOMETERAGE</th>
                                <th class="text-center noExport">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(petrolCoupon, index) in petrolCoupons">
                                <td style="width:10px">@{{ index+1 }}</td>
                                <td class="text-center" style="width:200px">@{{
                                    petrolCoupon.vehicle.model.name.toUpperCase() +' - '+petrolCoupon.vehicle.licence_plate
                                    }}</td>
                                <td class="text-center" style="width:200px">@{{ petrolCoupon.driver.fullname.toUpperCase() }}</td>
                                <td class="text-center" style="width:100px">@{{ reFormatDate(petrolCoupon.assigned_at) }}</td>
                                <td class="text-center" style="width:200px">@{{ petrolCoupon.coupon_number }}</td>
                                <td class="text-center" style="width:200px">@{{ petrolCoupon.kilometrage }}</td>
                                <td style="width:70px">
                                    <div class="text-center">
                                        <span data-toggle="modal" data-target="#petrolCoupon-modal" v-on:click="edit_petrolCoupon(petrolCoupon,index)">
                                            <i class="feather icon-edit text-info f-18 clickable" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Modifier">
                                            </i>
                                        </span>
                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_petrolCoupon(petrolCoupon.id,index)"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                        </i>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot >
                            <th class="text-center"></th>
                            <th class="text-center noExport"></th>
                            <th class="text-center noExport"></th>
                            <th class="text-center noExport"></th>
                            <th class="text-center"></th>
                            <th  class="text-center"></th>
                            <th  class="text-center"></th>
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

            filterVehicles:[],
            filterDrivers:[],
            filterFrom:'',
            filterTo:'',

            coupon_number: [],
            kilometrage: '',
            assigned_at: '',
            vehicle_id: '',
            driver_id: '',
            modal_title: '',
            selectedPetrolCouponId:'',
            selectedPetrolCouponIndex:'',
            notifications:[],
            vehicles:[],
            drivers:[],
            petrolCoupons:[],
            errors: [],
        }
    },
    mounted() {
        this.fetch_notifications();
        var app = this;
        $(document).ready(function () {
           $('#refresh').on('click',function () {
            $('#demo').data('daterangepicker').setStartDate('01/01/1900')
            $('#demo').data('daterangepicker').setEndDate(new Date())
            $('#demo').val("");
            $("#petrolCoupons-table").DataTable().search("").draw();
            $('#f-vehicles').selectpicker('val',null);
            $('#f-drivers').selectpicker('val',null);
           });
           $('#demo').on('cancel.daterangepicker', function(ev, picker) {
            $('#demo').data('daterangepicker').setStartDate('01/01/1900')
            $('#demo').data('daterangepicker').setEndDate(new Date())
            $('#demo').val("");
});
            $('#demo').on("change",function () {


            $.fn.dataTable.ext.search.push(
          function (settings, data, dataIndex) {

        var min = new Date($('#demo').data('daterangepicker').startDate.format('YYYY-MM-DD'));
        var max =  new Date($('#demo').data('daterangepicker').endDate.format('YYYY-MM-DD'));
        min = moment(min).format('YYYY-MM-DD');
        max = moment(max).format('YYYY-MM-DD');
        app.filterFrom = min;
        app.filterTo = max;
        // var max = $('#max').datepicker("getDate");
        var d =  data[3];
        d = d.split('/');
        var start = [d[2], d[1], d[0]].join('-');
        start = moment(new Date(start)).format('YYYY-MM-DD');

        console.log(moment(min).format('YYYY-MM-DD'));
        console.log(max);
        console.log(start);

        if ( start <= app.filterTo && start >= app.filterFrom) { return true; }
        return false;

    }
    );
    $('#petrolCoupons-table').DataTable().draw();

        });
    });
        var app = this;
        $('#simple-clone').cloneya({
            minimum		    : 1,
            maximum         : 999,
            cloneThis		: '.toclone',
            valueClone		: false,
            dataClone		: false,
            deepClone		: false,
            cloneButton		: '.clone',
            deleteButton	: '.delete',
            clonePosition	: 'after',
            serializeID     : true,
            ignore	    	    : 'label.error',
            preserveChildCount  : false,

        }).on('after_clone.cloneya', function (event, toclone, newclone) {
            let coupon_number = toclone.find('input').val();
            if (coupon_number ) {
                newclone.find('input').val(parseInt(coupon_number)+1)
            }

        });


        this.fill_table('/getPetrolCoupons', 'petrolCoupons-table');
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "parentEl": "#petrolCoupon-modal",
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
            },
    ranges: {
        "Aujourd'hui": [moment(), moment()],
        'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 derniers jours': [moment().subtract(6, 'days'), moment()],
        '30 Derniers jours': [moment().subtract(29, 'days'), moment()],
        'Ce mois': [moment().startOf('month'), moment().endOf('month')],
        'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
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
            $('#demo').val('');

           var table =  $('#' + tableName).DataTable({

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
            // pageTotal = api
            //     .column( 5, { page: 'current'} )
            //     .data()
            //     .reduce( function (a, b) {
            //         return intVal(a);
            //     }, 0 );
            // Total over this page
            kilometrages = api.column( 5, { page: 'current'} ).data();
            km = [];
            kilometrages.map(t => {
               km.push(parseInt(t))
            })
            console.log(km);
            
            if(km.length!=0){
                pageTotal = Math.abs(Math.max(...km) - Math.min(...km));
            } else {
                pageTotal = 0;
            }
            // Total over this page
            couponTotal = 0;
            coupons = api
                .column( 4, { page: 'current'} )
                .data();
                coupons.map( t => {
                    couponTotal+=t.toString().split(',').length;
                    // console.log(t.toString().split(',').length);
                })


            // Update footer
            $( api.column( 5 ).footer() ).html(
               'TOTAL : '+  pageTotal +' KM '
            );
            // Update footer
            $( api.column( 4 ).footer() ).html(
               'NOMBRE DE BONS : '+  couponTotal
            );
        },
        initComplete: function() {
            this.api().columns([2]).every(function() {

                var column = this;

                column.data().unique().sort().each(function(d, j) {
                    $('#f-drivers').append('<option value="' + d + '">' + d + '</option>')
                });
            });
            this.api().columns([1]).every(function() {

                var column = this;

                column.data().unique().sort().each(function(d, j) {
                    $('#f-vehicles').append('<option value="' + d + '">' + d + '</option>')
                });
            });
            $('#f-vehicles').selectpicker('refresh').on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        $("#petrolCoupons-table").DataTable().columns([1])
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
            $('#f-drivers').selectpicker('refresh').on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        $("#petrolCoupons-table").DataTable().columns([2])
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
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
            this.fetch_petrolCoupons(url, tableName).then((response) => {
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
        fetch_petrolCoupons(url, tableName) {
            var app = this;
            app.block(tableName);
            $('#' + tableName).DataTable().destroy();
            return axios.get(url)
                .then(function (response) {
                    app.petrolCoupons = response.data.petrolCoupons;
                    app.vehicles = response.data.vehicles;
                    app.drivers = response.data.drivers;
                })
                .catch();
        },
        delete_petrolCoupon(id, index) {
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
                        axios.delete('/petrolCoupons/'+id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.petrolCoupons.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');

                                } else {
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    app.fill_table('/getPetrolCoupons', 'petrolCoupons-table');
                                    app.reset_form();
                                }
                            });
                    }
                }
            )

        },
        edit_petrolCoupon(petrolCoupon,index){
            $('.toclone').remove();
            this.coupon_number = [];
            this.selectedPetrolCouponId = petrolCoupon.id;
            this.selectedPetrolCouponIndex = index;
            this.operation = 'edit';
            this.modal_title = "Modifier l'attribution";
            this.vehicle_id = petrolCoupon.vehicle_id;
            this.coupon_number = petrolCoupon.coupon_number;
            this.kilometrage = petrolCoupon.kilometrage;
            this.driver_id = petrolCoupon.driver_id;
            $('#assigned_at').data('daterangepicker').setStartDate(reFormatDate(petrolCoupon.assigned_at));
            $('#assigned_at').data('daterangepicker').setEndDate(reFormatDate(petrolCoupon.assigned_at));
            $('#vehicles').selectpicker('val',this.vehicle_id);
            $('#drivers').selectpicker('val',this.driver_id);


            let coupons = app.coupon_number;
            coupons = coupons.split(',');
            console.log(coupons);
            console.log(coupons.length);

            if (coupons.length) {

                    for (let i = 0; i < coupons.length; i++) {
                        let el = '<div class="input-group input-group-inverse toclone">'+
                                        '<span class="input-group-addon delete">'+
                                            '<b class="fa fa-minus"></b>'+
                                        '</span>'+
                                        '<input type="text" class="form-control coupons" placeholder="Numéro du bon..." data-toggle="tooltip"'+
                                            'data-placement="top" :data-original-title="errors.coupon_number"  min="0" value="'+
                                            coupons[i]+'">'+
                                        '<span class="input-group-addon clone">'+
                                            '<b class="fa fa-plus"></b>'+
                                        '</span>'+
                                    '</div>';
                        $('#simple-clone').append(el);

                    }
        }



        },
        add_petrolCoupon() {
            var app = this;
            // console.log($('.coupons').val());
            app.coupons = [];
            $('.coupons').each(function(index){
                app.coupon_number.push($(this).val().toString())
            });
            console.log(app.coupon_number);



            app.operation = 'add';
            app.modal_title = "Ajouter une attribution";
            app.assigned_at = formatDate($('#assigned_at').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');
            app.driver_id = $('#drivers').selectpicker('val');
            console.log(app.vehicle_id);



            axios.post('/petrolCoupons', {
            'kilometrage': app.kilometrage,
            'coupon_number': app.coupon_number.toString(),
            'assigned_at': app.assigned_at,
            'vehicle_id': app.vehicle_id,
            'driver_id': app.driver_id
            })
                .then(function (response) {

                    $('#petrolCoupon-modal').modal('hide');

                    app.fill_table('/getPetrolCoupons', 'petrolCoupons-table');
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
        update_petrolCoupon() {
            var app = this;
            app.assigned_at = formatDate($('#assigned_at').data('daterangepicker').startDate);
            app.vehicle_id = $('#vehicles').selectpicker('val');
            app.driver_id = $('#drivers').selectpicker('val');
            app.coupon_number = [];
            $('.coupons').each(function(index){
                app.coupon_number.push($(this).val().toString())
            });
            axios.put('/petrolCoupons/'+app.selectedPetrolCouponId, {
                'kilometrage': app.kilometrage,
                'coupon_number': app.coupon_number.toString(),
                'assigned_at': app.assigned_at,
                'vehicle_id': app.vehicle_id,
                'driver_id': app.driver_id

                })
                .then(function (response) {
                    $('#petrolCoupon-modal').modal('hide');
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.fill_table('/getPetrolCoupons', 'petrolCoupons-table');
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
            this.kilometrage='';
            this.coupon_number=[];
            this.assigned_at='';
            this.vehicle_id='';
            this.driver_id='';
            this.modal_title = '';
            this.errors = [];
            $('.toclone').remove();
            let el = '<div class="input-group input-group-inverse toclone">'+
                                        '<span class="input-group-addon delete">'+
                                            '<b class="fa fa-minus"></b>'+
                                        '</span>'+
                                        '<input type="text" class="form-control coupons" placeholder="Numéro du bon..." data-toggle="tooltip"'+
                                            'data-placement="top" :data-original-title="errors.coupon_number"  min="0" > '+
                                        '<span class="input-group-addon clone">'+
                                            '<b class="fa fa-plus"></b>'+
                                        '</span>'+
                                    '</div>';
                        $('#simple-clone').append(el);
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
