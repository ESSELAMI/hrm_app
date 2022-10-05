
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
<div class="pcoded-navigatio-lavel" >Gestion du parc</div>
<ul class="pcoded-item pcoded-left-item">
{{-- @if(Auth::user()->hasDirectPermission('accès-page-véhicules') || Auth::user()->hasDirectPermission('accès-page-carte-naftal')
|| Auth::user()->hasDirectPermission('accès-page-carte-naftal') || Auth::user()->hasDirectPermission('accès-page-vignettes')
|| Auth::user()->hasDirectPermission('accès-page-contrôle-technique') )
    <li id="v-menu" class="pcoded-hasmenu {{ (\Request::route()->getName() == 'vehicles-list' || \Request::route()->getName() == 'create-vehicle' || \Request::route()->getName() == 'technicalControls.index'|| \Request::route()->getName() == 'annualTaxes.index' || \Request::route()->getName() == 'fuelCards.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)" >
            <span class="pcoded-micon"><i class="icofont icofont-car-alt-1 f-20"></i></span>
            <span class="pcoded-mtext">Véhicules</span>
            <span class="pcoded-badge label label-warning" >MODIFIER</span>
        </a>
        <ul class="pcoded-submenu">
        @if(Auth::user()->hasDirectPermission('ajout véhicule'))
                <li class="{{ (\Request::route()->getName() == 'create-vehicle') ? 'active' : '' }}">
                    <a href="/create_vehicle">
                        <span class="pcoded-mtext">Ajouter un véhicule</span>
                    </a>
                </li>
        @endif
        @if(Auth::user()->hasDirectPermission('accès-page-véhicules'))   
            <li class="{{ (\Request::route()->getName() == 'vehicles-list') ? 'active' : '' }}">
                <a href="/vehicles_list">
                    <span class="pcoded-mtext">Liste des véhicules</span>
                </a>
            </li>

        @endif
        @if(Auth::user()->hasDirectPermission('accès-page-carte-naftal'))      
            <li class="{{ (\Request::route()->getName() == 'fuelCards.index') ? 'active' : '' }}">
                <a href="/fuelCards">
                    <span class="pcoded-mtext">Cartes NAFTAL</span>
                </a>
            </li>
        @endif  
        @if(Auth::user()->hasDirectPermission('accès-page-vignettes'))    
            <li class="{{ (\Request::route()->getName() == 'annualTaxes.index') ? 'active' : '' }}">
                <a href="/annualTaxes">
                    <span class="pcoded-mtext">Vignettes</span>
                </a>
            </li>
        @endif 
        @if(Auth::user()->hasDirectPermission('accès-page-contrôle-technique'))   
            <li class="{{ (\Request::route()->getName() == 'technicalControls.index') ? 'active' : '' }}">
                <a href="/technicalControls">
                    <span class="pcoded-mtext">Contrôle technique</span>
                </a>
            </li>
        @endif    
        </ul>
    </li>
    @endif
    @if(Auth::user()->hasDirectPermission('accès-page-chauffeurs'))
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'drivers.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-steering "></i></span>
            <span class="pcoded-mtext">Chauffeurs</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'drivers.index') ? 'active' : '' }}">
                <a href="/drivers">
                    <span class="pcoded-mtext">Liste des chauffeurs</span>
                </a>
            </li>
        
        </ul>
    </li>
    @endif
    @if(Auth::user()->hasDirectPermission('accès-page-assurances'))
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'insuranceCompanies.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-ui-fire-wall"></i></span>
            <span class="pcoded-mtext">Agences d'assurance</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'insuranceCompanies.index') ? 'active' : '' }}">
                <a href="/insuranceCompanies">
                    <span class="pcoded-mtext">Liste des compagnies</span>
                </a>
            </li>
           
        </ul>
    </li>
    @endif 
    @if(Auth::user()->hasDirectPermission('accès-page-carburant'))
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'petrolCoupons.index') ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-ui-v-card"></i></span>
            <span class="pcoded-mtext">Carburants</span>
            <span class="pcoded-badge label label-info">NOUVEAU</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'petrolCoupons.index') ? 'active' : '' }}">
                <a href="/petrolCoupons">
                    <span class="pcoded-mtext">Attribution des bons</span>
                </a>
            </li>
            
        </ul>
    </li>
    @endif
    @if(Auth::user()->hasDirectPermission('accès-page-mécaniciens'))
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'mechanics.index' ) ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-worker "></i></span>
            <span class="pcoded-mtext">Mécaniciens</span>
        </a>
        <ul class="pcoded-submenu">
       
            <li class="{{ (\Request::route()->getName() == 'mechanics.index') ? 'active' : '' }}">
                <a href="/mechanics">
                    <span class="pcoded-mtext">Liste des mécaniciens</span>
                </a>
            </li>
         
        </ul>
    </li>
    @endif  
    @if(Auth::user()->hasDirectPermission('accès-page-entretiens'))
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'maintenances.index' ) ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-glue-oil   "></i></span>
            <span class="pcoded-mtext">Entretiens</span>
        </a>
        <ul class="pcoded-submenu">
       
            <li class="{{ (\Request::route()->getName() == 'maintenances.index') ? 'active' : '' }}">
                <a href="/maintenances">
                    <span class="pcoded-mtext">Liste des entretiens</span>
                </a>
            </li>
           
        </ul>
    </li>
    @endif
    @if(Auth::user()->hasDirectPermission('accès-page-accidents'))
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'accidents.index' ) ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-exclamation-tringle "></i></span>
            <span class="pcoded-mtext">Accidents</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'accidents.index') ? 'active' : '' }}">
                <a href="/accidents">
                    <span class="pcoded-mtext">Liste des accidents</span>
                </a>
            </li>
       
        </ul>
    </li>
    @endif 
    @if(Auth::user()->hasDirectPermission('accès-page-réparations'))
    <li class="pcoded-hasmenu {{ (\Request::route()->getName() == 'reparations.index' ) ? 'pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="icofont icofont-wrench "></i></span>
            <span class="pcoded-mtext">Réparations</span>
        </a>
        <ul class="pcoded-submenu">
        
            <li class="{{ (\Request::route()->getName() == 'reparations.index') ? 'active' : '' }}">
                <a href="/reparations">
                    <span class="pcoded-mtext">Liste des réparations</span>
                </a>
            </li>
           
        </ul>
    </li>
    @endif  --}}
</ul>
@endsection
