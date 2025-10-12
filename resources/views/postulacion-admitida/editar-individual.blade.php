@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Fase de pre-selección de postulaciones</h1>
    </div>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('postulacion_admitida') }}"><strong>Pre-selección</strong></a>
        </li>
        <li class="active">Calificar</li>
    </ol>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-center">Calificación postulación</h3>
        </div>
        <div class="table-responsive">
            {{ Form::open(['route' => ['postulacion_admitida.grabar', $postulacion->id_postulacion], 'autocomplete' => 'off', 'id' => 'editar']) }}
            {{ Form::divError() }}
            <table class="table table-bordered table-striped table-hover tabla">
                <thead>
                    <tr>
                        <th>Criterios</th>
                        @foreach($postulacion_admitida->arr_calificacion as $calificacion)
                        <th>
                            <span title="{{ $calificacion->criterio->detalles }}">{{ $calificacion->criterio->descripcion }}</span>
                        </th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>Puntaje máximo</th>
                        @foreach($postulacion_admitida->arr_calificacion as $calificacion)
                        <th>
                            {{ $calificacion->criterio->puntaje_maximo }} pts
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h4>Puntajes</h4>
                        </td>
                        @foreach($postulacion_admitida->arr_calificacion as $calificacion)
                        <td>
                            {{ Form::text('puntaje', $calificacion->puntaje, ['class' => 'form-control input-lg only-digits', 'min' => 0, 'max' => $calificacion->criterio->puntaje_maximo, 'data-key' => $calificacion->id_calificacion]) }}
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td colspan="{{ $postulacion_admitida->arr_calificacion->count() + 1 }}">
                            <button type="submit" class="btn btn-success btn-block btn-lg">Calificar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            {{ Form::close() }}
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
                        {{ Form::label(null, 'Tipo de Entidad', ['class' => 'control-label col-md-3']) }}
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
                    @isset($postulacion->ugel)
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'UGEL', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->ugel->descripcion }}
                                @if($postulacion->ugel->flg_grupo_especial)
                                (Grupo Especial)
                                @endif
                            </p>
                        </div>
                    </div>
                    @endisset
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
            @foreach($postulacion->arr_director as $director)
            <div class="form-horizontal">
                <fieldset>
                    <legend>Datos del Director de la DRE / GRE o UGEL</legend>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'N.° de DNI', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $director->nro_dni }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Nombres', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $director->nombres }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Apellido paterno', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $director->apellido_paterno }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Apellido materno', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $director->apellido_materno }}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Teléfono celular', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $director->telefono_celular }}</p>
                        </div>
                    </div>
                    @if ($director->telefono_fijo)
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Teléfono fijo', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $director->telefono_fijo }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Correo electrónico', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $director->email }}</p>
                        </div>
                    </div>
                </fieldset>
            </div>
            @endforeach
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
                    @if ($postulacion->contacto_postulacion->telefono_fijo)
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Teléfono fijo', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $postulacion->contacto_postulacion->telefono_fijo }}</p>
                        </div>
                    </div>
                    @endif
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
                        <th>N.° de DNI</th>
                        <th>Nombre completo</th>
                        <th>Teléfono</th>
                        <th>Correo electrónico</th>
                        <th>Cargo</th>
                    </thead>
                    <tbody>
                        @foreach($postulacion->arr_equipo_postulacion as $equipo_postulacion)
                        <tr>
                            <td>{{ $equipo_postulacion->nro_dni }}</td>
                            <td>{{ $equipo_postulacion->nombres }} {{ $equipo_postulacion->apellido_paterno }} {{ $equipo_postulacion->apellido_materno }}</td>
                            <td>{{ $equipo_postulacion->telefono }}</td>
                            <td>{{ $equipo_postulacion->email }}</td>
                            <td>{{ $equipo_postulacion->cargo->descripcion }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </fieldset>
            <div class="form-horizontal">
                <fieldset>
                    <legend>Adjuntar documentos</legend>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Declaración del representante', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <a href="{{ route('postulacion_admitida.declaracion_representante', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg" target="_blank">Descargar</a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label(null, 'Declaración del Equipo', ['class' => 'control-label col-md-3']) }}
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <a href="{{ route('postulacion_admitida.declaracion_equipo', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg" target="_blank">Descargar</a>
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
    var data;
    $(function() {
        (function() {
            $("#myTab a:first").tab("show");
        })();
        $("#editar").submit(function(e) {
            e.preventDefault();
            var self = this;
            var calificaciones = [];
            var total = 0;
            $("[name='puntaje']").each(function(index, elem) {
                var puntaje = $.isNumeric($(this).val()) ?
                    $(this).val() :
                    0;
                calificaciones.push({
                    id_calificacion: $(this).data("key"),
                    puntaje: puntaje
                });
                total += parseInt(puntaje);
            });
            bootbox.dialog({
                title: "Calificación postulación",
                message: '<div class="text-center">' +
                    '<h3 class="negrita">Puntaje total: ' + total + '</h3>' +
                    '<h4>¿Está seguro que desea continuar?</h4>' +
                    '</div>',
                buttons: {
                    continuar: {
                        label: 'Continuar',
                        className: 'btn-primary btn-lg',
                        callback: function() {
                            $.ajax({
                                url: $(self).attr("action"),
                                data: {
                                    calificaciones: JSON.stringify(calificaciones)
                                },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {
                                    $.blockUI();
                                },
                                success: function(json) {
                                    if (!json.success) {
                                        $(self).errors(json.errors);
                                    } else {
                                        var mensaje = "La operación se completó con éxito";
                                        var puntaje_total = $("meta[name='total']").attr('content');

                                        if (total >= puntaje_total) mensaje = "<p>La ficha de postulación " + json.data.codigo + " ha sido enviada a la Fase III.</p>";
                                        else mensaje = "<p>La ficha de postulación " + json.data.codigo + " no obtuvo el punto máximo para pasar a la Fase III.</p>";

                                        bootbox.alert({
                                            closeButton: false,
                                            title: "Fase II - Pre Selección",
                                            message: mensaje,
                                            buttons: {
                                                ok: {
                                                    label: "CONTINUAR",
                                                    className: "btn-primary btn-block btn-lg"
                                                }
                                            },
                                            callback: function() {
                                                $.blockUI();
                                                $.redirect("{{ route('postulacion_admitida') }}");
                                            }
                                        });
                                    }
                                    $.unblockUI();
                                },
                                error: function(xhr, status) {
                                    if (xhr.status === 422) {
                                        $(self).errors(xhr.responseJSON.errors);
                                    } else if (xhr.status === 401) {
                                        alert("Su sesión ha expirado.");
                                        location.href = "{{ route('login') }}";
                                    } else {
                                        alert("Se ha producido un error");
                                    }
                                    $.unblockUI();
                                }
                            });
                        }
                    },
                    cancel: {
                        label: 'Cancelar',
                        className: 'btn-default btn-lg'
                    }
                },

            });
        });
    });
</script>
@endsection