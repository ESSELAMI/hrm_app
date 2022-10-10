@extends('layouts.base')

@section('page_styles')

<link rel="stylesheet" type="text/css" href="{{ asset('pages/list-scroll/list.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/stroll/css/stroll.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/demo.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/j-pro-modern.css') }}">


@endsection

@section('page_title')
<h4>Liste des roles</h4>
<span>Ajouter, modifer ou supprimer un roles </span>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}"> <i class="feather icon-home"></i></a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('roles-list') }}">Liste des roles</a>
</li>
@endsection


@include('superadmin.navigation')


@section('page_content')
<div class="row">
    <!-- Modal static-->
    <div class="modal fade" id="add-role-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un rôle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" :class="[errors.name ? 'form-control form-control-danger' : 'form-control form-control-success']" placeholder="Entrer le nom du rôle..." maxlength="25" v-model="newRole" required v-on:input="errors.name=null" />
                    <p class="text-danger m-t-5" v-if="errors.name">@{{errors.name.toString()}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" v-on:click="add_role()">Sauvgarder</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-role-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifer un rôle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" :class="[errors.name ? 'form-control form-control-danger' : 'form-control form-control-success']" maxlength="25" required v-on:input="errors.name=null" :placeholder="selectedRoleName" v-model="roleName" />
                    <p class="text-danger m-t-5" v-if="errors.name">@{{errors.name.toString()}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" v-on:click="update_role(roleName,selectedRoleIndex)">Sauvgarder</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="assign-permissions-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"> Atrribuer des permissions pour le rôle : <span v-if="selectedRoleName" class="label label-info"> <strong> @{{selectedRoleName}} </strong></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select multiple="multiple" id="test" v-model="selectedPermissions" style="height:400px">
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" v-on:click="assign_permissions()">Sauvgarder</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">

        <div class="card">
            <div class="card-header table-card-header">

                <h5>Liste des rôles</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Ajouter un rôle">
                                <i class="feather icon-plus text-success md-trigger" data-toggle="modal" data-target="#add-role-modal">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal static-->
            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="roles-table" class="table table-hover table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Rôle</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(role, index) in roles" v-bind:key="index" :class="{'selected-row': selectedRoleName === role.name}" v-on:click="showPermissions(role, role.permissions),selectedRoleIndex = index">
                                <td>@{{ index+1}}</td>
                                <td>@{{ role.name }}</td>
                                <td>
                                    <div class="text-center">
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="Modifier">
                                            <i class="feather icon-edit text-custom f-18 clickable md-trigger" data-toggle="modal" data-target="#edit-role-modal" v-on:click="roleName=role.name">
                                            </i>
                                        </span>
                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="deleteRole(role.id, index)" data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                        </i>
                                        <i class="feather icon-lock text-warning f-18 clickable" v-on:click="showPermissions(role, role.permissions)" data-toggle="tooltip" data-placement="top" data-original-title="Afficher les Permissions">
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

    <div class="col-md-7">
        <div class="card">
            <div class="card-header table-card-header">

                <h5>Liste des permissions associées pour le rôle: <span class="label label-info" v-if="selectedRoleName"> <strong>@{{selectedRoleName}} </strong></span> </h5>

                <div class="card-header-right" v-if="selectedRoleName">
                    <ul class="list-unstyled card-option">
                        <li>
                            <span data-toggle="tooltip" data-placement="left" data-original-title="Attribuer des permissions">
                                <i class="feather icon-plus text-success md-trigger" data-toggle="modal" data-target="#assign-permissions-modal" v-on:click="get_selected_permissions()">
                                </i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal static-->
            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="permissions-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Permissions</th>
                                <th style="width:50px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(permission, index) in role_permissions" :key="index">
                                <td>@{{ index+1}}</td>
                                <td>@{{ permission.name }}</td>
                                <td>
                                    <div class="text-center">
                                        <i class="feather icon-trash text-danger f-18 clickable" data-toggle="tooltip" data-placement="top" data-original-title="Supprimer" v-on:click="revoke_permission(permission.id,index)">
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


    {{-- <div class="col-sm-5">
            <select name="from" id="optgroup" class="form-control" size="8" multiple="multiple">

        <option v-for="(permission, index) in permissions" value="permission.id">@{{permission.name}}</option>


    </select>
</div>

<div class="col-sm-2">
    <button type="button" id="optgroup_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
    <button type="button" id="optgroup_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
    <button type="button" id="optgroup_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
    <button type="button" id="optgroup_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
</div>

<div class="col-sm-5">
    <select name="to" id="optgroup_to" class="form-control" size="8" multiple="multiple">
    </select>
</div> --}}



</div>


@endsection

@section('page_scripts')
<script type="text/javascript" src="{{ asset('bower_components/bootstrap-maxlength/js/bootstrap-maxlength.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#test').multiSelect({
            selectableHeader: "<div class='custom-header'>Les permissions disponibles</div>",
            selectionHeader: "<div class='custom-header'>Les permissions sélectionnées</div>",

        });

        $('#assign-permissions-modal').on('hide.bs.modal', function() {
            $('#test').multiSelect('deselect_all');
        });
    });
