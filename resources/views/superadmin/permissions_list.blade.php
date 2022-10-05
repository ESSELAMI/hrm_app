@extends('layouts.base')

@section('page_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('pages/list-scroll/list.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/stroll/css/stroll.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/demo.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/j-pro-modern.css') }}">


@endsection

@section('page_title')
<h4>Liste des permissions</h4>
<span>Ajouter, modifer ou supprimer une permission </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
<a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
<a href="{{ route('permissions-list') }}">Liste des permissions</a>
</li>
@endsection


@include('superadmin.navigation')


@section('page_content')
<div class="row">
    <!-- Modal static-->
    <div class="modal fade" id="add-permission-modal" tabindex="-1" permission="dialog">
        <div class="modal-dialog" permission="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" :class="[errors.name ? 'form-control form-control-danger' : 'form-control form-control-success']"
                    placeholder="Entrer le nom du rôle..." maxlength="25"
                    v-model="newPermission" required v-on:input="errors.name=null"/>
                <p class="text-danger m-t-5" v-if="errors.name" >@{{errors.name.toString()}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" v-on:click="add_permission()" >Sauvgarder</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-permission-modal" tabindex="-1" permission="dialog">
        <div class="modal-dialog" permission="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifer une permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" :class="[errors.name ? 'form-control form-control-danger' : 'form-control form-control-success']"
                maxlength="25" required v-on:input="errors.name=null" :placeholder="selectedPermissionName"
                v-model="permissionName"/>
                <p class="text-danger m-t-5" v-if="errors.name" >@{{errors.name.toString()}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" v-on:click="update_permission(permissionName,selectedPermissionIndex)" >Sauvgarder</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">

        <div class="card">
            <div class="card-header table-card-header">

                <h5>Liste des permissions</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter une permission">
                                <i class="feather icon-plus text-success md-trigger" data-toggle="modal"
                                   data-target="#add-permission-modal">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal static-->
            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="permissions-table" class="table table-hover table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Permission</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(permission, index) in permissions" v-bind:key="index"
                            v-on:click="selectedPermissionIndex = index">
                                <td>@{{ index+1}}</td>
                                <td>@{{ permission.name }}</td>
                                <td>
                                    <div class="text-center">
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="Modifier">
                                            <i class="feather icon-edit text-custom f-18 clickable md-trigger"
                                                data-toggle="modal" data-target="#edit-permission-modal"
                                                v-on:click="permissionName=permission.name,selectedPermission=permission.id">
                                            </i>
                                        </span>
                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="deletePermission(permission.id, index)"
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
<script type="text/javascript" src="{{ asset('bower_components/bootstrap-maxlength/js/bootstrap-maxlength.js') }}"></script>

<script>
const app = new Vue({
  el: '#app',
        data(){
            return {
                selectedPermission:'',
                permissionName:'',
                newPermission:'',
                selectedPermissionName:'',
                selectedPermissionIndex:'',
                permission_permissions:[],
                permissions:[],
                permissions:[],
                selectedPermissions:[],
                errors:[],
                notifications:[],
                notifications_fetched: false,
            }
        },
        methods:{
            deletePermission(id, index){
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
                            axios.delete('/permission_delete/' +id)
                        .then(function (response) {
                            if (response.data.success) {
                                app.permissions.splice(index,1)
                                app.selectedPermissionName = '';
                                app.selectedPermissionIndex = '';
                                notify('Succès',response.data.success,'green', 'topCenter','bounceInDown');
                            }else {
                                notify('Erreur',response.data.error,'red', 'topCenter','bounceInDown');
                            }
                            });
                        }
                        }
                    );

            },
            fetch_permissions() {
                  return axios.get('/getPermissions')
                        .then(response => this.permissions = response.data.permissions)
                        .catch();
            },
            add_permission(){
                axios.post('/permission_add', {'name':app.newPermission})
                .then(function (response) {
                    app.permissions.push(response.data.permission);
                    $('#add-permission-modal').modal('toggle');
                    app.newPermission = '';
                    app.selectedPermissionName = '';
                    app.selectedPermissionIndex = '';
                    notify('Succès',response.data.success,'green', 'topCenter','bounceInDown');
                })
                .catch(function (error) {
                    if (error.response) {
                       app.$set(app,'errors', error.response.data.errors);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            },
            update_permission(name,index){
                axios.put('/permission_edit/'+this.selectedPermission, {'name':name})
                .then(function (response) {
                    app.$set(app.permissions,index,response.data.permission);
                    $('#edit-permission-modal').modal('toggle');
                    app.permissionName = '';
                    notify('Succès',response.data.success,'green', 'topCenter','bounceInDown');
                })
                .catch(function (error) {
                    if (error.response) {
                        app.$set(app,'errors', error.response.data.errors);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            },
        },
        created() {
            console.log('PermissionsList created..');
            this.fetch_permissions();
        },
});
</script>

@endsection
