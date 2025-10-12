@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Editar registro</h1>
    </div>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('usuario') }}"><strong>Gestión de Administrados</strong></a>
        </li>
        <li class="active">Editar registro</li>
    </ol>
    <div id="rootwizard">
        <ul class="nav nav-pills nav-justified thumbnail">
            <li>
                <a href="{{ route('usuario.editar', $contrato->usuario->id_usuario) }}">
                    <h4 class="list-group-item-heading">Paso 1</h4>
                    <p class="list-group-item-text">Datos personales</p>
                </a>
            </li>
            <li class="active">
                <a href="javascript:void(0)">
                    <h4 class="list-group-item-heading">Paso 2</h4>
                    <p class="list-group-item-text">Datos institucionales</p>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                {{ Form::model($contrato,['route' => ['usuario.grabar_contrato', $contrato->id_contrato], 'files' => 'true', 'autocomplete' => 'off', 'id' => 'editar']) }}
                {{ Form::divError() }}
                <p class="text-right">
                    <button type="button" class="btn btn-danger btn-lg trash"><i class="fa fa-trash-o"></i> Añadir un nuevo contrato</button>
                </p>
                <fieldset class="redondeado">
                    <legend>Datos institucionales</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-lg required">
                                {{ Form::label('null', 'Nombre Completo') }}
                                <p class="form-control-static">
                                    {{ $contrato->usuario->nombres }} {{ $contrato->usuario->apellido_paterno }} {{ $contrato->usuario->apellido_materno }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-lg required">
                                {{ Form::label('id_tipo_entidad', 'Tipo de entidad') }}
                                {{ Form::select('id_tipo_entidad', Arr::pluck($arr_tipo_entidad, 'descripcion', 'id_tipo_entidad'), null, ['placeholder' => '- Seleccione su Tipo de Entidad -', 'class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @empty($contrato->id_dre_gre)
                            <div class="form-group form-group-lg required" style="display: none;">
                                {{ Form::label('id_dre_gre', 'DRE / GRE') }}
                                {{ Form::select('id_dre_gre', Arr::pluck($arr_dre_gre, 'descripcion', 'id_dre_gre'), null, ['placeholder' => '- Seleccione su DRE / GRE -', 'class' => 'form-control']) }}
                            </div>
                            @endempty
                            @isset($contrato->id_dre_gre)
                            <div class="form-group form-group-lg required">
                                {{ Form::label('id_dre_gre', 'DRE / GRE') }}
                                {{ Form::select('id_dre_gre', Arr::pluck($arr_dre_gre, 'descripcion', 'id_dre_gre'), null, ['placeholder' => '- Seleccione su DRE / GRE -', 'class' => 'form-control']) }}
                            </div>
                            @endisset
                        </div>
                        <div class="col-md-6">
                            @empty($contrato->id_ugel)
                            <div class="form-group form-group-lg required" style="display: none;">
                                {{ Form::label('id_ugel', 'UGEL') }}
                                {{ Form::select('id_ugel', [], null, ['placeholder' => '- Seleccione su UGEL -', 'class' => 'form-control']) }}
                            </div>
                            @endempty
                            @isset($contrato->id_ugel)
                            <div class="form-group form-group-lg required">
                                {{ Form::label('id_ugel', 'UGEL') }}
                                {{ Form::select('id_ugel', Arr::pluck($arr_ugel, 'descripcion', 'id_ugel'), null, ['placeholder' => '- Seleccione su UGEL -', 'class' => 'form-control']) }}
                            </div>
                            @endisset
                        </div>
                        <div class="col-md-6">
                            @empty($contrato->id_entidad_externa)
                            <div class="form-group form-group-lg required" style="display: none;">
                                {{ Form::label('id_entidad_externa', 'Entidad Externa') }}
                                {{ Form::select('id_entidad_externa', Arr::pluck($arr_entidad_externa, 'descripcion', 'id_entidad_externa'), null, ['placeholder' => '- Seleccione su Entidad Externa -', 'class' => 'form-control']) }}
                            </div>
                            @else
                            <div class="form-group form-group-lg required">
                                {{ Form::label('id_entidad_externa', 'Entidad Externa') }}
                                {{ Form::select('id_entidad_externa', Arr::pluck($arr_entidad_externa, 'descripcion', 'id_entidad_externa'), null, ['placeholder' => '- Seleccione su Entidad Externa -', 'class' => 'form-control']) }}
                            </div>
                            @endempty
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            @empty($contrato->id_area)
                            <div class="form-group form-group-lg required" style="display: none;">
                                {{ Form::label('id_area', 'Área en la que labora') }}
                                {{ Form::select('id_area', Arr::pluck($arr_area, 'descripcion', 'id_area'), null, ['placeholder' => '- Seleccione su Área -', 'class' => 'form-control']) }}
                            </div>
                            @else
                            <div class="form-group form-group-lg required">
                                {{ Form::label('id_area', 'Área en la que labora') }}
                                {{ Form::select('id_area', Arr::pluck($arr_area, 'descripcion', 'id_area'), null, ['placeholder' => '- Seleccione su Área -', 'class' => 'form-control']) }}
                            </div>
                            @endempty
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-lg required">
                                {{ Form::label('id_nivel_puesto', 'Nivel del puesto') }}
                                {{ Form::select('id_nivel_puesto', Arr::pluck($arr_nivel_puesto, 'descripcion', 'id_nivel_puesto'), null, ['placeholder' => '- Seleccione su Nivel del puesto -', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-lg required">
                                {{ Form::label('id_puesto', 'Nombre del puesto') }}
                                {{ Form::select('id_puesto', Arr::pluck($arr_puesto, 'descripcion', 'id_puesto'), null, ['placeholder' => '- Seleccione su Nombre del Puesto -', 'class' => 'form-control']) }}
                            </div>
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('flg_ejerce_cargo', 1) }} ¿Ejerce actualmente el cargo?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-lg required">
                                {{ Form::label('id_regimen_laboral', 'Régimen laboral') }}
                                {{ Form::select('id_regimen_laboral', Arr::pluck($arr_regimen_laboral, 'descripcion', 'id_regimen_laboral'), null, ['placeholder' => '- Seleccione su Régimen laboral -', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-lg">
                                {{ Form::label('url_documento', 'Contrato/Resolución/Orden de Servicio') }}
                                @isset($contrato->url_documento)
                                <a href="{{ route('usuario.contrato', $contrato->id_contrato) }}" target="_blank">[ <i class="fa fa-download"></i> Descargar ]</a>
                                @endisset
                                {{ Form::fileinput('url_documento', ['accept' => 'application/pdf']) }}
                                <span class="text-primary">Documento formato PDF | Peso máx. 2MB</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-lg">
                                {{ Form::label('fecha_inicio', 'Fecha de inicio del contrato') }}
                                <div class="input-group date" id="g_fecha_inicio">
                                    {{ Form::text('fecha_inicio', null, ['placeholder' => 'Fecha de inicio del contrato', 'class' => 'form-control']) }}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-lg">
                                {{ Form::label('fecha_fin', 'Fecha de fin del contrato') }}
                                <div class="input-group date" id="g_fecha_fin">
                                    {{ Form::text('fecha_fin', null, ['placeholder' => 'Fecha de fin del contrato', 'class' => 'form-control']) }}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-lg {{ $errors->has('id_nivel_educativo') ? 'has-error' : '' }}">
                                {{ Form::label('id_nivel_educativo', 'Último nivel educativo alcanzado') }}
                                {{ Form::select('id_nivel_educativo', Arr::pluck($arr_nivel_educativo, 'descripcion', 'id_nivel_educativo'), null, ['placeholder' => 'Último nivel educativo alcanzado', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-lg {{ $errors->has('id_profesion') ? 'has-error' : '' }}">
                                {{ Form::label('id_profesion', 'Profesión') }}
                                {{ Form::select('id_profesion', Arr::pluck($arr_profesion, 'descripcion', 'id_profesion'), null, ['placeholder' => 'Seleccione su Profesión', 'class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Guardar</button>
                </fieldset>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    $(function() {
        $(".trash").click(function(e) {
            e.preventDefault;
            bootbox.confirm({
                title: 'Añadir un nuevo contrato',
                message: '¿Deseas reemplazar este registro?',
                buttons: {
                    confirm: {
                        label: 'Aceptar',
                        className: 'btn-danger btn-lg'
                    },
                    cancel: {
                        label: 'Cancelar',
                        className: 'btn-default btn-lg'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $.redirect("{{ route('usuario.crear_contrato', $contrato->id_usuario) }}");
                    }
                }
            });
        });
        $("#id_tipo_entidad").change(function(e) {
            $("#id_dre_gre").val("");
            $("#id_ugel").val("");
            $("#id_entidad_externa").val("");
            $("#id_nivel_puesto").val("");
            $("#id_area").val("");
            $("#id_dre_gre").trigger("change");
            $("#id_nivel_puesto").trigger("change");
            $("#id_dre_gre").closest(".form-group").hide();
            $("#id_ugel").closest(".form-group").hide();
            $("#id_entidad_externa").closest(".form-group").hide();
            $("#id_area").closest(".form-group").hide();
            var tipo = $(this).val();
            if (tipo) {
                switch (TipoEntidadEnum.properties[tipo].value) {
                    case TipoEntidadEnum.DRE_GRE:
                        $("#id_dre_gre").closest(".form-group").show("slow");
                        $("#id_area").closest(".form-group").show("slow");
                        break;
                    case TipoEntidadEnum.UGEL:
                        $("#id_dre_gre").closest(".form-group").show("slow");
                        $("#id_ugel").closest(".form-group").show("slow");
                        $("#id_area").closest(".form-group").show("slow");
                        break;
                    case TipoEntidadEnum.EXTERNA:
                        $("#id_entidad_externa").closest(".form-group").show("slow");
                        break;
                }
            }
        });
        $("#id_dre_gre").change(function(e) {
            var entidad = $("#id_tipo_entidad").val();
            if (entidad == TipoEntidadEnum.UGEL) {
                $.ajax({
                    url: "{{ route('usuario.listar_ugel') }}",
                    data: {
                        id_dre_gre: $(this).val()
                    },
                    beforeSend: function() {
                        $.blockUI();
                    },
                    success: function(data) {
                        $("#id_ugel").items({
                            placeholder: "- Seleccione su UGEL -",
                            text: "descripcion",
                            value: "id_ugel",
                            data: data
                        });
                        $.unblockUI();
                    },
                    error: function() {
                        alert("Se ha producido un error");
                        $.unblockUI();
                    }
                });
            } else {
                $("#id_ugel").items({
                    placeholder: "- Seleccione su UGEL -",
                    text: "descripcion",
                    value: "id_ugel",
                    data: []
                });
            }
        });
        $("#id_nivel_puesto").change(function(e) {
            $.ajax({
                url: "{{ route('usuario.listar_puesto') }}",
                data: {
                    id_tipo_entidad: $("#id_tipo_entidad").val(),
                    id_nivel_puesto: $(this).val()
                },
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(data) {
                    $("#id_puesto").items({
                        placeholder: "- Seleccione su Nombre del Puesto -",
                        text: "descripcion",
                        value: "id_puesto",
                        data: data
                    });
                    $.unblockUI();
                },
                error: function() {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
        $("#g_fecha_inicio").datetimepicker({
            locale: "es",
            format: 'DD/MM/YYYY'
        });
        $("#g_fecha_fin").datetimepicker({
            locale: "es",
            format: 'DD/MM/YYYY'
        });
        $("#editar").submit(function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: $(self).attr("action"),
                data: new FormData(self),
                type: "POST",
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        $(self).errors(json.errors, function(divError) {
                            $.unblockUI();
                        });
                    } else {
                        $.redirect("{{ route('usuario.detalles', $contrato->usuario->id_usuario) }}");
                    }
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
        });
    });
</script>
@endsection