</script>
<script>
    const app = new Vue({
        el: '#app',
        data() {
            return {
                selectedRole: '',
                roleName: '',
                newRole: '',
                selectedRoleName: '',
                selectedRoleIndex: '',
                role_permissions: [],
                roles: [],
                permissions: [],
                selectedPermissions: [],
                errors: [],
                notifications: [],
                notifications_fetched: false,
            }
        },
        computed: {
            //  ...mapGetters ({
            //     allroles :'ALL_ROLES',
            //     //'role_permissions',
            //  })
            get_roles() {
                return this.roles;
            }
        },
        methods: {
            showPermissions(role, permissions) {
                app.role_permissions = permissions;
                console.log(permissions);
                app.selectedRole = role.id;
                app.selectedRoleName = role.name;
                console.log(app.selectedRole);
            },
            deleteRole(id, index) {
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
                            axios.delete('/role_delete/' + id)
                                .then(function(response) {
                                    if (response.data.success) {
                                        app.roles.splice(index, 1)
                                        app.selectedRoleName = '';
                                        app.selectedRoleIndex = '';
                                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                                    } else {
                                        notify('Erreur', response.data.error, 'red', 'topCenter', 'bounceInDown');
                                    }
                                });
                        }
                    }
                );

            },

            fetch_roles() {
                return axios.get('/getRoles')
                    .then(response => this.roles = response.data.roles)
                    .catch();


            },
            fetch_permissions() {
                return axios.get('/getPermissions')
                    // .then(response => this.permissions = response.data.permissions)
                    .then(function(response) {
                        this.permissions = response.data.permissions;
                        this.permissions.forEach(permission => {
                            $('#test').multiSelect(
                                'addOption', {
                                    value: permission.id,
                                    text: permission.name
                                },
                            );
                        });
                    })
                    .catch();
            },
            add_role() {
                axios.post('/role_add', {
                        'name': app.newRole
                    })
                    .then(function(response) {
                        app.roles.push(response.data.role);
                        $('#add-role-modal').modal('toggle');
                        app.newRole = '';
                        app.selectedRoleName = '';
                        app.selectedRoleIndex = '';
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            update_role(name, index) {
                axios.put('/role_edit/' + this.selectedRole, {
                        'name': name
                    })
                    .then(function(response) {
                        app.$set(app.roles, index, response.data.role);
                        $('#edit-role-modal').modal('toggle');
                        app.roleName = '';
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });

            },
            assign_permissions() {
                this.selectedPermissions = $('#test').multiSelect().val();
                var permissions = this.selectedPermissions.toString().split(',').map(Number);
                axios.post('/role_assign_permissions/' + this.selectedRole, {
                        'permissions': permissions
                    })
                    .then(function(response) {
                        // app.$set(app.roles,index,response.data.role);
                        // app.fetch_roles();
                        $('#assign-permissions-modal').modal('toggle');
                        app.role_permissions = response.data.permissions;
                        console.log(response.data.roles);
                        console.log(app.roles);

                        app.roles = response.data.roles;
                        console.log(app.roles);
                        app.selectedPermissions = '';
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            revoke_permission(id, index) {
                console.log(app.roles[0].permissions);
                console.log(this.selectedRole);
                console.log(this.selectedRoleIndex);
                console.log(index);

                axios.post('/role_revoke_permission/' + this.selectedRole, {
                        'permission': id
                    })
                    .then(function(response) {
                        console.log(app.role_permissions);

                        app.$delete(app.role_permissions, index, 1);
                        console.log(app.role_permissions);


                        app.roles[app.selectedRoleIndex].permissions.slice(index, 1);
                        //app.fetch_roles();
                        // app.selectedRole = '';
                        notify('Succès', response.data.success, 'green', 'topCenter', 'bounceInDown');
                    })
                    .catch(function(error) {
                        if (error.response) {
                            app.$set(app, 'errors', error.response.data.errors);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            get_selected_permissions() {
                $('#test').multiSelect('select', app.role_permissions.map(p => p.id + ''));

            },
        },
        created() {
            console.log('RolesList created..');
            this.fetch_roles();
            this.fetch_permissions();
            console.log(this.permissions);
            this.fetch_permissions()
        },
        mounted() {
            $('#optgroup').multiSelect();
            this.fetch_permissions();
        }
    });
    $('#optgroup').multiSelect({
        selectableHeader: "<div class='custom-header'>Selectable items</div>",
        selectionHeader: "<div class='custom-header'>Selection items</div>"
    });
</script>

@endsection