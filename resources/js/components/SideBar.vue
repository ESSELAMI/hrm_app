<template>
<div class="pcoded-navigatio-lavel">Menu principal</div>
<ul class="pcoded-item">
    <li class="{{ (\Request::route()->getName() == 'home') ? 'active' : '' }}">
        <router-link to="/">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Accueil</span>
        </router-link>
    </li>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-user"></i></span>
            <span class="pcoded-mtext" >Options du compte</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ (\Request::route()->getName() == '') ? 'active' : '' }}">
                <a href="">
                    <span class="pcoded-mtext" >Mon profile</span>
                </a>
            </li>
            <li class="{{ (\Request::route()->getName() == '') ? 'active' : '' }}">
                <a href="">
                    <span class="pcoded-mtext" >Changer mot de passe</span>
                </a>
            </li>  
           {{--  <li class=" ">
                <a href="notifications_v">
                    <span class="pcoded-mtext" >Notifications</span>
                    <span class="pcoded-badge label label-danger">NOUVEAU</span>
                </a>
            </li> --}}

        </ul>
    </li>
</ul>
<div class="pcoded-navigatio-lavel">Gestion des tables</div>
<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
            <span class="pcoded-mtext" >Utilisateur</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ (\Request::route()->getName() == '') ? 'active' : '' }}">
                <router-link to="/">
                    <span class="pcoded-mtext">Ajouter un utilisateur</span>
                </router-link>
            </li>
            <li class="{{ (\Request::route()->getName() == '') ? 'active' : '' }}">
                <router-link to="/">
                    <span class="pcoded-mtext" >Liste des utilisateurs</span>
                </router-link>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'roles-permissions') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-key"></i></span>
            <span class="pcoded-mtext" >Roles - Permissions</span>
        </a>
        <ul class="pcoded-submenu ">
            <li class="{{ (\Request::route()->getName() == 'roles-permissions') ? 'active' : '' }}">
            <a href="/roles_permissions">
                    <span class="pcoded-mtext" >Roles et Permissions </span>
            </a>
            </li>
        </ul>
    </li>
  </ul>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
