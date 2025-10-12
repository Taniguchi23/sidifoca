@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Fase de selección de finalistas</h1>
    </div>
    {{ Form::open(['route' => 'postulacion_finalista', 'autocomplete' => 'off', 'id' => 'busqueda']) }}
    {{ Form::hidden('page', 1) }}
    <fieldset class="custom">
        <legend>Búsqueda</legend>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_modalidad', 'Modalidad') }}
                            {{ Form::select('id_modalidad', Arr::pluck($arr_modalidad, 'descripcion', 'id_modalidad'), null, ['placeholder' => '- Seleccione su Modalidad -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_tipo_postulacion', 'Tipo de Postulación') }}
                            {{ Form::select('id_tipo_postulacion', [], null, ['placeholder' => '- Seleccione su Tipo de Postulación -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_categoria', 'Categoría') }}
                            {{ Form::select('id_categoria', Arr::pluck($arr_categoria, 'descripcion', 'id_categoria'), null, ['placeholder' => '- Seleccione su Categoría -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_tema', 'Tema') }}
                            {{ Form::select('id_tema', [], null, ['placeholder' => '- Seleccione su Tema -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label(null, 'Buena Práctica') }}
                    {{ Form::text('buena_practica', null, ['placeholder' => 'Buena Práctica', 'class' => 'form-control description']) }}
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg margen">Filtrar</button>
                <a href="{{ route('postulacion') }}" class="btn btn-default btn-lg margen" title="Reiniciar"><i class="fa fa-refresh"></i></a>
            </div>
        </div>
    </fieldset>
    {{ Form::close() }}
    <p class="negrita text-center text-uppercase">{{ $concurso->descripcion }} ({{ $concurso->fecha_inicio }} - {{ $concurso->fecha_termino }})</p>
    <div class="table-responsive">
        <table class="tabla" id="grid"></table>
    </div>
</div>
<script type="text/template" id="template">
    @show ('calificar_finalista')
    <a href="{{ route('postulacion_finalista') }}/calificar/@id" class="btn btn-primary" title="Validar"><i class="fa fa-check"></i></a>
    @endshow
    <a href="{{ route('postulacion_finalista') }}/detalles/@id" class="btn btn-default" title="Detalles"><i class="fa fa-eye"></i></a>
</script>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    var grid;
    $(function() {
        $("#id_modalidad").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('postulacion_finalista.listar_tipo_postulacion') }}",
                data: {
                    id_modalidad: $(self).val()
                },
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    $("#id_tipo_postulacion").items({
                        placeholder: "- Seleccione su Tipo de Postulación -",
                        text: "descripcion",
                        value: "id_tipo_postulacion",
                        data: json
                    });
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    if (xhr.status === 401) {
                        alert("Su sesión ha expirado.");
                        location.href = "{{ route('login') }}";
                    } else {
                        alert("Se ha producido un error");
                    }
                    $.unblockUI();
                }
            });
        });
        $("#id_categoria").change(function(e) {
            var self = this;
            $.ajax({
                url: "{{ route('postulacion_finalista.listar_tema') }}",
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
                    if (xhr.status === 401) {
                        alert("Su sesión ha expirado.");
                        location.href = "{{ route('login') }}";
                    } else {
                        alert("Se ha producido un error");
                    }
                    $.unblockUI();
                }
            });
        });
        grid = $("#grid").grid({
            primaryKey: "id_postulacion",
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
                    field: "id_postulacion",
                    hidden: true
                },
                {
                    field: "id_modalidad",
                    title: "Modalidad",
                    width: 100,
                    renderer: function(value, record) {
                        switch (ModalidadEnum.properties[value].value) {
                            case ModalidadEnum.INDIVIDUAL:
                                return '<span class="badge">INDIVIDUAL</span>';
                                break;
                            case ModalidadEnum.COLECTIVA:
                                return '<span class="badge">COLECTIVA</span>';
                                break;
                        }
                        return value;
                    }
                },
                {
                    field: "buena_practica",
                    title: "Buena Práctica"
                },
                {
                    field: "id_categoria",
                    title: "Categoría",
                    renderer: function(value, record) {
                        return $.exec(record.categoria, function(ref) {
                            return ref.descripcion;
                        });
                    }
                },
                {
                    field: "fecha_envio",
                    title: "Fecha de envío",
                    width: 100
                },
                {
                    field: "flg_estado",
                    title: "Activo",
                    width: 80,
                    type: "checkbox",
                    align: "center"
                },
                {
                    field: 'id_postulacion',
                    title: "Acción",
                    width: 130,
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