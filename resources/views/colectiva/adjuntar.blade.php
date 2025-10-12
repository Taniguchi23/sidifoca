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
                    <li>
                        <a href="{{ route('colectiva.editar', $postulacion->id_postulacion) }}">
                            <h4 class="list-group-item-heading">Paso 2</h4>
                            <p class="list-group-item-text">Registro de datos</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0)">
                            <h4 class="list-group-item-heading">Paso 3</h4>
                            <p class="list-group-item-text">Adjuntar y enviar documentos</p>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        {{ Form::model($postulacion, ['route' => ['colectiva.enviar', $postulacion->id_postulacion], 'autocomplete' => 'off', 'files' => true, 'id' => 'editar']) }}
                        {{ Form::divError() }}
                        <h2 class="text-center">Código de la postulación: <strong>{{ $postulacion->codigo }}</strong></h2>
                        <div class="form-horizontal">
                            <fieldset>
                                <legend>Datos de la postulación</legend>
                                <div class="form-group form-group-lg">
                                    {{ Form::label(null, 'Nombre de la Buena Práctica', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{ $postulacion->buena_practica }}</p>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label(null, 'Categoría de postulación', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{ $postulacion->categoria }}</p>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label(null, 'Tema', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{ $postulacion->tema }}</p>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label(null, 'Tiempo de implementación de la Buena Práctica', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{ $postulacion->nro_meses }} meses / {{ $postulacion->nro_dias }} dias</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Adjuntar documentos</legend>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('url_declaracion_representante', 'Declaración del representante', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-7">
                                        {{ Form::fileinput('url_declaracion_representante', ['accept' => 'image/jpeg,image/gif,image/png,application/pdf,.zip,.rar,.7zip', 'class' => "truncar"]) }}
                                        <span class="text-primary">Documento formato PDF - ZIP - RAR | Peso máx. 2MB</span>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" data-help="1" class="btn btn-info btn-block btn-lg" title="Ayuda"><i class="fa fa-info-circle"></i></button>
                                    </div>
                                </div>
                                @empty ($postulacion->m_id_gobierno_local)
                                <div class="form-group form-group-lg">
                                    {{ Form::label('url_declaracion_equipo', 'Declaración del equipo', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-7">
                                        {{ Form::fileinput('url_declaracion_equipo', ['accept' => 'image/jpeg,image/gif,image/png,application/pdf,.zip,.rar,.7zip']) }}
                                        <span class="text-primary">Documento formato PDF - ZIP - RAR | Peso máx. 2MB</span>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" data-help="2" class="btn btn-info btn-block btn-lg" title="Ayuda"><i class="fa fa-info-circle"></i></button>
                                    </div>
                                </div>
                                @else
                                <div class="form-group form-group-lg">
                                    {{ Form::label('url_declaracion_equipo', 'Declaración del Equipo y Declaración del Equipo de Gobierno Local', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-7">
                                        {{ Form::fileinput('url_declaracion_equipo', ['accept' => 'image/jpeg,image/gif,image/png,application/pdf,.zip,.rar,.7zip']) }}
                                        <span class="text-primary">Documento formato PDF - ZIP - RAR | Peso máx. 2MB</span>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" data-help="2" class="btn btn-info btn-block btn-lg" title="Ayuda"><i class="fa fa-info-circle"></i></button>
                                    </div>
                                </div>
                                @endempty
                                <div class="form-group form-group-lg">
                                    {{ Form::label('url_acta_modalidad_colectiva', 'Acta Modalidad Colectiva', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-7">
                                        {{ Form::fileinput('url_acta_modalidad_colectiva', ['accept' => 'image/jpeg,image/gif,image/png,application/pdf,.zip,.rar,.7zip']) }}
                                        <span class="text-primary">Documento formato PDF - ZIP - RAR | Peso máx. 2MB</span>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" data-help="3" class="btn btn-info btn-block btn-lg" title="Ayuda"><i class="fa fa-info-circle"></i></button>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('url_documento_imagen', 'URL de documentos y/o imagenes', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-7">
                                        {{ Form::text('url_documento_imagen', null, ['placeholder' => 'URL de documentos y/o imagenes', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" data-help="4" class="btn btn-info btn-block btn-lg" title="Ayuda"><i class="fa fa-info-circle"></i></button>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('url_video', 'URL del video', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-7">
                                        {{ Form::text('url_video', null, ['placeholder' => 'URL del video', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" data-help="5" class="btn btn-info btn-block btn-lg" title="Ayuda"><i class="fa fa-info-circle"></i></button>
                                    </div>
                                </div>
                                <div class="form-group form-group-lg">
                                    {{ Form::label('captcha', 'Ingrese el código de la imagen', ['class' => 'asterisk control-label col-md-4']) }}
                                    <div class="col-md-7">
                                        <img src="{{ Captcha::src('flat') }}" class="img-thumbnail captcha" alt="">
                                        {{ Form::text('captcha', null, ['placeholder' => 'Captcha', 'class' => 'form-control text-lowercase alpha-num', 'maxlength' => '255']) }}
                                    </div>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-primary btn-block btn-lg">REGISTRAR Y ENVIAR ARCHIVOS</button>
                        </div>
                        {{ Form::close() }}
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
        $("[data-help]").click(function(e) {
            e.preventDefault();
            var tipo = $(this).data("help");
            switch (AyudaEnum.properties[tipo].value) {
                case AyudaEnum.DECLARACION_REPRESENTANTE:
                    bootbox.alert({
                        title: "Declaración del representante",
                        message: 'El Director(a) de la DRE/GRE o UGEL corrobora la veracidad de la información presentada; autoriza la sistematización y difusión; acredita que la buena práctica tiene un mínimo de 06 meses de implementada; se compromete a que el equipo técnico participe de la ceremonia de premiación, si resultan ganadores; y asegura no tener proceso legal o administrativo, ni sanción disciplinaria a la fecha.',
                        buttons: {
                            ok: {
                                label: "CONTINUAR",
                                className: "btn-primary btn-block btn-lg"
                            }
                        }
                    });
                    break;
                case AyudaEnum.DECLARACION_EQUIPO:
                    bootbox.alert({
                        title: "Declaración del equipo",
                        message: 'Los miembros del equipo técnico corroboran la veracidad de la información presentada, aseveran haber participado en la implementación y sistematización de la buena práctica y aseguran no tener proceso legal o administrativo, ni sanción disciplinaria a la fecha.',
                        buttons: {
                            ok: {
                                label: "CONTINUAR",
                                className: "btn-primary btn-block btn-lg"
                            }
                        }
                    });
                    break;
                case AyudaEnum.ACTA_MODALIDAD_COLECTIVA:
                    bootbox.alert({
                        title: "Acta Modalidad Colectiva",
                        message: 'En este documento las DRE/GRE o UGEL que implementaron la buena práctica de forma colectiva nombran, por acuerdo, a quien representará la propuesta, consignando los nombres y firmas de los Directores de cada una de las instituciones así como de los integrantes de los respectivos equipos técnicos.',
                        buttons: {
                            ok: {
                                label: "CONTINUAR",
                                className: "btn-primary btn-block btn-lg"
                            }
                        }
                    });
                    break;
                case AyudaEnum.URL_DOCUMENTO_IMAGEN:
                    bootbox.alert({
                        title: "URL de documentos y/o imagenes",
                        message: 'Adjunte los documentos (informes, resoluciones, convenios, etc.) y fotos que evidencien la buena práctica. En ambos casos deberán ser enviados a través de GOOGLE DRIVE al email edutalentos@gmail.com  .Copiar y pegar la URL generada en esta celda.',
                        buttons: {
                            ok: {
                                label: "CONTINUAR",
                                className: "btn-primary btn-block btn-lg"
                            }
                        }
                    });
                    break;
                case AyudaEnum.URL_VIDEO:
                    bootbox.alert({
                        title: "URL del video",
                        message: 'Los videos deberán ser enviados a través de GOOGLE DRIVE al email edutalentos@gmail.com  .Copiar y pegar la URL generada en esta celda.',
                        buttons: {
                            ok: {
                                label: "CONTINUAR",
                                className: "btn-primary btn-block btn-lg"
                            }
                        }
                    });
                    break;
            }
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
                            $("#captcha").val("");
                            $(".captcha").captcha("{{ route('colectiva.captcha') }}");
                        });
                        $.unblockUI();
                    } else {
                        $.redirect("{{ route('colectiva.adjuntar', $postulacion->id_postulacion) }}");
                    }
                },
                error: function(xhr, status) {
                    if (xhr.status === 422) {
                        $(self).errors(xhr.responseJSON.errors, function(divError) {
                            $("#captcha").val("");
                            $(".captcha").captcha("{{ route('colectiva.captcha') }}");
                        });
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