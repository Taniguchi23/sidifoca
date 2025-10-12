<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <title>@yield('title') - Plataforma virtual orientada a fortalecer capacidades</title>

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

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
                    <a href="{{ route('home') }}"><img src="{{ asset('images/header-logo-custom1.png') }}" alt=""></a>
                </div>
                <div class="col-md-6 derecha visible-md visible-lg">
                    <a href="{{ route('home') }}"><img src="{{ asset('images/ministerio-de-peru.jpg') }}" alt=""></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="jumbotron text-center">
            <h1>@yield('code') | @yield('message')</h1>
            <p>Contactese con el administrador</p>
            <p><i class="fa fa-envelope-o"></i> edutalentos@minedu.gob.pe <i class="fa fa-phone"></i> (511) 615-5818</p>
            <p><a class="btn btn-primary btn-lg" href="{{ route('home') }}" role="button">Ir al inicio</a></p>
        </div>
    </div>
    
</body>

</html>