
@section('navigation_bar')
<div class="pcoded-navigatio-lavel">Menu principal</div>
<ul class="pcoded-item">
    <li class="{{ (\Request::route()->getName() == 'home') ? 'active' : '' }}">
        <a href="/">
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
                <a href="/change_password">
                    <span class="pcoded-mtext">Notifications</span>
                    <span class="pcoded-badge label label-danger">NOUVEAU</span>
                </a>
            </li> --}}

        </ul>
    </li>
</ul>
<div class="pcoded-navigatio-lavel" >Gestion des tables</div>
<ul class="pcoded-item pcoded-left-item">
{{-- @if(Auth::user()->hasDirectPermission('accès-page-véhicules') || Auth::user()->hasDirectPermission('accès-page-carte-naftal')
|| Auth::user()->hasDirectPermission('accès-page-carte-naftal') || Auth::user()->hasDirectPermission('accès-page-vignettes')
|| Auth::user()->hasDirectPermission('accès-page-contrôle-technique') ) --}}
    {{-- <li id="v-menu" class="pcoded-hasmenu {{ (\Request::route()->getName() == 'agents-list' || \Request::route()->getName() == 'create-vehicle' || \Request::route()->getName() == 'technicalControls.index'|| \Request::route()->getName() == 'annualTaxes.index' || \Request::route()->getName() == 'fuelCards.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)" >
            <span class="pcoded-micon"><i class="icofont icofont-car-alt-1 f-20"></i></span>
            <span class="pcoded-mtext">Agents</span>
            <span class="pcoded-badge label label-warning" >MODIFIER</span>
        </a>
        <ul class="pcoded-submenu"> --}}
        {{-- @if(Auth::user()->hasDirectPermission('ajout véhicule')) --}}
                {{-- <li class="{{ (\Request::route()->getName() == 'create-vehicle') ? 'active' : '' }}">
                    <a href="/create_vehicle">
                        <span class="pcoded-mtext">Ajouter un véhicule</span>
                    </a>
                </li> --}}
        {{-- @endif --}}
        {{-- @if(Auth::user()->hasDirectPermission('accès-page-véhicules'))    --}}
            {{-- <li class="{{ (\Request::route()->getName() == 'vehicles-list') ? 'active' : '' }}">
                <a href="/vehicles_list">
                    <span class="pcoded-mtext">Liste des véhicules</span>
                </a>
            </li> --}}

        {{-- @endif --}}
        {{-- @if(Auth::user()->hasDirectPermission('accès-page-carte-naftal'))       --}}
            {{-- <li class="{{ (\Request::route()->getName() == 'fuelCards.index') ? 'active' : '' }}">
                <a href="/fuelCards">
                    <span class="pcoded-mtext">Cartes NAFTAL</span>
                </a>
            </li> --}}
        {{-- @endif   --}}
        {{-- @if(Auth::user()->hasDirectPermission('accès-page-vignettes'))     --}}
            {{-- <li class="{{ (\Request::route()->getName() == 'annualTaxes.index') ? 'active' : '' }}">
                <a href="/annualTaxes">
                    <span class="pcoded-mtext">Vignettes</span>
                </a>
            </li> --}}
        {{-- @endif  --}}
        {{-- @if(Auth::user()->hasDirectPermission('accès-page-contrôle-technique'))    --}}
            {{-- <li class="{{ (\Request::route()->getName() == 'technicalControls.index') ? 'active' : '' }}">
                <a href="/technicalControls">
                    <span class="pcoded-mtext">Contrôle technique</span>
                </a>
            </li> --}}
        {{-- @endif     --}}
        {{-- </ul> --}}
    {{-- </li> --}}
    {{-- @endif --}}
    {{-- @if(Auth::user()->hasDirectPermission('accès-page-chauffeurs')) --}}
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'fonctions.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-users "></i></span>
            <span class="pcoded-mtext">Fonctions</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'fonctions.index') ? 'active' : '' }}">
                <a href="/fonctions">
                    <span class="pcoded-mtext">Liste des fonctions</span>
                </a>
            </li>
        
        </ul>
    </li>
    

