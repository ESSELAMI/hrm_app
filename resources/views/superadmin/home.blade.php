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


@include('superadmin.navigation')


@section('page_content')
 
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
            vehicles:[],
            mechanics:[],
            maintenanceTypes:[],
            maintenances:[],
            errors: [],
            notifications:[],
            notifications_fetched: false,
        }
    },
    mounted() {
        this.fetch_notifications();
        
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
     
    },
});
 
 </script>
 




@endsection
