@extends('layouts.base')

@section('page_title')
<h4>Accueil</h4>
<span>Etat de l'agence </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
@endsection


@include('parc_manager.navigation')


@section('page_content')
<div class="row">

    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center m-l-0">
                    <div class="col-auto">
                        <i class="icofont icofont-money f-42 text-c-lite-green"></i>
                    </div>
                    <div class="col-auto">
                        <h6 class="text-muted m-b-10 "># Recette prévisionnelle - 31/12/2022</h6>
                        <h2 class="m-b-0">16 400 750 892,36 DA</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center m-l-0">
                    <div class="col-auto">
                        <i class="icofont icofont-card f-42 text-c-green"></i>
                    </div>
                    <div class="">
                        <h6 class="text-muted m-b-10 "># Recette prévisionnelle - 09/2022</h6>
                        <h2 class="m-b-0">1 418 910 504,38 DA</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('page_scripts')

<script>
    new Vue({
        el: '#app',
        data() {
            return {
                notifications: [],
                drivers: [],
                vehicles: [],
                accidents: [],
                petrolCoupons: 0,
                date_couponNumber: [],
                test: ["Farid", "Directeur", "Belkhir"],
                monthLabels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet",
                    "Aout", "Septembre", "October", "Novembre", "Décembre"
                ]
            }
        },
        created() {


            this.fetch_notifications();
            this.fetch_drivers();
            this.fetch_vehicles();
            this.fetch_accidents();
            this.fetch_petrolCoupons().then(() => {
                console.log();
            });
            var app = this;
            console.log(app.date_couponNumber);
            var te;
        },

        methods: {
            fetch_notifications() {
                var app = this;
                return axios.get('/getNotifications')
                    .then(function(response) {
                        app.notifications = response.data.notifications;
                        if (app.notifications.length > 0) {
                            ion.sound.play("ding_ding", {
                                loop: 2
                            });
                        }
                    });
            },
            fetch_drivers() {
                var app = this;
                return axios.get('/getDrivers')
                    .then(function(response) {
                        app.drivers = response.data.drivers;

                    });
            },
            fetch_accidents() {
                var app = this;
                return axios.get('/getAccidents')
                    .then(function(response) {
                        app.accidents = response.data.accidents;

                    });
            },
            fetch_vehicles() {
                var app = this;
                return axios.get('/getVehicles')
                    .then(function(response) {
                        app.vehicles = response.data.vehicles;

                    });
            },
            fetch_petrolCoupons() {
                var app = this;
                return axios.get('/getPetrolCoupons')
                    .then(function(response) {
                        var coupons = response.data.petrolCoupons;
                        coupons.map(c => {
                            app.petrolCoupons += c.coupon_number.toString().split(',').length;
                        })

                        var cc = response.data.coupons;

                        cc.forEach((c, i) => {

                            app.date_couponNumber[i] = {
                                assigned_at: c.assigned_at,
                                coupons: c.coupons.toString().split(',').length
                            };
                            // i++;
                        })
                        ff = response.data.petrolCoupons_agency_month;
                        //  console.log(ff);


                        // console.log(_.pluck( ff, 'total'));
                        // console.log( cc);

                        // dd = ff.filter(f => {
                        //     f.AGENCE ? "AGENCE Tiaret";
                        // })

                        // console.log(_.pluck( ff, 'ASSIGNED_AT'));
                        // gg = ff.filter(f => f.AGENCE === 'AGENCE Tiaret')
                        //     console.log(_.pluck( gg, 'PETROL_COUPONS'));

                        /*Bar chart*/
                        var data1 = {

                            labels: app.monthLabels,
                            fill: true,
                            datasets: [{

                                fill: false,
                                label: "NOMBRE DE BONS",
                                backgroundColor: [
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',
                                    'rgba(93, 156, 236, 0.93)',

                                ],
                                hoverBackgroundColor: [
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',
                                    'rgba(103, 162, 237, 0.82)',

                                ],
                                data: _.pluck(ff, 'total'),
                                //  data: [1,1,1,1,1,1,1,1,1,1,1,12],
                            }]
                        };

                        var bar = document.getElementById("barChart");
                        var myBarChart = new Chart(bar, {
                            type: 'bar',
                            fill: false,
                            data: data1,
                            responsive: true,
                            scaleOverride: true,

                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {

                                            min: 0,
                                            stepSize: 1
                                        }
                                    }]
                                },
                                animation: {
                                    duration: 2000,
                                    easing: 'easeOutBounce'
                                }
                            }

                        });



                    });
            },
        },
    });
</script>





@endsection