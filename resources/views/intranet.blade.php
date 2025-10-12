<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Syndash - Bootstrap4 Admin Template</title>
    <!--favicon-->
    <link rel="icon" href="/assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="/assets/css/pace.min.css" rel="stylesheet" />
    <script src="/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Roboto&display=swap" />
    <!-- Icons CSS -->
    <link rel="stylesheet" href="/assets/css/icons.css" />
    <!-- App CSS -->
    <link rel="stylesheet" href="/assets/css/app.css" />
    <link rel="stylesheet" href="/assets/css/dark-sidebar.css" />
    <link rel="stylesheet" href="/assets/css/dark-theme.css" />
</head>

<body>
<!-- wrapper -->
<div class="wrapper">
    <!--sidebar-wrapper-->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div class="">
                <img src="{{ asset('images/header-logo-custom1.png') }}" class="logo-icon-2" alt="" />
            </div>
{{--            <div>--}}
{{--                <h4 class="logo-text">Syndash</h4>--}}
{{--            </div>--}}
            <a href="javascript:;" class="toggle-btn ms-auto"> <i class="bx bx-menu"></i>
            </a>
        </div>
        <!--navigation-->
        @include('menu')
        <!--end navigation-->
    </div>
    <!--end sidebar-wrapper-->
    <!--header-->
    <header class="top-header">
        <nav class="navbar navbar-expand">
            <div class="left-topbar d-flex align-items-center">
                <a href="javascript:;" class="toggle-btn">	<i class="bx bx-menu"></i>
                </a>
            </div>
            <div class="flex-grow-1 search-bar">
            </div>
            <div class="right-topbar ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item search-btn-mobile">
                        <a class="nav-link position-relative" href="javascript:;">	<i class="bx bx-search vertical-align-middle"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown dropdown-lg">

                    </li>
                    <li class="nav-item dropdown dropdown-lg">
                    </li>
                    <li class="nav-item dropdown dropdown-user-profile">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                            <div class="d-flex user-box align-items-center">
                                <div class="user-info">
                                    <p class="user-name mb-0">{{Auth::user()->nombres}} {{Auth::user()->apellido_paterno}}</p>
                                    <p class="designattion mb-0">{{Auth::user()->username}}</p>
                                </div>
                                <img src="{{Auth::user()->url_fotografia}}" class="user-img" alt="">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-user"></i><span>Profile</span></a>
                            <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-cog"></i><span>Settings</span></a>
                            <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-tachometer"></i><span>Dashboard</span></a>
                            <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-wallet"></i><span>Earnings</span></a>
                            <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-cloud-download"></i><span>Downloads</span></a>
                            <div class="dropdown-divider mb-0"></div>	<a class="dropdown-item" href="{{ route('intranet.cerrar_sesion') }}"><i
                                    class="bx bx-power-off"></i><span>Logout</span></a>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!--end header-->
    <!--page-wrapper-->
    <div class="page-wrapper">
        <!--page-content-wrapper-->
        <div class="page-content-wrapper">
            <div class="page-content">

{{--                @php--}}
{{--                    dd(Session::get('arr_menu', collect()))--}}
{{--                @endphp--}}

                @yield('content')
            </div>
        </div>
        <!--end page-content-wrapper-->
    </div>
    <!--end page-wrapper-->
    <!--start overlay-->
    <div class="overlay toggle-btn-mobile"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    <!--footer -->
    <div class="footer">
        <p class="mb-0">
            <a href="#">SIDIFOCA</a>
        </p>
    </div>
    <!-- end footer -->
</div>
<!-- end wrapper -->
<!--start switcher-->
<!--end switcher-->
<!-- JavaScript -->
<!-- Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<!--plugins-->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!-- App JS -->
<script src="/assets/js/app.js"></script>
</body>

</html>















{{--<!doctype html>--}}
{{--<html lang="es">--}}

{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    --}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    <meta name="nonce" content="{{ request()->nonce }}">--}}
{{--    <meta name="base-url" content="{{ url('/') }}" />--}}
{{--    <meta name="pubkey" content="{{ config('site_vars.pem') }}" />--}}
{{--    <meta name="privkey" content="{{ config('site_vars.private') }}" />--}}
{{--    <meta name="total" content="{{ config('site_vars.puntaje_total') }}" />--}}
{{--    <meta name="lifetime" content="{{ config('site_vars.lifetime') }}" />--}}
{{--    <meta name="refresh" content="0" />--}}

{{--    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">--}}
{{--    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">--}}

{{--    <title>Edutalentos Regiones - Plataforma virtual orientada a fortalecer capacidades</title>--}}

{{--    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('vendor/metismenu/metisMenu.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('vendor/gijgo/css/gijgo.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('vendor/eonasdan-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('css/intranet.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('css/extra.css') }}">--}}

{{--    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/metismenu/metisMenu.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/block-ui/jquery.blockUI.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/bootbox/bootbox.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/gijgo/js/gijgo.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/gijgo/js/messages/messages.es-es.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/moment/min/moment.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/moment/min/locales.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/eonasdan-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/jquery.fileDownload/jquery.fileDownload.js') }}"></script>--}}
{{--    <script src="{{ asset('vendor/javascript-rsa/jsencrypt.min.js') }}"></script>--}}
{{--    <script src="{{ asset('js/lib.js') }}"></script>--}}
{{--    <script src="{{ asset('js/general.js') }}"></script>--}}
{{--    <script src="{{ asset('js/enums.js') }}"></script>--}}
{{--    <script src="{{ asset('js/idle.js') }}"></script>--}}
{{--    --}}
{{--    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->--}}
{{--    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->--}}
{{--    <!--[if lt IE 9]>--}}
{{--      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>--}}
{{--      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
{{--    <![endif]-->--}}
{{--</head>--}}

{{--<body>--}}
{{--    @include('menu')--}}

{{--    <div class="navbar navbar-inverse navbar-fixed-top hidden-md hidden-lg">--}}
{{--        <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".navmenu">--}}
{{--            <span class="icon-bar"></span>--}}
{{--            <span class="icon-bar"></span>--}}
{{--            <span class="icon-bar"></span>--}}
{{--        </button>--}}
{{--        <a class="navbar-brand" href="#">Intranet</a>--}}
{{--    </div>--}}

{{--    @yield('content')--}}

{{--    <div id="contenedor" class="modal fade"></div>--}}
{{--    <div id="toast"></div>--}}
{{--    --}}
{{--    @yield('scripts')--}}
{{--</body>--}}

{{--</html>--}}
