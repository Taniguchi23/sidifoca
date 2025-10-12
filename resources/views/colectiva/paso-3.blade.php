@extends('layout')

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title titulo">Concurso de Buenas Prácticas de Gestión Educativa - MODALIDAD COLECTIVA</h3>
        </div>
        <div class="panel-body">
            <div id="rootwizard">
                <ul class="nav nav-pills nav-justified thumbnail">
                    <li class="disabled">
                        <a href="javascript:void(0)">
                            <h4 class="list-group-item-heading">Paso 1</h4>
                            <p class="list-group-item-text">Código de postulación</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('colectiva.editar', $postulacion->id_postulacion) }}">
                            <h4 class="list-group-item-heading">Paso 2</h4>
                            <p class="list-group-item-text">Registro de datos</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0)">
                            <h4 class="list-group-item-heading">Paso 3</h4>
                            <p class="list-group-item-text">Adjuntar y enviar documentos</p>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="text-center">
                            <div class="text-success">
                                <i class="fa fa-check-circle-o fa-5x"></i>
                            </div>
                            <h2>
                                REGISTRO FINALIZADO CORRECTAMENTE
                                <br>
                                <span class="negrita">{{ $postulacion->codigo }}</span>
                            </h2>
                            <h3>Muchas gracias, cualquier consulta o duda escribir a:</h3>
                            <p><i class="fa fa-envelope-o"></i> edutalentos@minedu.gob.pe <i class="fa fa-phone"></i> (511) 615-5818</p>
                            <a href="{{ route('colectiva') }}" class="btn btn-default btn-lg">Ir al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection