@extends('layouts.base')

@section('page_title')
<h4>Accueil</h4>
<span>Etat de l'application </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
@endsection


@include('admin.navigation')


@section('page_content')
<div class="row" >
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center m-l-0">
                    <div class="col-auto">
                        <i class="icofont icofont-user-alt-1 f-42 text-c-lite-green"></i>
                    </div>
                    <div class="col-auto">
                        <h6 class="text-muted m-b-10 "># UTILISATEURS</h6>
                        <h2 class="m-b-0">@{{users.length}}</h2>
                    </div>
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
             started_at: '',
             vehicle_id: '',
             mechanic_id: '',
             details: '',
             modal_title: '',
             selectedMaintenanceId:'',
             selectedMaintenanceIndex:'',
             notifications:[],
             users:[],
             mechanics:[],
             maintenanceTypes:[],
             maintenances:[],
             errors: [],
         }
     },
     mounted() {
         this.fetch_notifications();
         this.fetch_users();

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
                 fetch_users(){
                    var app = this;
                    return axios.get('/getUsers')
                        .then(function (response) {
                            app.users = response.data.users;

                        });
                },

     },
 });

  </script>





@endsection
