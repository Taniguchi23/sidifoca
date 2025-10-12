@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Reporte Foros</h1>
    </div>
    {{ Form::open(['route' => 'forum.reporte', 'method' => 'GET', 'autocomplete' => 'off', 'id' => 'busqueda']) }}
    {{ Form::divError() }}
    <fieldset class="custom">
        <legend>Parámetros</legend>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-lg">
                            {{ Form::label('c_id', 'Curso') }}
                            {{ Form::select('c_id', Arr::pluck($courses, 'title', 'id'), null, ['placeholder' => '- Seleccione su Curso -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                        <!--<button type="submit" class="btn btn-primary btn-lg">Ejecutar</button>-->
                        <a href="{{ route('forum.exportar') }}" class="btn btn-success btn-lg" id="exportar">Exportar</a>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    {{ Form::close() }}
    <div class="table-responsive" id="reporte"></div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    $(function() {
        $("#busqueda").submit(function(e) {
            e.preventDefault();
            var self = this;
            if (validate()) {
                $.ajax({
                    url: $(self).attr("action"),
                    data: $(self).inputs(),
                    type: "POST",
                    beforeSend: function () {
                        $.blockUI();
                    },
                    success: function (html) {
                        $("#reporte").html(html);
                        $.unblockUI();
                    },
                    error: function (xhr) {
                        if (xhr.status === 401) {
                            alert("Su sesión ha expirado.");
                            location.href = "{{ route('login') }}";
                        } else {
                            alert("Se ha producido un error.");
                        }
                        $.unblockUI();
                    }
                });
            }
        });
        $("#exportar").click(function(e) {
            e.preventDefault();
            if (validate()) {
                $.blockUI();
                $.fileDownload($(this).attr("href"), {
                    httpMethod: "GET",
                    data: $("#busqueda").serialize(),
                    successCallback: function(url) {
                        $.unblockUI();
                    },
                    failCallback: function(responseHtml, url) {
                        alert("Se ha producido un error");
                        $.unblockUI();
                    }
                });
                return false;
            }
        });
        function validate() {
            $("#error").find("ul").empty();
            if ($("#c_id").val()) {
                $("#error").hide();
                return true;
            } else {
                $("#error").show();
                $("#error").find("ul").append("<li>Todos los campos son obligatorios</li>");
                return false;
            }
        }
    });
</script>
@endsection