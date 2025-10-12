<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="nonce" content="{{ request()->nonce }}">
    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="pubkey" content="{{ config('site_vars.pem') }}" />
    <meta name="privkey" content="{{ config('site_vars.private') }}" />
    <meta name="total" content="{{ config('site_vars.puntaje_total') }}" />
    <meta name="lifetime" content="{{ config('site_vars.lifetime') }}" />
    <meta name="refresh" content="1" />
    
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <title>Edutalentos Regiones - Plataforma virtual orientada a fortalecer capacidades</title>

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/gijgo/css/gijgo.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/eonasdan-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/extra.css') }}">

    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/block-ui/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('vendor/bootbox/bootbox.min.js') }}"></script>
    <script src="{{ asset('vendor/gijgo/js/gijgo.min.js') }}"></script>
    <script src="{{ asset('vendor/gijgo/js/messages/messages.es-es.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/min/locales.min.js') }}"></script>
    <script src="{{ asset('vendor/eonasdan-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.fileDownload/jquery.fileDownload.js') }}"></script>
    <script src="{{ asset('vendor/javascript-rsa/jsencrypt.min.js') }}"></script>
    <script src="{{ asset('js/lib.js') }}"></script>
    <script src="{{ asset('js/general.js') }}"></script>
    <script src="{{ asset('js/enums.js') }}"></script>
    <script src="{{ asset('js/idle.js') }}"></script>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="cabecera">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="http://aula.edutalentos.pe/index.php"><img src="{{ asset('images/header-logo-custom1.png') }}" alt=""></a>
                </div>
                <div class="col-md-6 derecha visible-md visible-lg">
                    <a href="http://aula.edutalentos.pe/index.php"><img src="{{ asset('images/ministerio-de-peru.jpg') }}" alt=""></a>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar navbar-default navbar-static-top menubar">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('home') }}">Ir al inicio</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('login') }}">Intranet</a></li>
                </ul>
            </div>
        </div>
    </div>

    @yield('content')

    <div id="contenedor" class="modal fade"></div>
    <div id="toast"></div>
    
    <div class="pie-pagina">
        <div class="container">
            <p><i class="fa fa-envelope-o"></i> edutalentos@minedu.gob.pe <i class="fa fa-phone"></i> (511) 615-5818</p>
            <p>Copyright &copy; {{ now()->year }} Edutalentos.pe. Todos los derechos reservados - Ministerio de Educación</p>
        </div>
    </div>
    
    @yield('scripts')
</body>

</html>