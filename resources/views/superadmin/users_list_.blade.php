@extends('layouts.base')

@section('page-styles')
<style>

         </style>
     
@endsection

@section('page_title')
<h4>Liste des utilisateurs</h4>
<span>Ajouter, modifer ou supprimer un utilisateur </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('users-list') }}">Liste des utilisateurs</a>
</li>
@endsection


@include('superadmin.navigation')


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
                                    <i class="text-danger m-t-5" v-if="errors.fullname" >@{{errors.fullname.toString()}}</i>
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
                                        <input type="radio" name="role" value="{{$role->id}}" 
                                        @foreach ($user->roles as $r)
                                            @if ($r->id === $role->id )
                                                checked
                                            @endif 
                                        @endforeach
                                        >
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
                                    <option value="{{$permission->id}}"  
                                      @foreach ($user->permissions as $p)
                                          @if ($p->id === $permission->id)
                                              selected ="selected"
                                          @endif
                                      @endforeach
                                        >{{$permission->name }}</option>
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
                                <button type="submit" class="btn btn-primary m-r-10" v-on:click="update_user({{$user->id}})">Sauvguarder</button>
                                <button type="submit" class="btn btn-default" v-on:click="reset_form()">Réinitialiser</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header table-card-header">
                <h5>Liste des utilisateurs</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un utilisateur">
                                <i class="feather icon-plus text-success md-trigger" data-toggle="modal" data-target="#add-user-modal">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="users-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Username</th>
                                <th>Nom - Prénom</th>
                                <th>Email</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th>Etat</th>
                                <th>Adresse-ip</th>
                                <th>Last-adresse-ip</th>
                                <th>Agence</th>
                                <th>Code-wilaya</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                            <tr id="tr_{{$index}}">
                                <td>{{ $index+1}}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->status }}</td>
                                <td>{{ $user->ip_address }}</td>
                                <td>{{ $user->last_ip_address }}</td>
                                <td>{{ $user->structure->name }}</td>
                                <td>{{ $user->structure->state }}</td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{ route('edit-user', $user->id) }}">
                                            <i data-toggle="tooltip" data-placement="top" data-original-title="Modifier"
                                             class="feather icon-edit text-custom f-18 clickable md-trigger">
                                            </i>
                                        </a>
                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="delete_user({{$user->id}},{{$index}})"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                        </i>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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
$(document).ready(function() {
    $('#users-table').DataTable();

    $('#permissions').multiSelect({
                selectableHeader: "<div class='custom-header bg-inverse'>Les permissions disponibles</div>",
                selectionHeader: "<div class='custom-header bg-inverse'>Les permissions sélectionnées</div>",
                selectableOptgroup: true,
                keepOrder: true
            });
            $('#structure-types').select2({
                placeholder: "Type du structure.."
            });
            $('#structures').select2({
                placeholder: "Nom du structure.."
            });
});
</script>

<script>
const app = new Vue({
    el: '#app',
    data() {
        return {
            fullname: '',
            email: '',
            phone: '',
            address: '',
            username: '',
            password: '',
            password_confirmation: '',
            structure_id: '',
            role_id: '',
            permissions: [],
            selectedPermissions: [],
            notifications:[],
            notifications_fetched: false,
            errors: [],
        }
    },
    methods: {
        delete_user(id, index) {
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
                        axios.delete('/user_delete/' + id)
                            .then(function (response) {
                                if (response.data.error) {
                                    // app.users.splice(index,1)
                                    notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');
                                } else {
                                    $('#tr_' + index).remove();
                                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                }
                            });
                    }
                }
            )

        },
        update_user() {
            var app = this;
            app.permissions = '';
            app.structure_id = $('#structures').select2().val();
            app.selectedPermissions = $('#permissions').multiSelect().val();
            console.log(app.selectedPermissions.length)
            if (app.selectedPermissions.length > 0) {
                app.selectedPermissions = app.selectedPermissions.toString().split(',').map(Number);
                app.permissions = app.selectedPermissions;
            }

            console.log(app.permissions)
            console.log($('#permissions').multiSelect().val())
            axios.post('/update_user', {
                    'fullname': app.fullname,
                    'email': app.email,
                    'phone': app.phone,
                    'address': app.address,
                    'username': app.username,
                    'password': app.password,
                    'password_confirmation': app.password_confirmation,
                    'structure_id': app.structure_id,
                    'role_id': app.role_id,
                    'permissions': app.permissions
                })
                .then(function (response) {
                    notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    app.reset_form();

                })
                .catch(function (error) {
                    if (error.response) {
                        //app.errors = error.response.data.errors;
                        console.log(error.response.data.errors);

                        app.$set(app, 'errors', error.response.data.errors);
                        notify('Erreurs!', 'Veuillez vérifier les informations introduites', 'red', 'topCenter', 'bounceInDown');
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
        },
    },
});
            
</script>

@endsection
