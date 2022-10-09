<!DOCTYPE html>
<html lang="fr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title>CNAS | Dashboard </title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <!-- radial chart -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts.css') }}">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iziToast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap/css/bootstrap.min.css') }}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('icon/themify-icons/themify-icons.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('icon/icofont/css/icofont.css') }}">
    <!-- ion icon css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('icon/ion-icon/css/ionicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-animation.min.css') }}">
    {{-- jspdf --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/editor.css') }}">
    <!-- animation nifty modal window effects css -->
    <!-- toolbar css -->

    {{-- {!! Charts::assets() !!} --}}
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('icon/feather/css/feather.css') }}">
    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/advance-elements/css/bootstrap-datetimepicker.css') }}">
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-daterangepicker/css/daterangepicker.css') }}">
    <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datedropper/css/datedropper.min.css') }}">
    <!-- jquery file upload Frame work -->
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/jquery.filer/css/jquery.filer.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/switchery/css/switchery.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/chartist/css/chartist.css') }}" />

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/data-table/extensions/responsive/css/responsive.dataTables.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/data-table/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/demo.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/j-pro/css/j-pro-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/notification/notification.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/sweetalert/css/sweetalert.css') }}">
    <!-- Animate.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/animate.css/css/animate.css') }}">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-tour-standalone.css') }}">


    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/multiselect/css/multi-select.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/component.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/toolbar/jquery.toolbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/toolbar/custom-toolbar.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.mCustomScrollbar.css') }}">

    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: white;
            color: black;
        }

        .ms-container .ms-selectable li.ms-hover,
        .ms-container .ms-selection li.ms-hover {
            background-color: #404e67;
        }

        .unread {

            background-color: #d6e3ff;
        }


        body {
            zoom: 90%
        }

        /* nav{
            zoom : 108%
        } */
    </style>
    @yield('page-styles')



</head>

