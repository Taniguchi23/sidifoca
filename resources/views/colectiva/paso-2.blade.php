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
                    <li class="active">
                        <a href="javascript:void(0)">
                            <h4 class="list-group-item-heading">Paso 2</h4>
                            <p class="list-group-item-text">Registro de datos</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('colectiva.adjuntar', $postulacion->id_postulacion) }}">
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
                                FICHA DE POSTULACIÓN COMPLETADA
                                <br>
                                <span class="negrita">{{ $postulacion->codigo }}</span>
                            </h2>
                            <h3>Los datos han sido registrados correctamente.</h3>
                            <p>Descargue los documentos generados del representante y del equipo técnico.</p>
                            <p>Una vez llenados y firmados correctamente proceda con el siguiente paso.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <a href="{{ route('colectiva.representante_postulacion', [$postulacion->id_postulacion, $token]) }}" target="_blank" class="btn btn-primary btn-block btn-lg">Descargue la declaración del representante</a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <a href="{{ route('colectiva.equipo_tecnico_postulacion', [$postulacion->id_postulacion, $token]) }}"  target="_blank" class="btn btn-primary btn-block btn-lg">Descargue la declaración del equipo técnico</a>
                                    </p>
                                </div>
                            </div>
                            @empty ($postulacion->m_id_gobierno_local)
                            <p>
                                <a href="{{ route('bpg_acta_acuerdos_colectiva', $token) }}" target="_blank" class="btn btn-primary btn-lg">Descargue Modelo de Acta de Acuerdos Colectiva</a>
                            </p>
                            @else
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <a href="{{ route('colectiva.equipo_gobierno_postulacion', [$postulacion->id_postulacion, $token]) }}" target="_blank" class="btn btn-primary btn-block btn-lg">Descargue la declaración del equipo gobierno</a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                    <a href="{{ route('bpg_acta_acuerdos_colectiva', $token) }}" target="_blank" class="btn btn-primary btn-block btn-lg">Descargue Modelo de Acta de Acuerdos Colectiva</a>
                                    </p>
                                </div>
                            </div>
                            @endempty
                            <a href="{{ route('colectiva.adjuntar', $postulacion->id_postulacion) }}" class="btn btn-default btn-lg">Paso 3: Envío de Informe de postulación y Documentos de evidencia</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection