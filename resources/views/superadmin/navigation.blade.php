
@section('navigation_bar')
<div class="pcoded-navigatio-lavel">Menu principal</div>
<ul class="pcoded-item">
    <li class="{{ (\Request::route()->getName() == 'home') ? 'active' : '' }}">
        <a href="{{ route('home') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Accueil</span>
        </a>
    </li>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-user"></i></span>
            <span class="pcoded-mtext">Options du compte</span>
        </a>
        <ul class="pcoded-submenu">
        <li class="{{ (\Request::route()->getName() == 'user-profile') ? 'active' : '' }}">
                <a href="/user_profile">
                    <span class="pcoded-mtext">Mon profile</span>
                </a>
            </li>
            {{-- <li class=" ">
                <a href="notifications_v">
                    <span class="pcoded-mtext">Notifications</span>
                    <span class="pcoded-badge label label-danger">NOUVEAU</span>
                </a>
            </li> --}}

        </ul>
    </li>
</ul>
<div class="pcoded-navigatio-lavel">Gestion des tables</div>
<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'commune-distances-list' ) ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
            <span class="pcoded-mtext">Kilometrage</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ (\Request::route()->getName() == 'commune-distances-list') ? 'active' : '' }}">
                <a href="/commune_distances_list">
                    <span class="pcoded-mtext">Tableau de kilometrage</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'users-list' || \Request::route()->getName() == 'create-user' ) ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
            <span class="pcoded-mtext">Utilisateur</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ (\Request::route()->getName() == 'create-user') ? 'active' : '' }}">
                <a href="/create_user">
                    <span class="pcoded-mtext">Ajouter un utilisateur</span>
                </a>
            </li>
            <li class="{{ (\Request::route()->getName() == 'users-list') ? 'active' : '' }}">
                <a href="/users_list">
                    <span class="pcoded-mtext">Liste des utilisateurs</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'roles-list' || \Request::route()->getName() == 'permissions-list' ) ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-key"></i></span>
            <span class="pcoded-mtext">Roles - Permissions</span>
        </a>
        <ul class="pcoded-submenu ">
            <li class="{{ (\Request::route()->getName() == 'roles-list') ? 'active' : '' }}">
                <a href="/roles_list">
                    <span class="pcoded-mtext">Liste des rôles </span>
                </a>
            </li>
        </ul>
        <ul class="pcoded-submenu ">
            <li class="{{ (\Request::route()->getName() == 'permissions-list') ? 'active' : '' }}">
                <a href="/permissions_list">
                    <span class="pcoded-mtext">Liste des permissions </span>
                </a>
            </li>
        </ul>
    </li>
</ul>
@endsection