<body>
    <div id="app">
        <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="ball-scale">
                <div class='contain'>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pre-loader end -->
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">

                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">

                        <div class="navbar-logo" logo-theme="theme1">
                            <a class="mobile-menu" id="mobile-collapse" href="javascript:void(0);">
                                <i class="feather icon-menu"></i>
                            </a>
                            <a href="{{ route('home') }}">
                                <img class="img-fluid" src="{{ asset('images/logo.png') }}" alt="Theme-Logo" />
                            </a>
                            <a class="mobile-options">
                                <i class="feather icon-more-horizontal"></i>
                            </a>
                        </div>

                        <div class="navbar-container container-fluid">
                            <ul class="nav-left">
                                <!--                             <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li> -->
                                <li>
                                    <a href="javascript:void(0)" onclick="javascript:toggleFullScreen()">
                                        <i class="feather icon-maximize full-screen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav-right">
                                <!-- <li class="header-notification v-menu" >
                                    <div class="dropdown-primary dropdown " data-intro="This is Card body" data-step="1">
                                        <div class="dropdown-toggle " data-toggle="dropdown">
                                            <i class="fa fa-spinner faa-spin animated text-warning f-20" v-if="notifications_fetched==false"></i>
                                            <i class="feather icon-bell " v-else></i>
                                            <span style="width: 25px" class="badge bg-danger faa-flash animated" v-if="notifications.length!=0 && notifications_fetched==true" >@{{ notifications.length}}</span>
                                            <span style="width: 25px" class="badge bg-success " v-if="notifications.length==0 && notifications_fetched==true" >@{{ 0}}</span>
                                        </div>
                                        {{-- <ul class=" scroll-list wave show-notification notification-view dropdown-menu " v-show="notifications.length!=0"
                                        data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" >
                                        <div style="height: auto;max-height: 280px; overflow-y:auto ">
                                        <li>
                                            <h6>ALERTES</h6>
                                            <label class="label label-danger">@{{notifications.length.toLocaleString('en-US', {minimumIntegerDigits: 3, useGrouping:false})}} ALERTES</label>
                                        </li>
                                        <li v-on:click="$event.stopPropagation();" v-for="(notification,index) in notifications" style="border:0.5px;border-style:ridge;cursor:default">
                                            <div class="media" v-on:click="" v-if="notification.data.vehicle">
                                                <span class="col-2 d-flex align-self-center img-radius p-l-0 ">
                                                    <i class="icofont icofont-car-alt-1 f-36 social-icon "></i>
                                                </span>
                                                <div class="media-body">
                                                    <h5 class="notification-user">@{{
                                                    notification.data.vehicle.model.brand.name+' - '+
                                                    notification.data.vehicle.model.name+' - '+
                                                    notification.data.vehicle.licence_plate
                                                    }}</h5>
                                                    <p class="notification-msg text-muted ">@{{notification.data.message}}</p>
                                                    <span class="notification-time label label-danger text-white" v-if="notification.data.deadline">@{{notification.data.deadline}}</span>
                                                </div>
                                            </div>
                                            <div class="media " v-on:click="" v-if="notification.data.agent">
                                                <span class="col-2 d-flex align-self-center img-radius p-l-0 ">
                                                    <i class="icofont icofont-waiter f-36 social-icon "></i>
                                                </span>
                                                <div class="media-body">
                                                    <h5 class="notification-user">@{{
                                                    notification.data.agent.firstname + ' ' +notification.data.agent.lastname 
                                                   }}</h5>
                                                    <p class="notification-msg text-muted">@{{notification.data.message}}</p>
                                                    <span class="notification-time label label-danger text-white" v-if="notification.data.deadline">@{{notification.data.deadline}}</span>
                                                </div>
                                            </div>
                                        </li>
                                    </div>
                                        </ul> --}}
                                    </div>
                                </li> -->
                                <li class="user-profile header-notification">
                                    <div class="dropdown-primary dropdown" style="width:auto">
                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                            <img src="{{ asset('images/favicon.ico') }}" class="img-radius" alt="">
                                            <span> {{ Auth::user()->username }}</span>
                                            <i class="feather icon-chevron-down"></i>
                                        </div>
                                        <ul class="show-notification profile-notification dropdown-menu " data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <li>
                                                <a href="user_profile">
                                                    <i class="feather icon-user"></i> Mon profile
                                                </a>
                                            </li>
                                            <!--  <li>
                                            <a href="email-inbox.html">
                                                <i class="feather icon-mail"></i> My Messages
                                            </a>
                                        </li> -->
                                            <!-- <li>
                                            <a href="auth-lock-screen.html">
                                                <i class="feather icon-lock"></i> Fermé la session
                                            </a>
                                        </li> -->
                                            <li>
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                                    <i class="feather icon-log-out"></i> Déconnexion
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>

                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </nav>



                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
                        <nav class="pcoded-navbar">
                            <div class="pcoded-inner-navbar main-menu">


                                @yield('navigation_bar')

                                <div class="pcoded-navigatio-lavel">Déxonnexion</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                            <span class="pcoded-micon"><i class="fa fa-power-off"></i></span>
                                            <span class="pcoded-mtext">Déconnexion</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pcoded-content ">
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">
                                        <!-- Page-header start -->
                                        <div class="page-header" style="margin-top:-17px">
                                            <div class="row align-items-end">
                                                <div class="col-lg-8">
                                                    <div class="page-header-title">
                                                        <div class="d-inline">
                                                            {{-- <h4>Accueil</h4>
                                                            <span>Etat du parc automobile</span> --}}
                                                            @yield('page_title')

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="page-header-breadcrumb">
                                                        <ul class="breadcrumb-title">

                                                            @yield('breadcrumb')
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Page-header end -->

                                        <div class="page-body" style="margin-top:-17px;">

                                            <!-- Page content start -->
                                            {{-- <div class="row"> --}}
                                            @yield('page_content')
                                            {{-- </div> --}}
                                            {{--
                                            <!-- Page content end --> --}}



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="{{ asset('images/browser/chrome.png') }}" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="{{ asset('images/browser/firefox.png') }}" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="{{ asset('images/browser/opera.png') }}" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="{{ asset('images/browser/safari.png') }}" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="{{ asset('images/browser/ie.png') }}" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->

    <script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/axios.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/gpa.js') }}"></script> --}}


    <script type="text/javascript" src="{{ asset('bower_components/jquery/js/jquery.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('bower_components/popper.js/js/popper.min.js') }}"></script>
    <script src="{{ asset('js/multi-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/iziToast.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/bootstrap/js/bootstrap.min.js') }}"></script>



    <!-- notification js -->
    <script type="text/javascript" src="{{ asset('js/bootstrap-growl.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pages/notification/notification.js') }}"></script>
    <!-- Bootstrap date-time-picker js -->
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment-range.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pages/advance-elements/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="{{ asset('bower_components/bootstrap-daterangepicker/js/daterangepicker.js') }}"></script>
    <!-- Date-dropper js -->
    <script type="text/javascript" src="{{ asset('bower_components/datedropper/js/datedropper.min.js') }}"></script>


    <script type="text/javascript" src="{{ asset('js/jquery-cloneya.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('bower_components/modernizr/js/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/modernizr/js/css-scrollbars.js') }}"></script>






    <script type="text/javascript" src="{{ asset('bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>

    <script type="text/javascript" src="{{ asset('bower_components/chart.js/js/Chart.js') }}"></script>

    <script src="{{ asset('pages/widget/amchart/amcharts.js') }}"></script>
    <script src="{{ asset('pages/widget/amchart/serial.js') }}"></script>
    <script src="{{ asset('pages/widget/amchart/light.js') }}"></script>
    <script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/SmoothScroll.js') }}"></script>

    <script type="text/javascript" src="{{ asset('bower_components/switchery/js/switchery.min.js') }}"></script>

    <!-- <script type="text/javascript" src="{{ asset('pages/dashboard/custom-dashboard.js') }}"></script> -->

    <script type="text/javascript" src="{{ asset('pages/widget/excanvas.js') }}"></script>
    <!-- data-table js -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('pages/data-table/js/jszip.min.js') }}"></script>
    <script src="{{ asset('pages/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('pages/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('pages/data-table/extensions/buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('pages/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/animation.js') }}"></script>



    <script type="text/javascript" src="{{ asset('bower_components/sweetalert/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ion.sound.min.js') }}"></script>

    {{-- <script type="text/javascript" src="{{ asset('pages/advance-elements/swithces.js') }}"></script> --}}


    {{-- <script type="text/javascript" src="{{ asset('js/modal.js') }}"></script> --}}

    <!-- jquery slimscroll js -->
    {{-- <script type="text/javascript" src="{{ asset('bower_components/intro.js/js/intro.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap-tour-standalone.js') }}"></script>

    <script type="text/javascript" src="{{ asset('pages/toolbar/jquery.toolbar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/i18next/js/i18next.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/jquery-i18next/js/jquery-i18next.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/select2/js/select2.full.min.js') }}"></script>

    <!-- Multiselect js -->
    <script type="text/javascript" src="{{ asset('bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.quicksearch.js') }}"></script>
    <!-- Custom js -->
    <script type="text/javascript" src="{{ asset('pages/advance-elements/select2-custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pages/task-board/task-board.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('pages/advance-elements/custom-picker.js') }}"></script> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-tour.min.css') }}">
    <script src="{{ asset('js/pcoded.min.js') }}"></script>
    <script src="{{ asset('pages/data-table/extensions/buttons/js/extension-btns-custom.js') }}"></script>
    <script src="{{ asset('pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
    <script src="{{ asset('js/html2canvas.js') }}"></script>
    {{-- jspdf --}}
    <script src="{{ asset('js/cleave.min.js') }}"></script>
    <script src="{{ asset('js/jspdf.debug.js') }}"></script>
    <script src="{{ asset('js/JsBarcode.all.js') }}"></script>
    {{-- <script src="{{ asset('js/wwDigital-normal.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/jspdf.customfonts.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/default_vfs.js') }}"></script> --}}
    <!-- Custom js -->

    <script type="text/javascript" src="{{ asset('js/inputmask.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pages/toolbar/custom-toolbar.js') }}"></script>

    <script src="{{ asset('js/vartical-layout.min.js') }}"></script>
    <script src="{{ asset('js/jquery.blockUI.js') }}"></script>
    {{-- <script src="{{ asset('js/app.min.js') }}"></script> --}}
    <script src="{{ asset('js/block-ui.js') }}"></script>
    <script>
        ion.sound({
            sounds: [{
                    name: "ding_ding",
                },

            ],
            volume: 1,
            path: "sounds/",
            preload: true
        });
    </script>
    @yield('page_scripts')

    {{-- <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    notifications:[],
                }
            },
            mounted() {
            this.fetch_notifications();
            ion.sound({
            sounds: [
                {
                    name: "bell_ring",

                },

            ],
            volume: 1,
            path: "sounds/",
            preload: true
        });
                ion.sound.play("bell_ring");
            },
            methods: {
                fetch_notifications(){
                    var app = this;
                    return axios.get('/getNotifications')
                        .then(function (response) {
                            app.notifications = response.data.notifications;
                            console.log(response.data.notifications);
                        });
                },
            },
        });

        </script> --}}
    <!-- modalEffects js nifty modal window effects -->
    {{-- <script type="text/javascript" src="{{ asset('js/modalEffects.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/classie.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
    <script>
        $(function() {

            // $("[rel='tooltip']").tooltip({'placement': 'right', 'container':'.modal-title'});
            $('body').tooltip({
                selector: '[data-toggle="tooltip"]',
                'placement': 'right',
                'z-index': '30000000'
            });
            $("[rel=tooltip]").tooltip({
                html: true,
                placement: 'top',
                container: '.modal-dialog',
                title: '',
                'z-index': '30000000'
            });
        });
    </script>

</body>


</html>