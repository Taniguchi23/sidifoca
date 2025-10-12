@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Cargos</h1>
    </div>
    <div class="botonera">
        @show ('crear_cargo')
        <button type="button" class="btn btn-primary btn-lg pop-up" data-url="{{ route('cargo.crear') }}">Nuevo registro</button>
        @endshow
    </div>
    {{ Form::open(['route' => 'cargo', 'autocomplete' => 'off', 'id' => 'busqueda']) }}
    {{ Form::hidden('page', 1) }}
    <fieldset class="custom">
        <legend>Búsqueda</legend>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label(null, 'Tipo de Entidad') }}
                            {{ Form::select('id_tipo_entidad', Arr::pluck($arr_tipo_entidad, 'descripcion', 'id_tipo_entidad'), null, ['placeholder' => '- Seleccione su Tipo de Entidad -', 'class' => 'form-control']) }}
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
                                    {{ Form::radio('flg_estado', 0, false) }} Inactivo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label(null, 'Descripción') }}
                            {{ Form::text('descripcion', null, ['placeholder' => 'Descripción', 'class' => 'form-control description', 'maxlength' => '255']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg margen">Filtrar</button>
                <a href="{{ route('cargo') }}" class="btn btn-default btn-lg margen" title="Reiniciar"><i class="fa fa-refresh"></i></a>
            </div>
        </div>
    </fieldset>
    {{ Form::close() }}
    <div class="table-responsive">
        <table class="tabla" id="grid"></table>
    </div>
</div>
<script type="text/template" id="template">
    @show ('editar_cargo')
    <button type="button" data-url="{{ route('cargo') }}/editar/@id" class="btn btn-primary pop-up" title="Editar"><i class="fa fa-edit"></i></button>
    @endshow
    <button type="button" data-url="{{ route('cargo') }}/detalles/@id" class="btn btn-default pop-up" title="Detalles"><i class="fa fa-eye"></i></button>
</script>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    var grid;
    $(function() {
        grid = $("#grid").grid({
            primaryKey: "id_cargo",
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
                    field: "id_cargo",
                    hidden: true
                },
                {
                    field: "descripcion",
                    title: "Descripción"
                },
                {
                    field: "id_tipo_entidad",
                    title: "Tipo de Entidad",
                    renderer: function(value, record) {
                        return $.exec(record.tipo_entidad, function(ref) {
                            return ref.descripcion;
                        });
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
                    field: 'id_cargo',
                    title: "Acción",
                    width: 180,
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