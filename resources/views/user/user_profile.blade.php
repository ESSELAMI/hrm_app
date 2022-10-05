@extends('layouts.base')

@section('page-styles')
    <style>
    .jFiler-theme-default .jFiler-input-button {
    background-color: #404e67;
    background-image: none;
    color: #fff;
}
.jFiler-theme-default .jFiler-input {
   height: 40px;
   width: 120%;
   font-size: 14px
}
    .ms-container .ms-selectable li.ms-hover, .ms-container .ms-selection li.ms-hover {
    background-color: #404e67;
}
.btn {

line-height: 1.25;
}
.form-control {

height: 40px;
}
.btn-light{
    border-color: #404e67;
}

    </style>
@endsection

@section('page_title')
<h4>Mon profile</h4>
<span>Changer vos informations</span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('user-profile') }}">Mon profile</a>
</li>
@endsection


@include('user.navigation')


@section('page_content')
<div class="row">

    <div class="col-lg-12 ">
        <div class="card" id="user-profile-form">
            <div class="card-header">
                <h5 class="text-danger">Veuillez remplir tous les champs obligatoires (*)</h5>
                <div v-if="errors.length"> @{{ errors }}</div>
            </div>
            <div class="card-block">

                <h6 class="sub-title">Informations personnelles <span class="text-danger">(*)</span> </h6>
                <form>
                    <div class="row">
                    <div class="form-group col-sm-3">
                            <label for="username" class="block">Nom d'utilisateur </label>
                            <div :class="[errors.username ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                            <input type="text" class="form-control" placeholder="Nom d'utilisateur"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.username" v-model="username" disabled="disabled">
                            <span class="input-group-addon">
                                <i class="icofont icofont-business-man-alt-2"></i>
                            </span>
                            </div>
                     </div>
                    <div class="form-group col-sm-4">
                            <label for="fullname" class="block">Nom et Prénom <span class="text-danger">(*)</span></label>
                            <div :class="[errors.fullname ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                            <input id="fullname" type="text" class="form-control" placeholder="Nom et Prénom..." 
                            v-model="fullname" data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.fullname" >
                            <span class="input-group-addon">
                                <i class="icofont icofont-user" data-toggle="tooltip" data-placement="top" :data-original-title="errors.fullname"></i>
                            </span>
                            </div>
                     </div>
                     <div class="form-group col-sm-5">
                            <label for="email" class="block">Email <span class="text-danger">(*)</span></label>
                            <div :class="[errors.email ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                            <input type="text" class="form-control" placeholder="Email" v-model="email"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.email">
                            <span class="input-group-addon">
                                <i class="icofont icofont-mail"></i>
                            </span>
                            </div>
                     </div>

                     <div class="form-group col-sm-4">
                            <label for="telephone" class="block">Numéro de téléphone <span class="text-danger">(*)</span></label>
                            <div :class="[errors.telephone ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                            <input type="text" class="form-control" placeholder="Numéro de téléphone" v-model="telephone"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.telephone">
                            <span class="input-group-addon">
                                <i class="icofont icofont-telephone"></i>
                            </span>
                            </div>
                     </div>

                     <div class="form-group col-sm-8">
                            <label for="address" class="block">Adresse <span class="text-danger">(*)</span></label>
                            <div :class="[errors.address ? 'input-group input-group-danger' : 'input-group input-group-inverse']">
                            <input type="text" class="form-control" placeholder="Adresse" v-model="address"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.address">
                            <span class="input-group-addon">
                                <i class="icofont icofont-location-pin"></i>
                            </span>
                            </div>
                     </div>
                     <div class="form-group col-sm-6">
                            <label for="password" class="block">Mot de passe <span class="text-danger">(*)</span></label>
                            <div :class="[errors.password ? 'input-group input-group-danger' : 'input-group input-group-inverse']"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.password">
                           <input type="password" class="form-control" placeholder="Mot de passe" v-model="password">
                            <span class="input-group-addon">
                                <i class="icofont icofont-lock"></i>
                            </span>
                            </div>
                     </div>
                     <div class="form-group col-sm-6">
                            <label for="password" class="block">Confirmation <span class="text-danger">(*)</span></label>
                            <div :class="[errors.password ? 'input-group input-group-danger' : 'input-group input-group-inverse']" data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.password">
                            <input type="password" class="form-control" placeholder="Confirmation du mot de passe" v-model="password_confirmation">
                            <span class="input-group-addon">
                                <i class="icofont icofont-lock"></i>
                            </span>
                            </div>
                     </div>
                        
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-primary m-r-10" v-on:click="update_information()">
                            Sauvgarder
                        </button>
                        <button type="submit" class="btn btn-default" v-on:click="reset_form()">Réinitialiser</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('page_scripts')
<script>
    $(document).ready(function () {
        
    });
</script>
<script>
    const app = new Vue({
        el: '#app',
        data() {
            return {
                fullname:'<?php echo Auth::user()->fullname ?>',
                email:'<?php echo Auth::user()->email ?>',
                telephone:'<?php echo Auth::user()->telephone ?>',
                address:'<?php echo Auth::user()->address ?>',
                username:'<?php echo Auth::user()->username ?>',
                password:'',
                password_confirmation:'',
                errors:[],
                notifications: [],
                notifications_fetched: false,
            }
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
                update_information(){
                var app = this;

                axios.put('/update_information', {
                    'fullname':app.fullname,
                    'email':app.email,
                    'telephone':app.telephone,
                    'address':app.address,
                    'password':app.password,
                    'password_confirmation':app.password_confirmation,
                })
                .then(function (response) {
                notify('Succès',response.data.success,'green', 'topCenter','bounceInDown');
                app.fullname= response.data.user.fullname ;
                app.email=response.data.user.email;
                app.telephone=response.data.user.telephone;
                app.address=response.data.user.address;
                app.reset_form();

                })
                .catch(function (error) {
                    if (error.response) {
                        //app.errors = error.response.data.errors;
                        console.log(error.response.data.errors);

                        app.$set(app,'errors', error.response.data.errors);
                    notify('Erreurs!','Veuillez vérifier les informations introduites','red', 'topCenter','bounceInDown');
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            },
            reset_form(){
            
               
                this.password='';
                this.password_confirmation='';
                this.errors=[];
                
            },
       
            handleFilesUpload() {
                this.decision_file = this.$refs.files.files;
                this.decision_file_name = this.decision_file[0].name;
                $('#decision-file').val(this.decision_file_name);

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
        updated() {
            // this.fetch_notifications();
        }


    });

</script>







@endsection
