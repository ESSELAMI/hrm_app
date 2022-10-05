@extends('layouts.base')

@section('page-styles')
    <style>
   .select2-container--default .select2-selection--single .select2-selection__rendered{
        background-color: white;
        color: black;
    }
    .ms-container .ms-selectable li.ms-hover, .ms-container .ms-selection li.ms-hover {
    background-color: #404e67;
}
    </style>
@endsection

@section('page_title')
<h4>Ajouter un utilisateur</h4>
<span>Veuillez remplir le formulaire suivant</span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('create-user') }}">Ajouter un utilisateur</a>
</li>
@endsection


@include('admin.navigation')


@section('page_content')
<div class="row">
<div class="col-lg-12 ">
        <!-- Flying Word card start -->
        <div class="card">
            <div class="card-header">
                <h5 class="text-danger">Veuillez remplir tous les champs obligatoires (*)</h5>
            <div v-if="errors.length"> @{{ errors}}</div>
            </div>
            <div class="card-block">
                <h6 class="sub-title">Détails personnels <span class="text-danger">(*)</span> </h6>
                <form >
                    <div class="form-group row">
                        <div :class="[errors.fullname ? 'col-sm-4 m-b-5 input-group input-group-danger' : 'col-sm-4 m-b-5 input-group input-group-inverse']">
                            {{-- <i class="text-danger m-t-5" v-if="errors.fullname" >@{{errors.fullname.toString()}}</i> --}}
                            <input id="fullname" type="text" class="form-control" placeholder="Nom et Prénom" v-model="fullname" data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.fullname" >
                            <span class="input-group-addon">
                                <i class="icofont icofont-user" data-toggle="tooltip" data-placement="top" :data-original-title="errors.fullname"></i>
                            </span>
                        </div>
                        <div :class="[errors.email ? 'col-sm-4 input-group input-group-danger' : 'col-sm-4 input-group input-group-inverse']">
                            <input type="text" class="form-control" placeholder="Email" v-model="email"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.email">
                            <span class="input-group-addon">
                                <i class="icofont icofont-mail"></i>
                            </span>
                        </div>
                        <div :class="[errors.phone ? 'col-sm-4 input-group input-group-danger' : 'col-sm-4 input-group input-group-inverse']">
                            <input type="text" class="form-control" placeholder="Numéro de téléphone" v-model="phone"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.phone">
                            <span class="input-group-addon">
                                <i class="icofont icofont-phone"></i>
                            </span>
                        </div>
                        <div :class="[errors.address ? 'col-sm-12 input-group input-group-danger' : 'col-sm-12 input-group input-group-inverse']">
                            <input type="text" class="form-control" placeholder="Adresse" v-model="address"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.address">
                            <span class="input-group-addon">
                                <i class="icofont icofont-location-pin"></i>
                            </span>
                        </div>
                    </div>
                </form>
                <hr>
                <h5 class="sub-title">Affectation et Informations d'identification <span class="text-danger">(*)</span></h5>
                <form>
                    <div class="form-group row">
                        <div :class="[errors.username ? 'col-sm-4 m-b-5 input-group input-group-danger' : 'col-sm-4 m-b-5 input-group input-group-inverse']">
                            <input type="text" class="form-control" placeholder="Nom d'utilisateur"
                            data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.username" v-model="username">
                            <span class="input-group-addon">
                                <i class="icofont icofont-business-man-alt-2"></i>
                            </span>
                        </div>
                        <div :class="[errors.password ? 'col-sm-4 input-group input-group-danger' : 'col-sm-4 input-group input-group-inverse']"
                        data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.password">
                            <input type="password" class="form-control" placeholder="Mot de passe" v-model="password">
                            <span class="input-group-addon">
                                <i class="icofont icofont-lock"></i>
                            </span>
                        </div>
                        <div :class="[errors.password ? 'col-sm-4 input-group input-group-danger' : 'col-sm-4 input-group input-group-inverse']"
                        data-toggle="tooltip" data-placement="top"
                        :data-original-title="errors.password">
                            <input type="password" class="form-control" placeholder="Confirmation du mot de passe" v-model="password_confirmation">
                            <span class="input-group-addon">
                                <i class="icofont icofont-lock"></i>
                            </span>
                        </div>
                    </div>
                </form>
                <hr>
                <h5 class="sub-title">Rôle et permissions <span class="text-danger">(*)</span></h5>
                <form class="row">
                    <div class="form-radio col-md-3">
                        <h4 class="sub-title">Sélectionner un rôle <span class="text-danger">(*)</span></h4>
                        <p class="text-danger text-center m-t-5" v-if="errors.role_id" >@{{errors.role_id.toString()}}</p>
                        @foreach ($roles as $role)
                            <div class="radio radiofill  radio-inverse m-l-10 ">
                                <label class="clickable">
                                <input type="radio" name="radio" value="{{$role->id}}" v-model="role_id">
                                    <i class="helper"></i> {{$role->name}}
                                </label>
                            </div>
                        @endforeach

                    </div>
                    <div class="col-md-9">
                        <h4 class="sub-title text-center ">Sélectionner des permissions <span class="text-danger">(*)</span></h4>
                        <p class="text-danger text-center m-t-5" v-if="errors.permissions" >@{{errors.permissions.toString()}}</p>
                        <select class="form-control form-control-inverse" multiple="multiple" id="permissions">
                            @foreach ($roles as $role)
                        <optgroup label="{{$role->name}}">
                            @foreach ($role->permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->name }}</option>
                            @endforeach

                        </optgroup>

                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-primary m-r-10" v-on:click="add_user()">Sauvguarder</button>
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
$(document).ready(function() {

    $('#permissions').multiSelect({
        selectableHeader: "<div class='custom-header bg-inverse'>Les permissions disponibles</div>",
        selectionHeader: "<div class='custom-header bg-inverse'>Les permissions sélectionnées</div>",
        selectableOptgroup: true,
        keepOrder: true
    });



});
</script>
<script>
const app = new Vue({
  el: '#app',
        data(){
            return {
                fullname:'',
                email:'',
                phone:'',
                address:'',
                username:'',
                password:'',
                password_confirmation:'',
                structure_id:'',
                role_id:'',
                notifications:[],
                permissions:[],
                selectedPermissions:[],
                errors:[],
            }
        },
        mounted() {
         this.fetch_notifications();
         this.reset_form();

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
          add_user(){
                var app = this;
                app.structure_id = $('#structures').select2().val();
                var selectedPermissions = $('#permissions').multiSelect().val();
                    selectedPermissions = selectedPermissions.toString().split(',').map(Number);
                if (selectedPermissions != 0) {
                    app.permissions = selectedPermissions;
                }

                 console.log(app.permissions.toString() )
                axios.post('/add_user', {
                    'fullname':app.fullname,
                    'email':app.email,
                    'telephone':app.phone,
                    'address':app.address,
                    'username':app.username,
                    'password':app.password,
                    'password_confirmation':app.password_confirmation,
                     'structure_id':'<?php echo Auth::user()->structure_id ?>',
                    'role_id':app.role_id,
                    'permissions':app.permissions
                })
                .then(function (response) {
                    notify('Succès',response.data.success,'green', 'topCenter','bounceInDown');
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
                this.fullname='';
                this.email='';
                this.phone='';
                this.address='';
                this.username='';
                this.password='';
                this.password_confirmation='';
                this.structure_id='';
                this.role_id='';
                this.permissions=[];
                this.errors=[];
                // $('#permissions').multiSelect('deselect_all');
            },


        },



});

</script>







@endsection
