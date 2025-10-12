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
                    <br>
                    <ul>
                        <li>Estimado postulante, cada tres minutos se autoguarda su Ficha de Postulación.</li>
                        <li>Por favor anote su código de postulación en caso no haya completado con el registro para posteriormente finalizarlo.</li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active">
                        {{ Form::model($postulacion, ['route' => ['colectiva.grabar', $postulacion->id_postulacion], 'autocomplete' => 'off', 'data-encrypt' => '1', 'id' => 'editar']) }}
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
                                    {{ Form::label('id_tipo_postulacion', 'Tipo de Postulación', ['class' => 'control-label col-md-3 asterisk']) }}
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
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <h4>UGEL(es) seleccionados</h4>
                                        <div id="ugeles">
                                            @foreach($arr_postulacion_ugel as $postulacion_ugel)
                                            <span class="badge badge-primary">
                                                {{ $postulacion_ugel->ugel }} <a href="javascript:void(0)" data-key="{{ $postulacion_ugel->id_postulacion_ugel }}" class="btn-trash" title="Eliminar">X</a>
                                            </span>
                                            @endforeach
                                        </div>
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
                        <div class="form-horizontal gobierno">
                            <fieldset>
                                <legend>Datos del Gobierno Local</legend>
                                {{ Form::hidden('id_gobierno_local_postulacion', null) }}
                                {{ Form::hidden('id_contacto_gobierno_local', null) }}
                                <h3>Datos de la municipalidad</h3>
                                <hr>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_id_gobierno_local', 'Gobierno Local', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::select('m_id_gobierno_local', Arr::pluck($arr_gobierno_local, 'descripcion', 'id_gobierno_local'), null, ['placeholder' => '- Seleccione su Gobierno Local -', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_nombre_alcalde', 'Nombre del alcalde', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('m_nombre_alcalde', null, ['placeholder' => 'Nombre del alcalde', 'class' => 'form-control text-uppercase only-letters']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_telefono', 'Teléfono celular', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('m_telefono', null, ['placeholder' => 'Teléfono celular', 'class' => 'form-control', 'data-mask' => '999999999', 'data-placeholder' => '']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_email', 'Correo electrónico', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('m_email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <h3>Persona de contacto</h3>
                                <hr>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('g_nombres', 'Nombre del contacto', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('g_nombres', null, ['placeholder' => 'Nombre del contacto', 'class' => 'form-control text-uppercase only-letters']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('g_telefono_celular', 'Teléfono celular', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('g_telefono_celular', null, ['placeholder' => 'Teléfono celular', 'class' => 'form-control', 'data-mask' => '999999999', 'data-placeholder' => '']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('g_email', 'Correo electrónico', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('g_email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <h3>Documentos de gestión</h3>
                                <hr>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_nro_resolucion_pdlc', 'N° de Resolución PDLC', ['class' => 'control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('m_nro_resolucion_pdlc', null, ['placeholder' => 'N° de Resolución PDLC', 'class' => 'form-control description', 'maxlength' => '255']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_nro_resolucion_pei', 'N° de Resolución PEI', ['class' => 'control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('m_nro_resolucion_pei', null, ['placeholder' => 'N° de Resolución PEI', 'class' => 'form-control description', 'maxlength' => '255']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_nro_resolucion_pel', 'N° de Resolución PEL', ['class' => 'control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('m_nro_resolucion_pel', null, ['placeholder' => 'N° de Resolución PEL', 'class' => 'form-control description', 'maxlength' => '255']) }}
                                    </div>
                                </div>
                                <h3>Unidad orgánica responsable de educación</h3>
                                <hr>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_gerencia_oficina_area', 'Gerencia/Oficina/Área', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('m_gerencia_oficina_area', null, ['placeholder' => 'Gerencia/Oficina/Área', 'class' => 'form-control description', 'maxlength' => '255']) }}
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_funcion_mof', 'Función según MOF', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::text('m_funcion_mof', null, ['placeholder' => 'Función según MOF', 'class' => 'form-control description', 'maxlength' => '255']) }}
                                    </div>
                                </div>
                                <h3>Espacios de coordinación intergubernamental e intersectorial</h3>
                                <hr>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('m_espacios_coordinacion_ig_is', 'Mencione los espacios existentes para la coordinación intergubernamental e intersectorial en su territorio', ['class' => 'asterisk control-label col-md-3']) }}
                                    <div class="col-md-9">
                                        {{ Form::textarea('m_espacios_coordinacion_ig_is', null, ['class' => 'asterisk form-control description', 'cols' => '30', 'rows' => '6', 'maxlength' => '1000']) }}
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
                        <fieldset class="institucion">
                            <legend>Datos del equipo técnico de la práctica</legend>
                            <div class="row">
                                <div class="col-md-9" id="director">
                                    <button type="button" data-url="{{ route('colectiva.agregar_director', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg pop-up">Agregar Director</button>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h4 class="cant-ugel">cant: {{ $arr_postulacion_ugel->count() }}</h4>
                                        {{ Form::hidden('cant_director', 1) }}
                                    </div>
                                </div>
                            </div>
                            <div class="panel-group" id="accordion"></div>
                            <div class="form-group">
                                {{ Form::hidden('cant_equipo', 1) }}
                            </div>
                        </fieldset>
                        <fieldset class="gobierno">
                            <legend>Datos del equipo técnico del Gobierno Local</legend>
                            <div class="row">
                                <div class="col-md-6" id="equipo">
                                    <button type="button" data-url="{{ route('colectiva.agregar_equipo_gobierno_local', $postulacion->id_postulacion) }}" class="btn btn-primary btn-lg pop-up">Agregar Equipo técnico</button>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h4>min: 1</h4>
                                        {{ Form::hidden('min_gobierno', 2) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h4>max: 2</h4>
                                        {{ Form::hidden('max_gobierno', 2) }}
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
    <button type="button" data-url="{{ route('colectiva.eliminar_equipo_gobierno_local', $postulacion->id_postulacion) }}" data-key="@id" class="btn btn-danger trash" title="Eliminar"><i class="fa fa-trash-o"></i></button>
</script>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    var grid;
    var accordion;
    $(function() {
        (function() {
            $("#myTab a:first").tab("show");
            $(".gobierno").hide();
            var tipo = $("#id_tipo_postulacion").val();
            if (tipo) {
                switch (TipoPostulacionEnum.properties[tipo].value) {
                    case TipoPostulacionEnum.DRE_GRE_UGELES:
                        break;
                    case TipoPostulacionEnum.UGELES:
                        break;
                    case TipoPostulacionEnum.UGELES_GOBIERNO_LOCAL:
                        $(".gobierno").show();
                        break;
                }
            }
            if ($("#ugeles").find(".badge").length == 0) {
                $(".institucion").hide();
            }
            setInterval(autosave, 60000);
        })();
        $("#id_tipo_postulacion").change(function(e) {
            $(".gobierno").hide("slow");
            var tipo = $(this).val();
            if (tipo) {
                switch (TipoPostulacionEnum.properties[tipo].value) {
                    case TipoPostulacionEnum.DRE_GRE_UGELES:
                        break;
                    case TipoPostulacionEnum.UGELES:
                        break;
                    case TipoPostulacionEnum.UGELES_GOBIERNO_LOCAL:
                        $(".gobierno").show("slow");
                        break;
                }
            }
        });
        $("#id_dre_gre").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('colectiva.ctrl_dre_gre', $postulacion->id_postulacion) }}",
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
                        $("#m_id_gobierno_local").items({
                            placeholder: "- Seleccione su Gobierno Local -",
                            text: "descripcion",
                            value: "id_gobierno_local",
                            data: json.arr_gobierno_local
                        });
                        $("#id_distrito").items("- Seleccione su Distrito -");
                        $("#ugeles").html("");
                        $("#provincias").html("");
                        $("#distritos").html("");
                        $(".institucion").hide("slow", function name(params) {
                            $("#accordion").html("");
                            $(".cant-ugel").html("cant: 0");
                        });
                        $.unblockUI();
                    }
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#id_ugel").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('colectiva.agregar_ugel', $postulacion->id_postulacion) }}",
                data: {
                    id_ugel: $(self).val()
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
                        $("#ugeles").html("");
                        $.each(json.arr_postulacion_ugel, function(index, value) {
                            $("#ugeles").append('<span class="badge badge-primary">' + value.ugel + ' <a href="javascript:void(0)" data-key="' + value.id_postulacion_ugel + '" class="btn-trash" title="Eliminar">X</a></span>');
                            if (index == (json.arr_postulacion_ugel.length - 1)) {
                                $("#id_ugel").val("");
                            }
                        });
                        $(".cant-ugel").html("cant: " + json.arr_postulacion_ugel.length);
                        $(".institucion").show("slow");
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#ugeles").on("click", ".btn-trash", function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: "{{ route('colectiva.eliminar_ugel', $postulacion->id_postulacion) }}",
                data: {
                    id_postulacion_ugel: $(self).data("key")
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
                        $("#ugeles").html("");
                        $.each(json.arr_postulacion_ugel, function(index, value) {
                            $("#ugeles").append('<span class="badge badge-primary">' + value.ugel + ' <a href="javascript:void(0)" data-key="' + value.id_postulacion_ugel + '" class="btn-trash" title="Eliminar">X</a></span>');
                            if (index == (json.arr_postulacion_ugel.length - 1)) {
                                $("#id_ugel").val("");
                            }
                        });
                        if (json.arr_postulacion_ugel.length == 0) {
                            $(".institucion").hide("slow", function() {
                                $(".cant-ugel").html("cant: 0");
                            });
                        } else {
                            $(".cant-ugel").html("cant: " + json.arr_postulacion_ugel.length);
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
        $("#id_provincia").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('colectiva.agregar_provincia', $postulacion->id_postulacion) }}",
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
                url: "{{ route('colectiva.eliminar_provincia', $postulacion->id_postulacion) }}",
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
                url: "{{ route('colectiva.agregar_distrito', $postulacion->id_postulacion) }}",
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
                url: "{{ route('colectiva.eliminar_distrito', $postulacion->id_postulacion) }}",
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
                url: "{{ route('colectiva.listar_tema') }}",
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
                url: "{{ route('colectiva.editar_respuesta', $postulacion->id_postulacion) }}",
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
        accordion = $("#accordion").accordion({
            url: "{{ route('colectiva.listar_director', $postulacion->id_postulacion) }}"
        });
        accordion.on("click", ".trash", function(e) {
            e.preventDefault();
            var self = this;
            if (confirm('Eliminar este registro')) {
                $.ajax({
                    url: "{{ route('colectiva.eliminar_director', $postulacion->id_postulacion) }}",
                    data: {
                        id_director: $(self).data("key")
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
                            $("#accordion").accordion({
                                url: "{{ route('colectiva.listar_director', $postulacion->id_postulacion) }}"
                            });
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
        accordion.on("click", ".add", function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: "{{ route('colectiva.agregar_equipo_postulacion', $postulacion->id_postulacion) }}",
                data: {
                    id_director: $(self).data("key")
                },
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(html) {
                    $("#contenedor").html(html);
                    $("#contenedor").modal("show");
                    $.unblockUI();
                },
                error: function() {
                    alert("Se ha producido un error.");
                    $.unblockUI();
                }
            });
        });
        accordion.on("click", ".btn-trash", function(e) {
            e.preventDefault();
            var self = this;
            if (confirm('Eliminar este registro')) {
                $.ajax({
                    url: "{{ route('colectiva.eliminar_equipo_postulacion', $postulacion->id_postulacion) }}",
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
                            $("#accordion").accordion({
                                url: "{{ route('colectiva.listar_director', $postulacion->id_postulacion) }}"
                            });
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
        grid = $("#grid").grid({
            primaryKey: "id_equipo_gobierno_local",
            dataSource: "{{ route('colectiva.listar_equipo_gobierno_local', $postulacion->id_postulacion) }}",
            uiLibrary: "bootstrap",
            locale: "es-es",
            mapping: {
                dataField: "data"
            },
            columns: [{
                    field: "id_equipo_gobierno_local",
                    hidden: true
                },
                {
                    field: "nro_dni",
                    title: "N.° de DNI"
                },
                {
                    field: "id_equipo_gobierno_local",
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
                    field: "id_equipo_gobierno_local",
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
            if (records.length < 2) {
                $("#equipo>button").attr("disabled", false)
            } else {
                $("#equipo>button").attr("disabled", true);
            }
            $("#equipo>span").text(records.length + ' / 2');
        });
        grid.on("click", ".trash", function(e) {
            e.preventDefault();
            var self = this;
            if (confirm('Eliminar este registro')) {
                $.ajax({
                    url: $(self).data("url"),
                    data: {
                        id_equipo_gobierno_local: $(self).data("key")
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
                    url: "{{ route('colectiva.reniec') }}",
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
                            $(".captcha").captcha("{{ route('colectiva.captcha') }}");
                        });
                        $.unblockUI();
                    } else {
                        $.redirect("{{ route('colectiva.editar', $postulacion->id_postulacion) }}");
                    }
                },
                error: function(xhr, status) {
                    if (xhr.status === 422) {
                        $(self).errors(xhr.responseJSON.errors, function(divError) {
                            $("#captcha").val("");
                            $(".captcha").captcha("{{ route('colectiva.captcha') }}");
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
            url: "{{ route('colectiva.autosave', $postulacion->id_postulacion) }}",
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