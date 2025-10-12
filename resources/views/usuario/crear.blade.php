@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Nuevo registro</h1>
    </div>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('usuario') }}"><strong>Gestión de Administrados</strong></a>
        </li>
        <li class="active">Nuevo registro</li>
    </ol>
    <div id="rootwizard">
        <ul class="nav nav-pills nav-justified thumbnail">
            <li class="active">
                <a href="javascript:void(0)">
                    <h4 class="list-group-item-heading">Paso 1</h4>
                    <p class="list-group-item-text">Datos personales</p>
                </a>
            </li>
            <li class="disabled">
                <a href="javascript:void(0)">
                    <h4 class="list-group-item-heading">Paso 2</h4>
                    <p class="list-group-item-text">Datos institucionales</p>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                {{ Form::open(['route' => 'usuario.guardar', 'files' => 'true', 'autocomplete' => 'off', 'data-encrypt' => '1', 'id' => 'editar']) }}
                {{ Form::divError() }}
                <fieldset class="redondeado">
                    <legend>Datos personales</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-lg">
                                {{ Form::label('id_tipo_documento', 'Tipo de documento', ['class' => 'asterisk']) }}
                                {{ Form::select('id_tipo_documento', Arr::pluck($arr_tipo_documento, 'descripcion', 'id_tipo_documento'), null, ['placeholder' => '- Seleccione su Tipo de Documento -', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-lg">
                                {{ Form::label('nro_documento', 'Número de documento', ['class' => 'asterisk']) }}
                                <div class="input-group input-group-lg">
                                    {{ Form::text('nro_documento', null, ['placeholder' => 'Número de documento', 'class' => 'form-control', 'readonly' => true]) }}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" title="Si desea consultar otro DNI hacer clic en el boton Reiniciar" id="reiniciar" style="display: none;"><i class="fa fa-pencil"></i> Reiniciar</button>
                                        <button type="button" class="btn btn-primary" title="Si desea consultar el DNI hacer clic en el boton Consultar Reniec" id="reniec" disabled><i class="fa fa-search"></i> Reniec</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label('nombres', 'Nombres', ['class' => 'asterisk']) }}
                                {{ Form::text('nombres', null, ['placeholder' => 'Nombres', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label('apellido_paterno', 'Apellido Paterno', ['class' => 'asterisk']) }}
                                {{ Form::text('apellido_paterno', null, ['placeholder' => 'Apellido Paterno', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label('apellido_materno', 'Apellido Materno') }}
                                {{ Form::text('apellido_materno', null, ['placeholder' => 'Apellido Materno', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label('fecha_nacimiento', 'Fecha de nacimiento', ['class' => 'asterisk']) }}
                                <div class="input-group date" id="g_fecha_nacimiento">
                                    {{ Form::text('fecha_nacimiento', null, ['placeholder' => 'Fecha de nacimiento', 'class' => 'form-control']) }}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group form-group-lg">
                                {{ Form::label('direccion', 'Dirección') }}
                                {{ Form::text('direccion', null, ['placeholder' => 'Dirección', 'class' => 'form-control text-uppercase description', 'maxlength' => '255']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label('id_genero', 'Género', ['class' => 'asterisk']) }}
                                {{ Form::select('id_genero', Arr::pluck($arr_genero, 'descripcion', 'id_genero'), null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group form-group-lg">
                                {{ Form::label('url_fotografia', 'Fotografia') }}
                                <div class="clearfix">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="{{ asset('images/imagen190x140.svg') }}" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <div class="btn btn-default btn-file">
                                                <span class="fileinput-new">Seleccionar imagen</span><span class="fileinput-exists">Cambiar</span>
                                                {{ Form::file('url_fotografia', ['accept' => 'image/gif, image/jpeg, image/png']) }}
                                            </div>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-primary">Imagen formato (JPG, BMP, PNG) | Peso máx. 2MB</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label('telefono_fijo', 'Teléfono fijo') }}
                                {{ Form::text('telefono_fijo', null, ['placeholder' => 'Teléfono fijo', 'class' => 'form-control', 'data-mask' => '999999?9999', 'data-placeholder' => '']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label('telefono_celular', 'Teléfono celular') }}
                                {{ Form::text('telefono_celular', null, ['placeholder' => 'Teléfono celular', 'class' => 'form-control', 'data-mask' => '999999999', 'data-placeholder' => '']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label('email', 'Correo electrónico', ['class' => 'asterisk']) }}
                                {{ Form::text('email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control', 'maxlength' => '255']) }}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                {{ Form::label(null, 'Persona con discapacidad') }}
                                <div class="radio">
                                    <label class="radio-inline" title="Si responde SI debe adjuntar su Carnet de Conadis">
                                        {{ Form::radio('flg_discapacidad', 1, false) }} SI
                                    </label>
                                    <label class="radio-inline">
                                        {{ Form::radio('flg_discapacidad', 0, true) }}NO
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group form-group-lg" style="display: none">
                                {{ Form::label('url_carnet_conadis', 'Carnet de Conadis') }}
                                {{ Form::fileinput('url_carnet_conadis', ['accept' => 'image/jpeg,image/gif,image/png,application/pdf,image/x-eps']) }}
                                <span class="text-primary">Documento formato PDF o Imagen | Peso máx. 2MB</span>
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
        $("#id_tipo_documento").change(function(e) {
            $("#nro_documento").val("");
            $("#nro_documento").attr("readonly", false);
            $("#nro_documento").closest(".form-group").removeClass("has-error");
            $("#nro_documento").closest(".form-group").find(".help-block").remove();
            var tipo = $(this).val();
            if (tipo) {
                var mask = "";
                switch (TipoDocEnum.properties[tipo].value) {
                    case TipoDocEnum.DNI:
                        mask = "99999999";
                        $("#reniec").attr("disabled", false);
                        break;
                    case TipoDocEnum.CARNET_EXT:
                        mask = "wwwwwwww?wwww";
                        $("#reniec").attr("disabled", true);
                        break;
                }
                var inputmask = $("#nro_documento").data("bs.inputmask");
                if (inputmask) {
                    inputmask.mask = mask;
                    inputmask.init();
                    inputmask.checkVal();
                } else {
                    $("#nro_documento").inputmask({
                        mask: mask,
                        placeholder: ""
                    });
                }
            } else {
                $("#nro_documento").attr("readonly", true);
                $("#reniec").attr("disabled", true);
            }
        });
        $("#reniec").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('usuario.reniec') }}",
                data: {
                    nro_documento: encrypt($("#nro_documento").val())
                },
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        $("#editar").errors(json.errors, function(divError) {
                            divError.css("display", "none");
                        });
                        var data = {
                            "apellido_paterno": "",
                            "apellido_materno": "",
                            "nombres": "",
                            "fecha_nacimiento": "",
                            "direccion": "",
                            "id_genero": "1"
                        };
                        $.each(data, function(key, value) {
                            $("#" + key).val(value);
                            $("#" + key).attr("readonly", false);
                            $("#" + key).closest(".form-group").removeClass("has-error");
                            $("#" + key).closest(".form-group").find(".help-block").remove();
                        });
                    } else {
                        $("#reniec").hide("slow");
                        $("#reiniciar").show("slow");
                        $.each(json.data, function(key, value) {
                            $("#" + key).val(decrypt(value));
                            $("#" + key).attr("readonly", true);
                            $("#" + key).closest(".form-group").removeClass("has-error");
                            $("#" + key).closest(".form-group").find(".help-block").remove();
                        });
                        $("#id_genero option:not(:selected)").attr("disabled", true);
                        $("#id_tipo_documento option:not(:selected)").attr("disabled", true);
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    if (xhr.status === 422) {
                        $("#editar").errors(xhr.responseJSON.errors, function(divError) {
                            divError.css("display", "none");
                        });
                        var data = {
                            "apellido_paterno": "",
                            "apellido_materno": "",
                            "nombres": "",
                            "fecha_nacimiento": "",
                            "direccion": "",
                            "id_genero": "1"
                        };
                        $.each(data, function(key, value) {
                            $("#" + key).val(value);
                            $("#" + key).attr("readonly", false);
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
        $("#reiniciar").click(function(e) {
            e.preventDefault();
            var reniec = {
                "id_tipo_documento": "",
                "nro_documento": "",
                "apellido_paterno": "",
                "apellido_materno": "",
                "nombres": "",
                "fecha_nacimiento": "",
                "direccion": "",
                "id_genero": "1"
            };
            $("#reiniciar").hide("slow");
            $("#reniec").show("slow");
            $.each(reniec, function(key, value) {
                $("#" + key).val(value);
                $("#" + key).attr("readonly", false);
                $("#" + key).closest(".form-group").removeClass("has-error");
                $("#" + key).closest(".form-group").find(".help-block").remove();
            });
            $("#id_genero option").attr("disabled", false);
            $("#id_tipo_documento option").attr("disabled", false);
        });
        $("[name='flg_discapacidad']").click(function(e) {
            var flag = $(this).val();
            switch (BanderaEnum.properties[flag].value) {
                case BanderaEnum.SI:
                    $("#url_carnet_conadis").closest(".form-group").show("slow");
                    break;
                case BanderaEnum.NO:
                    $("#url_carnet_conadis").closest(".form-group").hide("slow");
                    break;
            }
        });
        $("#g_fecha_nacimiento").datetimepicker({
            locale: "es",
            format: 'DD/MM/YYYY'
        });
        $("#editar").submit(function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: $(self).attr("action"),
                data: $.formData(self),
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
                        $.redirect("{{ route('usuario') }}/@id/crear-contrato", {
                            id: json.data.id_usuario
                        });
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