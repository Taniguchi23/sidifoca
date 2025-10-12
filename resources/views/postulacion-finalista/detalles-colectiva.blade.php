@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Fase de selección de finalistas</h1>
    </div>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('postulacion_finalista') }}"><strong>Finalistas</strong></a>
        </li>
        <li class="active">Detalles</li>
    </ol>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-center">Calificación postulación</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover tabla">
                <thead>
                    <tr>
                        <th>Criterios</th>
                        @foreach($postulacion_admitida->arr_calificacion as $calificacion)
                        <th class="text-center">
                            <span title="{{ $calificacion->criterio->detalles }}">{{ $calificacion->criterio->descripcion }}</span>
                        </th>
                        @endforeach
                        <th class="text-center">Puntaje total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Puntajes</td>
                        @foreach($postulacion_admitida->arr_calificacion as $calificacion)
                        <td class="text-center">{{ $calificacion->puntaje }}</td>
                        @endforeach
                        <td class="text-center">{{ $postulacion_admitida->puntaje_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-center">Concurso de Buenas Prácticas de Gestión Educativa - {{ $postulacion->modalidad->descripcion }}</h3>
        </div>
        <div class="panel-body">
            <h2 class="text-center">Código de la postulación: <strong>{{ $postulacion->codigo }}</strong></h2>
            <div class="form-horizontal">
                <fieldset>
                    <legend>Institución que postula</legend>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Tipo de Postulación', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->tipo_postulacion->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'DRE / GRE', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->dre_gre->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'UGEL', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                @foreach($postulacion->arr_postulacion_ugel as $postulacion_ugel)
                                <span class="badge badge-primary">
                                    {{ $postulacion_ugel->ugel->descripcion }}
                                    @if($postulacion_ugel->ugel->flg_grupo_especial)
                                    (Grupo Especial)
                                    @endif
                                </span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="form-horizontal">
                <fieldset>
                    <legend>Zona de Alcance de la Buena Práctica</legend>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Provincia', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                @foreach($postulacion->arr_postulacion_provincia as $postulacion_provincia)
                                <span class="badge badge-primary">
                                    {{ $postulacion_provincia->provincia->descripcion }}
                                </span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Distrito', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                @foreach($postulacion->arr_postulacion_distrito as $postulacion_distrito)
                                <span class="badge badge-primary">
                                    {{ $postulacion_distrito->distrito->descripcion }}
                                </span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="form-horizontal">
                <fieldset>
                    <legend>Datos de la postulación</legend>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Nombre de la Buena Práctica', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->buena_practica }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Categoría de postulación', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->categoria->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Tema', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->tema->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Tiempo de implementación de la Buena Práctica', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->nro_meses }} meses - {{ $postulacion->nro_dias }} días</p>
                        </div>
                    </div>
                </fieldset>
            </div>
            <fieldset>
                <legend>Descripción de la Buena Práctica</legend>
                <ul class="nav nav-tabs" id="myTab">
                    @foreach($postulacion->arr_dimension as $dimension)
                    <li><a href="#tab-{{ $dimension->id_dimension }}" data-toggle="tab">{{ $dimension->descripcion }}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($postulacion->arr_dimension as $dimension)
                    <div class="tab-pane" id="tab-{{ $dimension->id_dimension }}">
                        @foreach($postulacion->arr_respuesta as $respuesta)
                        @if($respuesta->id_dimension == $dimension->id_dimension)
                        <h4>{{ $respuesta->pregunta->descripcion }}</h4>
                        <div class="form-control-static">
                            {{ $respuesta->descripcion }}
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </fieldset>
            @if($postulacion->id_tipo_postulacion == config('constants.tipo_postulacion.ugeles_gobierno_local'))
            <div class="form-horizontal">
                <fieldset>
                    <legend>Datos del Gobierno Local</legend>
                    <h3>Datos de la municipalidad</h3>
                    <hr>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Gobierno Local', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->gobierno_local->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Nombre del alcalde', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->nombre_alcalde }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Teléfono celular', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->telefono }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Correo electrónico', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->email }}</p>
                        </div>
                    </div>
                    <h3>Persona de contacto</h3>
                    <hr>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Nombre del contacto', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_gobierno_local->nombres }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Teléfono celular', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_gobierno_local->telefono_celular }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Correo electrónico', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_gobierno_local->email }}</p>
                        </div>
                    </div>
                    <h3>Documentos de gestión</h3>
                    <hr>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'N° de Resolución PDLC', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->nro_resolucion_pdlc }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'N° de Resolución PEI', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->nro_resolucion_pei }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'N° de Resolución PEL', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->nro_resolucion_pel }}</p>
                        </div>
                    </div>
                    <h3>Unidad orgánica responsable de educación</h3>
                    <hr>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Gerencia/Oficina/Área', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->gerencia_oficina_area }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Función según MOF', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->gobierno_local_postulacion->funcion_mof }}</p>
                        </div>
                    </div>
                    <h3>Espacios de coordinación intergubernamental e intersectorial</h3>
                    <hr>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Mencione los espacios existentes para la coordinación intergubernamental e intersectorial en su territorio', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <div class="form-control-static">
                                {{ $postulacion->gobierno_local_postulacion->espacios_coordinacion_ig_is }}
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            @endif
            <div class="form-horizontal">
                <fieldset>
                    <legend>Datos de la persona de contacto de la Buena Práctica</legend>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'N.° de DNI', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_postulacion->nro_dni }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Nombres', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_postulacion->nombres }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Apellido paterno', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_postulacion->apellido_paterno }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Apellido materno', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_postulacion->apellido_materno }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Teléfono celular', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_postulacion->telefono_celular }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Teléfono fijo', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_postulacion->telefono_fijo }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Correo electrónico', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_postulacion->email }}</p>
                        </div>
                    </div>
                </fieldset>
            </div>
            <fieldset>
                <legend>Datos del equipo técnico</legend>
                <table class="table table-bordered table-hover tabla">
                    <thead>
                        <th>DRE / GRE</th>
                        <th>UGEL</th>
                        <th>Director</th>
                        <th>Participantes</th>
                    </thead>
                    <tbody>
                        @foreach($postulacion->arr_director as $director)
                        <tr>
                            <td>{{ $director->dre_gre->descripcion }}</td>
                            <td>{{ $director->ugel->descripcion }}</td>
                            <td>
                                {{ $director->nombres }} {{ $director->apellido_paterno }} {{ $director->apellido_materno }}
                                <br>
                                DNI: {{ $director->nro_dni }}
                            </td>
                            <td>
                                <ul>
                                    @foreach($postulacion->arr_equipo_postulacion as $equipo_postulacion)
                                    @if($equipo_postulacion->id_dre_gre == $director->id_dre_gre && $equipo_postulacion->id_ugel == $director->id_ugel)
                                    <li>
                                        {{ $equipo_postulacion->nombres }} {{ $equipo_postulacion->apellido_paterno }} {{ $equipo_postulacion->apellido_materno }}
                                        <br>
                                        DNI: {{ $equipo_postulacion->nro_dni }}
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </fieldset>
            @if($postulacion->id_tipo_postulacion == config('constants.tipo_postulacion.ugeles_gobierno_local'))
            <fieldset>
                <legend>Datos del equipo técnico del Gobierno Local</legend>
                <table class="table table-bordered table-hover tabla">
                    <thead>
                        <th>N.° de DNI</th>
                        <th>Nombre completo</th>
                        <th>Teléfono</th>
                        <th>Correo electrónico</th>
                        <th>Cargo</th>
                    </thead>
                    <tbody>
                        @foreach($postulacion->arr_equipo_gobierno_local as $equipo_gobierno_local)
                        <tr>
                            <td>{{ $equipo_gobierno_local->nro_dni }}</td>
                            <td>{{ $equipo_gobierno_local->nombres }}</td>
                            <td>{{ $equipo_gobierno_local->telefono }}</td>
                            <td>{{ $equipo_gobierno_local->email }}</td>
                            <td>{{ $equipo_gobierno_local->cargo->descripcion }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </fieldset>
            @endif
            <div class="form-horizontal">
                <fieldset>
                    <legend>Adjuntar documentos</legend>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Declaración del representante', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <a href="{{ route('postulacion_finalista.declaracion_representante', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg" target="_blank">Descargar</a>
                            </p>
                        </div>
                    </div>
                    @empty ($postulacion->gobierno_local_postulacion)
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Declaración del Equipo', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <a href="{{ route('postulacion_finalista.declaracion_equipo', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg" target="_blank">Descargar</a>
                            </p>
                        </div>
                    </div>
                    @else
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Declaración del Equipo y Declaración del Equipo de Gobierno Local', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <a href="{{ route('postulacion_finalista.declaracion_equipo', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg" target="_blank">Descargar</a>
                            </p>
                        </div>
                    </div>
                    @endempty
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Acta Modalidad Colectiva', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <a href="{{ route('postulacion_finalista.acta_modalidad_colectiva', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg" target="_blank">Descargar</a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Documentos y/o imagenes', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <a href="{{ $postulacion->url_documento_imagen }}" target="_blank">{{ $postulacion->url_documento_imagen }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'URL del video', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <a href="{{ $postulacion->url_video }}" target="_blank">{{ $postulacion->url_video }}</a>
                            </p>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    $(function() {
        $("#myTab a:first").tab("show");
    });
</script>
@endsection