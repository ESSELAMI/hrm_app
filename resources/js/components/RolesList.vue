<template>
<div class="row">
 <!-- Modal static-->
<div class="modal fade" id="role-modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un rôle</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
            </div>
            <div class="modal-body">
                <h5>Static Modal</h5>
                hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
                kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary waves-effect waves-light ">Sauvgarder</button>
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
                            <i class="feather icon-plus text-success md-trigger" data-toggle="modal" data-target="#role-modal"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal static-->
            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="roles-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                 <th class="text-center" style="width:20px">#</th>
                                <th>Rôle</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(role, index) in allroles" :key="index">
                                <td>{{ index+1}}</td>
                                <td>{{ role.name }}</td>
                                <td>
                                    <div class="text-center">
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="Modifier">
                                            <i class="feather icon-edit text-custom f-18 clickable md-trigger"
                                                data-toggle="modal" data-target="#edit-role-modal">
                                            </i>
                                        </span>
                                        <i class="feather icon-trash text-danger f-18 clickable" v-on:click="deleteRole(role.id, index)"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Supprimer">
                                        </i>
                                        <i class="feather icon-lock text-warning f-18 clickable" v-on:click="showPermissions(role, role.permissions)"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Afficher les Permissions">
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

                <h5>Liste des permissions associées pour le rôle: {{selectedRoleName}}  </h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li>
                            <i class="feather icon-plus text-success md-trigger" data-toggle="modal" data-target="#role-modal"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal static-->
            <div class="card-block">
                <div class="dt-responsive table-responsive" :style="[role_permissions.length > 0 ? {'overflow' : 'scroll-y', 'height': (role_permissions.length*100)/1.5+'px'} : {'':''}]">

                    <table id="permissions-table" class="table table-striped table-bordered nowrap" >
                        <thead>
                            <tr>
                                <th class="text-center" style="width:20px">#</th>
                                <th>Permissions</th>
                                <th style="width:50px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(permission, index) in role_permissions" :key="index">
                                <td>{{ index+1}}</td>
                                <td>{{ permission.name }}</td>
                                <td>
                                    <div class="text-center">
                                        <i class="feather icon-trash text-danger f-18 clickable"
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
</template>



<script>

   import {mapState, mapGetters} from 'vuex'
     export default {
        data(){
            return {
                selectedRole:'',
                selectedRoleName:'',
                role_permissions:[],
            }
        },
        computed: {
             ...mapGetters ({
                allroles :'ALL_ROLES',
                //'role_permissions',
             })
        },
        methods:{
            showPermissions(role, permissions){
                this.role_permissions = permissions;
                console.log(permissions);

                this.selectedRole = role.id;
                this.selectedRoleName = role.name;
                console.log(this.selectedRole);
            },
            deleteRole(id, index){
                if(confirm("Sure ! wanna delete this??")){
                    var app = this;
                    axios.delete('/role_delete/' +id)
                     .then(function (response) {
                         app.$store.state.roles.splice(index,1)
                         Vue.delete(app.$store.state.roles, index);
                     })
                }
            },
            revokePermissions(id, index){
                // if(confirm("Sure ! wanna delete this??")){
                //     var app = this;
                //     axios.delete('/role_revoke_permission/' +id)
                //      .then(function (response) {
                //          app.$store.state.permission.splice(index,1)
                //          Vue.delete(app.$store.state.permission, index);
                //      })
                // }
            },

        },
        mounted() {
        console.log('RolesList created..');


       //this.$store.dispatch('fetch_roles');
        //console.log(this.$store.state.roles);
        },

    }
</script>