</ul>
<div class="pcoded-navigatio-lavel" >Gestion du personnel</div>
<ul class="pcoded-item pcoded-left-item">
{{-- @if(Auth::user()->hasDirectPermission('accès-page-véhicules') || Auth::user()->hasDirectPermission('accès-page-carte-naftal')
|| Auth::user()->hasDirectPermission('accès-page-carte-naftal') || Auth::user()->hasDirectPermission('accès-page-vignettes')
|| Auth::user()->hasDirectPermission('accès-page-contrôle-technique') ) --}}
    {{-- <li id="v-menu" class="pcoded-hasmenu {{ (\Request::route()->getName() == 'agents-list' || \Request::route()->getName() == 'create-vehicle' || \Request::route()->getName() == 'technicalControls.index'|| \Request::route()->getName() == 'annualTaxes.index' || \Request::route()->getName() == 'fuelCards.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)" >
            <span class="pcoded-micon"><i class="icofont icofont-car-alt-1 f-20"></i></span>
            <span class="pcoded-mtext">Agents</span>
            <span class="pcoded-badge label label-warning" >MODIFIER</span>
        </a>
        <ul class="pcoded-submenu"> --}}
        {{-- @if(Auth::user()->hasDirectPermission('ajout véhicule')) --}}
                {{-- <li class="{{ (\Request::route()->getName() == 'create-vehicle') ? 'active' : '' }}">
                    <a href="/create_vehicle">
                        <span class="pcoded-mtext">Ajouter un véhicule</span>
                    </a>
                </li> --}}
        {{-- @endif --}}
        {{-- @if(Auth::user()->hasDirectPermission('accès-page-véhicules'))    --}}
            {{-- <li class="{{ (\Request::route()->getName() == 'vehicles-list') ? 'active' : '' }}">
                <a href="/vehicles_list">
                    <span class="pcoded-mtext">Liste des véhicules</span>
                </a>
            </li> --}}

        {{-- @endif --}}
        {{-- @if(Auth::user()->hasDirectPermission('accès-page-carte-naftal'))       --}}
            {{-- <li class="{{ (\Request::route()->getName() == 'fuelCards.index') ? 'active' : '' }}">
                <a href="/fuelCards">
                    <span class="pcoded-mtext">Cartes NAFTAL</span>
                </a>
            </li> --}}
        {{-- @endif   --}}
        {{-- @if(Auth::user()->hasDirectPermission('accès-page-vignettes'))     --}}
            {{-- <li class="{{ (\Request::route()->getName() == 'annualTaxes.index') ? 'active' : '' }}">
                <a href="/annualTaxes">
                    <span class="pcoded-mtext">Vignettes</span>
                </a>
            </li> --}}
        {{-- @endif  --}}
        {{-- @if(Auth::user()->hasDirectPermission('accès-page-contrôle-technique'))    --}}
            {{-- <li class="{{ (\Request::route()->getName() == 'technicalControls.index') ? 'active' : '' }}">
                <a href="/technicalControls">
                    <span class="pcoded-mtext">Contrôle technique</span>
                </a>
            </li> --}}
        {{-- @endif     --}}
        {{-- </ul> --}}
    {{-- </li> --}}
    {{-- @endif --}}
    {{-- @if(Auth::user()->hasDirectPermission('accès-page-chauffeurs')) --}}
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'agents.index' || \Request::route()->getName() == 'confirmedLevels.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-users "></i></span>
            <span class="pcoded-mtext">Agents</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'agents.index') ? 'active' : '' }}">
                <a href="/agents">
                    <span class="pcoded-mtext">Liste des agents</span>
                </a>
            </li>
            <!-- <li class="{{ (\Request::route()->getName() == 'confirmedLevels.index') ? 'active' : '' }}">
                <a href="/confirmedLevels">
                    <span class="pcoded-mtext">Mise à jour échelon</span>
                </a>
            </li> -->
        
        </ul>
    </li>
    {{-- @endif --}}
    {{-- @if(Auth::user()->hasDirectPermission('accès-page-assurances')) --}}
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'missions.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-ui-fire-wall"></i></span>
            <span class="pcoded-mtext">Frais missions</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'missions.index') ? 'active' : '' }}">
                <a href="/missions">
                    <span class="pcoded-mtext">Liste des missions</span>
                </a>
            </li>
           
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'leavedocs.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-ui-fire-wall"></i></span>
            <span class="pcoded-mtext">Bons de sortie</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'leavedocs.index') ? 'active' : '' }}">
                <a href="/leavedocs">
                    <span class="pcoded-mtext">Liste des bons sortie</span>
                </a>
            </li>
           
        </ul>
    </li>

</ul>
@endsection
