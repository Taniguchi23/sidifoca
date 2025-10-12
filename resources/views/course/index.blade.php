@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Reporte Consolidado Estrategias</h1>
    </div>
    {{ Form::open(['route' => 'course.reporte', 'method' => 'GET', 'autocomplete' => 'off', 'id' => 'busqueda']) }}
    {{ Form::divError() }}
    <fieldset class="custom">
        <legend>Parámetros</legend>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('fecha_inicio', 'Fecha Inicio') }}
                            <div class="input-group date" id="start">
                                {{ Form::text('fecha_inicio', null, ['placeholder' => 'Fecha Inicio', 'class' => 'form-control']) }}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('fecha_fin', 'Fecha Fin') }}
                            <div class="input-group date" id="end">
                                {{ Form::text('fecha_fin', null, ['placeholder' => 'Fecha Fin', 'class' => 'form-control']) }}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary btn-lg">Ejecutar</button>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    {{ Form::close() }}
    <div class="table-responsive" id="reporte"></div>
</div>
<script type="text/template" id="template">
    <table class="table table-bordered tabla">
        <thead>
            <tr>
                <th>Consolidado</th>
                <th class="text-center" width="200">Fecha de creación</th>
                <th class="text-center" width="200">Tiempo de ejecución</th>
                <th class="text-center" width="200">Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <a href="{{ route('course.exportar') }}?filename=@filename" target="_blank" title="Descargar">consolidado.xlsx</a>
                </td>
                <td class="text-center">@now</td>
                <td class="text-center">@execution_time minutos</td>
                <td class="text-center">
                    <a href="{{ route('course.exportar') }}?filename=@filename" target="_blank" class="btn btn-success" title="Descargar"><i class="fa fa-download"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</script>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    var grid;
    $(function() {
        $("#start").datetimepicker({
            locale: "es",
            format: 'DD/MM/YYYY'
        }).on("dp.change", function(e) {
            $('#end').data("DateTimePicker").minDate(e.date);
        });
        $("#end").datetimepicker({
            locale: "es",
            format: 'DD/MM/YYYY',
            useCurrent: false
        }).on("dp.change", function(e) {
            $('#start').data("DateTimePicker").maxDate(e.date);
        });
        $("#busqueda").submit(function(e) {
            e.preventDefault();
            var self = this;
            if (validate()) {
                $.ajax({
                    url: $(self).attr("action"),
                    data: $(self).inputs(),
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $.blockUI();
                    },
                    success: function(json) {
                        $("#reporte").html($("#template").template(json));
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
            }
        });
    });
    function validate() {
        $("#error").find("ul").empty();
        if ($("#fecha_inicio").val() && $("#fecha_fin").val()) {
            $("#error").hide();
            return true;
        } else {
            $("#error").show();
            $("#error").find("ul").append("<li>Todos los campos son obligatorios</li>");
            return false;
        }
    }
</script>
@endsection