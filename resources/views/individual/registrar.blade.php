@extends('layout')

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title titulo">Concurso de Buenas Prácticas de Gestión Educativa - MODALIDAD INDIVIDUAL</h3>
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
                    <li class="disabled">
                        <a href="javascript:void(0)">
                            <h4 class="list-group-item-heading">Paso 3</h4>
                            <p class="list-group-item-text">Adjuntar y enviar documentos</p>
                        </a>
                    </li>
                </ul>
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>NOTA IMPORTANTE:</strong>
                    <ul>
                        <li>Estimado postulante, cada tres minutos se autoguarda su Ficha de Postulación.</li>
                        <li>Por favor anote su código de postulación en caso no haya completado con el registro para posteriormente finalizarlo.</li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active">
                        {{ Form::model($postulacion, ['route' => ['individual.grabar', $postulacion->id_postulacion], 'data-encrypt' => '1', 'autocomplete' => 'off', 'id' => 'editar']) }}
                        {{ Form::divError() }}
                        <h2 class="text-center">
                            Código de la postulación: <strong>{{ $postulacion->codigo }}</strong>
                            <br>
                            <small id="time">Borrador guardado a las {{ date("h:i:s A") }}.</small>
                        </h2>
                        <div class="form-horizontal">
                            <fieldset>
                                <legend>Institución que postula</legend>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('id_tipo_postulacion', 'Tipo de Entidad', ['class' => 'control-label col-md-3 asterisk']) }}
                                    <div class="col-md-9">
                                        {{ Form::select('id_tipo_postulacion', Arr::pluck($arr_tipo_postulacion, 'descripcion', 'id_tipo_postulacion'), null, ['placeholder' => '- Seleccione su Tipo Postulación -', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('id_dre_gre', 'DRE / GRE', ['class' => 'control-label col-md-3 asterisk']) }}
                                    <div class="col-md-9">
                                        {{ Form::select('id_dre_gre', Arr::pluck($arr_dre_gre, 'descripcion', 'id_dre_gre'), null, ['placeholder' => '- Seleccione su DRE / GRE -', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('id_ugel', 'UGEL', ['class' => 'control-label col-md-3 asterisk']) }}
                                    <div class="col-md-9">
                                        {{ Form::select('id_ugel', Arr::pluck($arr_ugel, 'descripcion', 'id_ugel'), null, ['placeholder' => '- Seleccione su UGEL -', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="form-horizontal">
                            <fieldset>
                                <legend>Zona de Alcance de la Buena Práctica</legend>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('id_provincia', 'Provincia', ['class' => 'control-label col-md-3 asterisk']) }}
                                    <div class="col-md-9">
                                        {{ Form::select('id_provincia', Arr::pluck($arr_provincia, 'descripcion', 'id_provincia'), null, ['placeholder' => '- Seleccione su Provincia -', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <h4>Provincias seleccionados</h4>
                                        <div id="provincias">
                                            @foreach($arr_postulacion_provincia as $postulacion_provincia)
                                            <span class="badge badge-primary">
                                                {{ $postulacion_provincia->provincia }} <a href="javascript:void(0)" data-key="{{ $postulacion_provincia->id_postulacion_provincia }}" class="btn-trash" title="Eliminar">X</a>
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('id_distrito', 'Distrito', ['class' => 'control-label col-md-3 asterisk']) }}
                                    <div class="col-md-9">
                                        {{ Form::select('id_distrito', Arr::pluck($arr_distrito, 'descripcion', 'id_distrito'), null, ['placeholder' => '- Seleccione su Distrito -', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <h4>Distritos seleccionados</h4>
                                        <div id="distritos">
                                            @foreach($arr_postulacion_distrito as $postulacion_distrito)
                                            <span class="badge badge-primary">
                                                {{ $postulacion_distrito->distrito }} <a href="javascript:void(0)" data-key="{{ $postulacion_distrito->id_postulacion_distrito }}" class="btn-trash" title="Eliminar">X</a>
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <fieldset>
                            <legend>Datos de la postulación</legend>
                            <div class="form-group form-group-lg">
                                {{ Form::label('buena_practica', 'Nombre de la Buena Práctica', ['class' => 'asterisk']) }}
                                {{ Form::text('buena_practica', null, ['placeholder' => 'Nombre de la Buena Práctica', 'class' => 'form-control description', 'maxlength' => '255']) }}
                            </div>
                            <div class="form-group form-group-lg">
                                {{ Form::label('id_categoria', 'Categoría de postulación', ['class' => 'asterisk']) }}
                                {{ Form::select('id_categoria', Arr::pluck($arr_categoria, 'descripcion', 'id_categoria'), null, ['placeholder' => '- Seleccione su Categoría -', 'class' => 'form-control']) }}
                            </div>
                            <div class="form-group form-group-lg">
                                {{ Form::label('id_tema', 'Tema', ['class' => 'asterisk']) }}
                                {{ Form::select('id_tema', Arr::pluck($arr_tema, 'descripcion', 'id_tema'), null, ['placeholder' => '- Seleccione su Tema -', 'class' => 'form-control']) }}
                            </div>
                            {{ Form::label(null, 'Tiempo de implementación de la Buena Práctica', ['class' => 'asterisk']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-lg">
                                        {{ Form::select('nro_meses', Arr::pluck($arr_mes, 'descripcion', 'id_mes'), null, ['placeholder' => '- Meses -', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-lg">
                                        {{ Form::select('nro_dias', Arr::pluck($arr_dia, 'descripcion', 'id_dia'), null, ['placeholder' => '- Días -', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
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
                                    <div class="form-group form-group-lg">
                                        <h4>{{ $respuesta->pregunta }} <span class="text-danger">(*)</span></h4>
                                        {{ Form::textarea('id_respuesta[]', $respuesta->descripcion, ['class' => 'form-control textbox-lines description', 'cols' => '30', 'rows' => '6', 'maxlength' => '1000', 'data-key' => $respuesta->id_respuesta]) }}
                                        <span>{{ empty($respuesta->descripcion) ? 0 : strlen($respuesta->descripcion) }} / 1000</span>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </fieldset>
                        <div class="form-horizontal">
                            <fieldset>
                                <legend>Datos del Director de la DRE / GRE o UGEL</legend>
                                {{ Form::hidden('id_director', null) }}
                                <div class="form-group form-group-lg">
                                    {{ Form::label('d_nro_dni', 'N.° de DNI', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        <div class="input-group input-group-lg">
                                            {{ Form::text('d_nro_dni', null, ['placeholder' => 'N.° de DNI', 'class' => 'form-control', 'data-mask' => '99999999', 'data-placeholder' => '', 'readonly' => isset($postulacion->d_nro_dni)]) }}
                                            <span class="input-group-btn">
                                                @empty($postulacion->d_nro_dni)
                                                <button type="button" class="btn btn-primary reniec" data-dni="d_nro_dni" data-state="0" title="Consultar DNI"><i class="fa fa-search"></i> Reniec</button>
                                                @else
                                                <button type="button" class="btn btn-primary reniec" data-dni="d_nro_dni" data-state="1" title="Consultar DNI"><i class="fa fa-refresh"></i> Reiniciar</button>
                                                @endempty
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('d_nombres', 'Nombres', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('d_nombres', null, ['placeholder' => 'Nombres', 'class' => 'form-control text-uppercase only-letters', 'readonly' => 'readonly']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('d_apellido_paterno', 'Apellido paterno', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('d_apellido_paterno', null, ['placeholder' => 'Apellido paterno', 'class' => 'form-control text-uppercase only-letters', 'readonly' => 'readonly']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('d_apellido_materno', 'Apellido materno', ['class' => 'control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('d_apellido_materno', null, ['placeholder' => 'Apellido materno', 'class' => 'form-control text-uppercase only-letters', 'readonly' => 'readonly']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('d_telefono_celular', 'Teléfono celular', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('d_telefono_celular', null, ['placeholder' => 'Teléfono celular', 'class' => 'form-control', 'data-mask' => '999999999', 'data-placeholder' => '']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('d_telefono_fijo', 'Teléfono fijo', ['class' => 'control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('d_telefono_fijo', null, ['placeholder' => 'Teléfono fijo', 'class' => 'form-control', 'data-mask' => '999999?9999', 'data-placeholder' => '']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('d_email', 'Correo electrónico', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('d_email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="form-horizontal">
                            <fieldset>
                                <legend>Datos de la persona de contacto de la Buena Práctica</legend>
                                {{ Form::hidden('id_contacto_postulacion', null) }}
                                <div class="form-group form-group-lg">
                                    {{ Form::label('c_nro_dni', 'N.° de DNI', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        <div class="input-group input-group-lg">
                                            {{ Form::text('c_nro_dni', null, ['placeholder' => 'N.° de DNI', 'class' => 'form-control', 'data-mask' => '99999999', 'data-placeholder' => '', 'readonly' => isset($postulacion->c_nro_dni)]) }}
                                            <span class="input-group-btn">
                                                @empty($postulacion->c_nro_dni)
                                                <button type="button" class="btn btn-primary reniec" data-dni="c_nro_dni" data-state="0" title="Consultar DNI"><i class="fa fa-search"></i> Reniec</button>
                                                @else
                                                <button type="button" class="btn btn-primary reniec" data-dni="c_nro_dni" data-state="1" title="Consultar DNI"><i class="fa fa-refresh"></i> Reiniciar</button>
                                                @endempty
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('c_nombres', 'Nombres', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('c_nombres', null, ['placeholder' => 'Nombres', 'class' => 'form-control text-uppercase only-letters', 'readonly' => 'readonly']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('c_apellido_paterno', 'Apellido paterno', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('c_apellido_paterno', null, ['placeholder' => 'Apellido paterno', 'class' => 'form-control text-uppercase only-letters', 'readonly' => 'readonly']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('c_apellido_materno', 'Apellido materno', ['class' => 'control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('c_apellido_materno', null, ['placeholder' => 'Apellido materno', 'class' => 'form-control text-uppercase only-letters', 'readonly' => 'readonly']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('c_telefono_celular', 'Teléfono celular', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('c_telefono_celular', null, ['placeholder' => 'Teléfono celular', 'class' => 'form-control', 'data-mask' => '999999999', 'data-placeholder' => '']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('c_telefono_fijo', 'Teléfono fijo', ['class' => 'control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('c_telefono_fijo', null, ['placeholder' => 'Teléfono fijo', 'class' => 'form-control', 'data-mask' => '999999?9999', 'data-placeholder' => '']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('c_email', 'Correo electrónico', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('c_email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <fieldset>
                            <legend>Datos del equipo técnico</legend>
                            <div class="row">
                                <div class="col-md-6" id="equipo">
                                    <button type="button" data-url="{{ route('individual.agregar_equipo_postulacion', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg pop-up">Agregar Equipo técnico</button>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h4>min: 2</h4>
                                        {{ Form::hidden('min_equipo', 2) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h4>max: 4</h4>
                                        {{ Form::hidden('max_equipo', 4) }}
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="tabla" id="grid"></table>
                            </div>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-group-lg">
                                    <img src="{{ Captcha::src('flat') }}" class="img-thumbnail captcha" alt="">
                                    {{ Form::label('captcha', 'Ingrese el código de la imagen', ['class' => 'asterisk']) }}
                                    {{ Form::text('captcha', null, ['placeholder' => 'Captcha', 'class' => 'form-control text-lowercase alpha-num', 'maxlength' => '255']) }}
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">GUARDAR Y DESCARGAR DOCUMENTO DE POSTULACIÓN</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/template" id="template">
    <button type="button" data-url="{{ route('individual.eliminar_equipo_postulacion', $postulacion->id_postulacion) }}" data-key="@id" class="btn btn-danger trash" title="Eliminar"><i class="fa fa-trash-o"></i></button>
</script>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    var grid;
    $(function() {
        (function() {
            $("#id_ugel").closest(".form-group").hide();
            $("#id_dre_gre").closest(".form-group").hide();
            $("#equipo>button").attr("disabled", true);
            var tipo = $("#id_tipo_postulacion").val();
            if (tipo) {
                switch (TipoPostulacionEnum.properties[tipo].value) {
                    case TipoPostulacionEnum.UGEL:
                        $("#id_dre_gre").closest(".form-group").show();
                        $("#id_ugel").closest(".form-group").show();
                        break;
                    case TipoPostulacionEnum.DRE_GRE:
                        $("#id_dre_gre").closest(".form-group").show();
                        break;
                }
                $("#equipo>button").attr("disabled", false);
            }
            $("#myTab a:first").tab("show");
            setInterval(autosave, 60000);
        })();
        $("#id_tipo_postulacion").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('individual.ctrl_tipo_postulacion', $postulacion->id_postulacion) }}",
                data: {
                    id_tipo_postulacion: $(self).val()
                },
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        alert("Se ha producido un error");
                    } else {
                        $("#id_dre_gre").closest(".form-group").hide("slow", function() {
                            $("#id_dre_gre").val("");
                            $("#id_provincia").items("- Seleccione su Provincia -");
                            $("#provincias").html("");
                            $("#id_distrito").items("- Seleccione su Distrito -");
                            $("#distritos").html("");
                        });
                        $("#id_ugel").closest(".form-group").hide("slow", function() {
                            $("#id_ugel").items("- Seleccione su UGEL -");
                        });
                        $("#equipo>button").attr("disabled", true);
                        var tipo = $(self).val();
                        if (tipo) {
                            switch (TipoPostulacionEnum.properties[tipo].value) {
                                case TipoPostulacionEnum.UGEL:
                                    $("#id_dre_gre").closest(".form-group").show("slow", function() {
                                        $("#id_ugel").closest(".form-group").show("slow");
                                    });
                                    break;
                                case TipoPostulacionEnum.DRE_GRE:
                                    $("#id_dre_gre").closest(".form-group").show("slow");
                                    break;
                            }
                            $("#equipo>button").attr("disabled", false);
                        }
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#id_dre_gre").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('individual.ctrl_dre_gre', $postulacion->id_postulacion) }}",
                data: {
                    id_dre_gre: $(self).val()
                },
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        alert("Se ha producido un error");
                    } else {
                        $("#id_ugel").items({
                            placeholder: "- Seleccione su UGEL -",
                            text: "descripcion",
                            value: "id_ugel",
                            data: json.arr_ugel
                        });
                        $("#id_provincia").items({
                            placeholder: "- Seleccione su Provincia -",
                            text: "descripcion",
                            value: "id_provincia",
                            data: json.arr_provincia
                        });
                        $("#id_distrito").items("- Seleccione su Distrito -");
                        $("#provincias").html("");
                        $("#distritos").html("");
                        $.unblockUI();
                    }
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#id_provincia").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('individual.agregar_provincia', $postulacion->id_postulacion) }}",
                data: {
                    id_provincia: $(self).val()
                },
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        alert("Se ha producido un error");
                    } else {
                        $("#provincias").html("");
                        $.each(json.arr_postulacion_provincia, function(index, value) {
                            $("#provincias").append('<span class="badge badge-primary">' + value.provincia + ' <a href="javascript:void(0)" data-key="' + value.id_postulacion_provincia + '" class="btn-trash" title="Eliminar">X</a></span>');
                            if (index == (json.arr_postulacion_provincia.length - 1)) {
                                $("#id_provincia").val("");
                            }
                        });
                        $("#id_distrito").items({
                            placeholder: "- Seleccione su Distrito -",
                            text: "descripcion",
                            value: "id_distrito",
                            data: json.arr_distrito
                        });
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#provincias").on("click", ".btn-trash", function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: "{{ route('individual.eliminar_provincia', $postulacion->id_postulacion) }}",
                data: {
                    id_postulacion_provincia: $(self).data("key")
                },
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        alert("Se ha producido un error");
                    } else {
                        $(self).parent().remove();
                        $("#id_distrito").items({
                            placeholder: "- Seleccione su Distrito -",
                            text: "descripcion",
                            value: "id_distrito",
                            data: json.arr_distrito
                        });
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#id_distrito").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('individual.agregar_distrito', $postulacion->id_postulacion) }}",
                data: {
                    id_distrito: $(self).val()
                },
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        alert("Se ha producido un error");
                    } else {
                        $("#distritos").html("");
                        $.each(json.arr_postulacion_distrito, function(index, value) {
                            $("#distritos").append('<span class="badge badge-primary">' + value.distrito + ' <a href="javascript:void(0)" data-key="' + value.id_postulacion_distrito + '" class="btn-trash" title="Eliminar">X</a></span>');
                            if (index == (json.arr_postulacion_distrito.length - 1)) {
                                $("#id_distrito").val("");
                            }
                        });
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#distritos").on("click", ".btn-trash", function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: "{{ route('individual.eliminar_distrito', $postulacion->id_postulacion) }}",
                data: {
                    id_postulacion_distrito: $(self).data("key")
                },
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        alert("Se ha producido un error");
                    } else {
                        $(self).parent().remove();
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#id_categoria").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('individual.listar_tema') }}",
                data: {
                    id_categoria: $(self).val()
                },
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    $("#id_tema").items({
                        placeholder: "- Seleccione su Tema -",
                        text: "descripcion",
                        value: "id_tema",
                        data: json
                    });
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $(".textbox-lines").keyup(function(e) {
            e.preventDefault();
            var text = $(this).val().length + " / 1000";
            $(this).next("span").html(text);
        });
        $("[name='id_respuesta[]']").blur(function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: "{{ route('individual.editar_respuesta', $postulacion->id_postulacion) }}",
                data: {
                    id_respuesta: $(self).data("key"),
                    descripcion: $(self).val()
                },
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    //$.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        alert("Se ha producido un error");
                    }
                    //$.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    //$.unblockUI();
                }
            });
        });
        grid = $("#grid").grid({
            primaryKey: "id_equipo_postulacion",
            dataSource: "{{ route('individual.listar_equipo_postulacion', $postulacion->id_postulacion) }}",
            uiLibrary: "bootstrap",
            locale: "es-es",
            mapping: {
                dataField: "data"
            },
            columns: [{
                    field: "id_equipo_postulacion",
                    hidden: true
                },
                {
                    field: "nro_dni",
                    title: "N.° de DNI"
                },
                {
                    field: "id_equipo_postulacion",
                    title: "Nombre completo",
                    renderer: function(value, record) {
                        return record.nombres + ' ' + record.apellido_paterno + ' ' + (record.apellido_materno ? record.apellido_materno : "");
                    }
                },
                {
                    field: "telefono",
                    title: "Teléfono"
                },
                {
                    field: "email",
                    title: "Correo electrónico"
                },
                {
                    field: "id_cargo",
                    title: "Cargo",
                    renderer: function(value, record) {
                        return $.exec(record.cargo, function(ref) {
                            return ref.descripcion;
                        });
                    }
                },
                {
                    field: "id_equipo_postulacion",
                    title: "Acción",
                    width: 180,
                    align: "center",
                    renderer: function(value, record) {
                        return $("#template").template({
                            id: value
                        });
                    }
                }
            ]
        });
        grid.on("dataBound", function(e, records, totalRecords) {
            if (records.length < 4) {
                $("#equipo>button").attr("disabled", false)
            } else {
                $("#equipo>button").attr("disabled", true);
            }
        });
        grid.on("click", ".trash", function(e) {
            e.preventDefault();
            var self = this;
            if (confirm('Eliminar este registro')) {
                $.ajax({
                    url: $(self).data("url"),
                    data: {
                        id_equipo_postulacion: $(self).data("key")
                    },
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $.blockUI();
                    },
                    success: function(json) {
                        if (!json.success) {
                            alert("Se ha producido un error");
                        } else {
                            grid.reload();
                        }
                        $.unblockUI();
                    },
                    error: function() {
                        alert("Se ha producido un error.");
                        $.unblockUI();
                    }
                });
            }
        });
        $("body").on("click", ".reniec", function(e) {
            var self = this;
            var split = $(self).data("dni").split("_")[0];
            var state = $(self).data("state");
            var data = {
                "nro_dni": "",
                "apellido_paterno": "",
                "apellido_materno": "",
                "nombres": "",
                "telefono_fijo": "",
                "telefono_celular": "",
                "telefono": "",
                "email": ""
            };
            if (state) {
                $(self).html('<i class="fa fa-search"></i> Reniec');
                $(self).data("state", 0);
                $.each(data, function(key, value) {
                    $("#" + split + "_" + key).val(value);
                    if (key == "nro_dni") {
                        $("#" + split + "_" + key).attr("readonly", false);
                    }
                });
            } else {
                var dniVal = $("#" + split + "_nro_dni").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('individual.reniec') }}",
                    data: {
                        nro_dni: encrypt($("#" + split + "_nro_dni").val())
                    },
                    beforeSend: function() {
                        $.blockUI();
                    },
                    success: function(json) {
                        if (!json.success) {
                            var msg = json.errors.nro_dni[0];
                            $(self).html('<i class="fa fa-search"></i> Reniec');
                            $(self).data("state", 0);
                            $.each(data, function(key, value) {
                                //console.log("#" + split + "_" + key);
                                $("#" + split + "_" + key).val(value);
                                if (key == "nro_dni") {
                                    $("#" + split + "_" + key).attr("readonly", false);
                                }
                                if (json.status == "1") {
                                    // servidor caido, habilitamos edicion
                                    $("#" + split + "_" + key).attr("readonly", false);
                                }
                            });
                            $("#" + split + "_nro_dni").val(dniVal);
                            alert(msg);
                        } else {
                            $(self).html('<i class="fa fa-refresh"></i> Reiniciar');
                            $(self).data("state", 1);
                            $.each(json.data, function(key, value) {
                                $("#" + split + "_" + key).val(decrypt(value));
                                $("#" + split + "_" + key).closest(".form-group").removeClass("has-error");
                                $("#" + split + "_" + key).closest(".form-group").find(".help-block").remove();
                                /*if (key == "nro_dni") {
                                    $("#" + split + "_" + key).attr("readonly", true);
                                }*/
                                $("#" + split + "_" + key).attr("readonly", true);
                            });
                            $("#" + split + "_nro_dni").attr("readonly", true);
                            $("#toast").toast(json.msg);
                        }
                        $.unblockUI();
                    },
                    error: function(xhr, status) {
                        if (xhr.status === 422) {
                            var msg = xhr.responseJSON.errors.nro_dni[0];
                            $.each(data, function(key, value) {
                                $("#" + split + "_" + key).val(value);
                                if (key == "nro_dni") {
                                    $("#" + split + "_" + key).attr("readonly", false);
                                }
                            });
                            alert(msg);
                        } else {
                            alert("Se ha producido un error");
                        }
                        $.unblockUI();
                    }
                });
            }
        });
        $("#editar").submit(function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: $(self).attr("action"),
                data: $(self).encrypt(),
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        $(self).errors(json.errors, function(divError) {
                            $("#captcha").val("");
                            $(".captcha").captcha("{{ route('individual.captcha') }}");
                        });
                        $.unblockUI();
                    } else {
                        $.redirect("{{ route('individual.editar', $postulacion->id_postulacion) }}");
                    }
                },
                error: function(xhr, status) {
                    if (xhr.status === 422) {
                        $(self).errors(xhr.responseJSON.errors, function(divError) {
                            $("#captcha").val("");
                            $(".captcha").captcha("{{ route('individual.captcha') }}");
                        });
                    } else {
                        alert("Se ha producido un error");
                    }
                    $.unblockUI();
                }
            });
        });
    });

    function autosave() {
        $.ajax({
            url: "{{ route('individual.autosave', $postulacion->id_postulacion) }}",
            data: $("#editar").encrypt(),
            type: "POST",
            dataType: "json",
            success: function(json) {
                if (!json.success) {
                    //$("#toast").toast("Se ha producido un error.");
                } else {
                    $("#time").text("Borrador guardado a las " + json.data);
                    $("#toast").toast("Se autoguardó su postulación");
                }
            },
            error: function(xhr, status) {
                alert("Se ha producido un error.");
            }
        });
    }
</script>
@endsection