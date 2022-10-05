<template>
<div class="card">
    <div class="card-header table-card-header">

        <h5>Liste des permissions</h5>

        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li>
                    <i class="feather icon-plus text-success md-trigger" data-toggle="modal" data-target="#permissions-modal"></i>
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
                        <th>#</th>
                        <th>Permission</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(permission, index) in permissions" :key="index" v-bind:index="index">
                        <td>{{ index+1}}</td>
                        <td>{{ permission.name }}</td>
                        <td>
                            <div class="text-center">
                                <span data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Modifier">
                                <i class="feather icon-edit text-custom f-18 clickable md-trigger" 
                                   data-toggle="modal"
                                   data-target="#edit-permission-modal">
                                </i>
                                </span>
                                <i class="feather icon-trash text-danger f-18 clickable" 
                                   v-on:click="deletePermission(permission.id, index)"
                                   data-toggle="tooltip" data-placement="top"
                                   data-original-title="Supprimer">
                                </i>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>


</div>

</template>

<script>
    import {mapState} from 'vuex'
     export default {
        data(){
            return {
            }
        },
        computed: {
             ...mapState ([
                'permissions',
                'role_permissions',
            ])  
        },
    }
</script>
