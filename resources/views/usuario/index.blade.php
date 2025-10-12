@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Gestión de Administrados</h1>
    </div>
    <div class="botonera">
        @show ('crear_usuario')
        <a href="{{ route('usuario.crear') }}" class="btn btn-primary btn-lg">Nuevo registro</a>
        @endshow
        @show ('exportar_usuario')
        <a href="{{ route('usuario.exportar') }}" class="btn btn-success btn-lg pull-right" target="_blank">Exportar</a>
        @endshow
    </div>
    {{ Form::open(['route' => 'usuario', 'autocomplete' => 'off', 'id' => 'busqueda']) }}
    {{ Form::hidden('page', 1) }}
    <fieldset class="custom">
        <legend>Búsqueda</legend>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label(null, 'Nombre Completo') }}
                            {{ Form::text('nombre_completo', null, ['placeholder' => 'Nombre Completo', 'class' => 'form-control only-letters', 'maxlength' => '255']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label(null, 'Estado') }}
                            <div class="radio">
                                <label class="radio-inline">
                                    {{ Form::radio('flg_estado', 1, true) }} Activo
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('flg_estado', 0, false) }}Inactivo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label(null, 'Tipo de Documento') }}
                            {{ Form::select('id_tipo_documento', Arr::pluck($arr_tipo_documento, 'descripcion', 'id_tipo_documento'), null, ['placeholder' => '- Seleccione su Tipo de Documento -', 'class' => 'form-control', 'id' => 'b_id_tipo_documento']) }}
                        </div>
                    </div>
                    <div class="col-md-6" id="g_nro_documento" style="display: none;">
                        <div class="form-group form-group-lg">
                            {{ Form::label(null, 'N.° de Documento') }}
                            {{ Form::text('nro_documento', null, ['placeholder' => 'N.° de Documento', 'class' => 'form-control', 'id' => 'b_nro_documento']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg margen">Filtrar</button>
                <a href="{{ route('usuario') }}" class="btn btn-default btn-lg margen" title="Refrescar"><i class="fa fa-refresh"></i></a>
            </div>
        </div>
    </fieldset>
    {{ Form::close() }}
    <div class="table-responsive">
        <table class="tabla" id="grid"></table>
    </div>
</div>
<script type="text/template" id="template">
    @show ('editar_usuario')
    <a href="{{ route('usuario') }}/editar/@id" class="btn btn-primary" title="Editar"><i class="fa fa-edit"></i></a>
    @endshow
    @show ('editar_privilegios')
    <button type="button" data-url="{{ route('usuario') }}/privilegios/@id" class="btn btn-info pop-up" title="Privilegios"><i class="fa fa-lock"></i></button>
    @endshow
    <a href="{{ route('usuario') }}/detalles/@id" class="btn btn-default" title="Detalles"><i class="fa fa-eye"></i></a>
</script>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    var grid;
    $(function() {
        $("#b_id_tipo_documento").change(function(e) {
            $("#g_nro_documento").hide();
            $("#b_nro_documento").val("");
            var tipo = $(this).val();
            if (tipo) {
                $("#g_nro_documento").show();
                var mask = "";
                switch (TipoDocEnum.properties[tipo].value) {
                    case TipoDocEnum.DNI:
                        mask = "99999999";
                        break;
                    case TipoDocEnum.CARNET_EXT:
                        mask = "wwwwwwww?wwww";
                        break;
                }
                var inputmask = $("#b_nro_documento").data("bs.inputmask");
                if (inputmask) {
                    inputmask.mask = mask;
                    inputmask.init();
                    inputmask.checkVal();
                } else {
                    $("#b_nro_documento").inputmask({
                        mask: mask,
                        placeholder: ""
                    });
                }
            }
        });
        grid = $("#grid").grid({
            primaryKey: "id_usuario",
            dataSource: {
                url: $("#busqueda").attr("action"),
                data: $("#busqueda").inputs(),
                beforeSend: function() {
                    $.blockUI();
                },
                complete: function (){
                    $.unblockUI();
                },
                error: function (xhr) {
                    if (xhr.status == 401) {
                        alert("Su sesión ha expirado.");
                        location.href = "{{ route('login') }}";
                    }
                }
            },
            uiLibrary: "bootstrap",
            locale: "es-es",
            mapping: {
                dataField: "data"
            },
            columns: [{
                    field: "id_usuario",
                    hidden: true
                },
                {
                    title: "Nombre Completo",
                    renderer: function(value, record) {
                        return decrypt(record.nombres) + " " + decrypt(record.apellido_paterno) + " " + decrypt(record.apellido_materno);
                    }
                },
                {
                    field: "id_genero",
                    title: "Género",
                    renderer: function(value, record) {
                        return $.exec(record.genero, function(ref) {
                            return ref.descripcion;
                        });
                    }
                },
                {
                    field: "id_tipo_documento",
                    title: "Tipo de Documento",
                    renderer: function(value, record) {
                        return $.exec(record.tipo_documento, function(ref) {
                            return ref.descripcion;
                        });
                    }
                },
                {
                    field: "nro_documento",
                    title: "N.° de Documento",
                    renderer: function(value, record) {
                        return decrypt(value);
                    }
                },
                {
                    field: "flg_estado",
                    title: "Activo",
                    width: 80,
                    type: "checkbox",
                    align: "center"
                },
                {
                    field: "id_usuario",
                    title: "Acción",
                    width: 200,
                    align: "center",
                    renderer: function(value, record) {
                        return $("#template").template({
                            id: value
                        });
                    }
                }
            ],
            pager: {
                limit: 5
            }
        });
        $("#busqueda").submit(function(e) {
            e.preventDefault();
            grid.reload($(this).inputs());
        });
    });
</script>
@endsection