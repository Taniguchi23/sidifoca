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
                    <li class="active">
                        <a href="javascript:void(0)">
                            <h4 class="list-group-item-heading">Paso 1</h4>
                            <p class="list-group-item-text">Código de postulación</p>
                        </a>
                    </li>
                    <li class="disabled">
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
                @if($errors->any())
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
                    <strong>{{ $errors->first('*') }}</strong>
                </div>
                @endif
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="row widget-header-div">
                            <div class="col-md-4 widget-header-item">
                                <div class="jumbotron text-center">
                                    <h2>NUEVO</h2>
                                    <hr>
                                    <p class="fuente-1">Ingrese aquí si va a registrar una <u class="negrita">Buena Práctica</u> al concurso.</p>
                                    <button type="submit" data-url="{{ route('individual.registrar') }}" class="btn btn-primary btn-block btn-lg" id="nuevo">INGRESAR</button>
                                </div>
                            </div>
                            <div class="col-md-4 widget-header-item">
                                <div class="jumbotron text-center">
                                    <h2>CONTINUAR</h2>
                                    <hr>
                                    <p class="fuente-2">Ingrese aquí si va a <u class="negrita">completar el registro de una Buena Práctica</u> en la que ya estuvo registrando información.</p>
                                    <button type="button" data-url="{{ route('individual.codigo') }}" class="btn btn-primary btn-block btn-lg" id="editar">INGRESAR</button>
                                </div>
                            </div>
                            <div class="col-md-4 widget-header-item">
                                <div class="jumbotron text-center">
                                    <h2>ENVIAR</h2>
                                    <hr>
                                    <p class="fuente-3">Ingrese aquí si ya registró los datos de la ficha de postulación y esta pendiente que <u class="negrita">envíe los documentos</u> para finalizar su inscripción.</p>
                                    <button type="button" data-url="{{ route('individual.codigo') }}" class="btn btn-primary btn-block btn-lg" id="adjuntar">INGRESAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    $(function() {
        $("#nuevo").click(function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: $(self).data("url"),
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        $("#toast").toast("Se ha producido un error.");
                    } else {
                        bootbox.alert({
                            closeButton: false,
                            title: "Código de postulación",
                            message: '<p>Estimado Postulante, su código de postulación es:</p>' +
                                '<h3 class="text-center negrita">' + json.data.codigo + '</h3>' +
                                '<p>Este código le permitirá continuar con el registro de postulación, así como enviar los documentos para finalizar su inscripción.</p>',
                            buttons: {
                                ok: {
                                    label: "CONTINUAR",
                                    className: "btn-primary btn-block btn-lg"
                                }
                            },
                            callback: function() {
                                $.blockUI();
                                $.redirect("{{ route('individual') }}/editar/@id", {
                                    id: json.data.id_postulacion
                                });
                            }
                        });
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    alert("Se ha producido un error.");
                    $.unblockUI();
                }
            });
        });
        $("#editar").click(function(e) {
            e.preventDefault();
            var self = this;
            bootbox.dialog({
                title: "Ingrese su código de postulación:",
                message: '<div class="form-group form-group-lg">' +
                    '<input type="text" class="form-control" placeholder="Código de la postulación" data-mask="aa-9999999-9999" id="continuar">' +
                    '</div>',
                buttons: {
                    continuar: {
                        label: "CONTINUAR",
                        className: "btn-primary btn-block btn-lg",
                        callback: function() {
                            $.ajax({
                                url: $(self).data("url"),
                                data: {
                                    codigo: $("#continuar").val()
                                },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {
                                    $.blockUI();
                                },
                                success: function(json) {
                                    if (!json.success) {
                                        alert("Código de postulación no encontrado.");
                                    } else {
                                        $.blockUI();
                                        $.redirect("{{ route('individual') }}/editar/@id", {
                                            id: json.data.id_postulacion
                                        });
                                    }
                                    $.unblockUI();
                                },
                                error: function(xhr, status) {
                                    alert("Se ha producido un error.");
                                    $.unblockUI();
                                }
                            });
                            return false;
                        }
                    }
                }
            });
        });
        $("#adjuntar").click(function(e) {
            e.preventDefault();
            var self = this;
            bootbox.dialog({
                title: "Ingrese su código de postulación:",
                message: '<div class="form-group form-group-lg">' +
                    '<input type="text" class="form-control" placeholder="Código de la postulación" data-mask="aa-9999999-9999" id="enviar">' +
                    '</div>',
                buttons: {
                    continuar: {
                        label: "CONTINUAR",
                        className: "btn-primary btn-block btn-lg",
                        callback: function() {
                            $.ajax({
                                url: $(self).data("url"),
                                data: {
                                    codigo: $("#enviar").val()
                                },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {
                                    $.blockUI();
                                },
                                success: function(json) {
                                    if (!json.success) {
                                        alert("Código de postulación no encontrado.");
                                    } else {
                                        $.blockUI();
                                        $.redirect("{{ route('individual') }}/adjuntar/@id", {
                                            id: json.data.id_postulacion
                                        });
                                    }
                                    $.unblockUI();
                                },
                                error: function(xhr, status) {
                                    alert("Se ha producido un error.");
                                    $.unblockUI();
                                }
                            });
                            return false;
                        }
                    }
                }
            });
        });
    });
</script>
@endsection