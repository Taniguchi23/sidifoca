@extends('layout')

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title titulo">Registro de Usuario <small>(Todos los campos * son obligatorios)</small></h3>
        </div>
        <div class="panel-body">
            {{ Form::open(['route' => 'guardar', 'files' => 'true', 'autocomplete' => 'off', 'data-encrypt' => '1', 'id' => 'editar']) }}
            {{ Form::divError() }}
            <fieldset>
                <legend>Datos personales</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_tipo_documento', 'Tipo de documento', ['class' => 'asterisk']) }}
                            {{ Form::select('id_tipo_documento', Arr::pluck($arr_tipo_documento, 'descripcion', 'id_tipo_documento'), null, ['placeholder' => '- Seleccione su tipo de documento -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('nro_documento', 'Número de documento', ['class' => 'asterisk']) }}
                            <div class="input-group input-group-lg">
                                {{ Form::text('nro_documento', null, ['placeholder' => 'Número de documento', 'class' => 'form-control description', 'readonly' => 'true']) }}
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" title="Si desea consultar otro DNI hacer clic en el boton Reiniciar" id="reiniciar" style="display: none;"><i class="fa fa-refresh"></i> Reiniciar</button>
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
                            {{ Form::label('apellido_paterno', 'Apellido paterno', ['class' => 'asterisk']) }}
                            {{ Form::text('apellido_paterno', null, ['placeholder' => 'Apellido paterno', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-lg">
                            {{ Form::label('apellido_materno', 'Apellido materno') }}
                            {{ Form::text('apellido_materno', null, ['placeholder' => 'Apellido materno', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-lg">
                            {{ Form::label('nombres', 'Nombres', ['class' => 'asterisk']) }}
                            {{ Form::text('nombres', null, ['placeholder' => 'Nombres', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255']) }}
                        </div>
                    </div>
                </div>
                <hr>
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
                    <div class="col-md-4">
                        <div class="form-group form-group-lg">
                            {{ Form::label('direccion', 'Dirección') }}
                            {{ Form::textarea('direccion', null, ['placeholder' => 'Dirección', 'class' => 'form-control description', 'rows' => '2', 'maxlength' => '255']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-lg">
                            {{ Form::label('email', 'Correo electrónico', ['class' => 'asterisk']) }}
                            {{ Form::text('email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control', 'maxlength' => '255']) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_genero', 'Género', ['class' => 'asterisk']) }}
                            {{ Form::select('id_genero', Arr::pluck($arr_genero, 'descripcion', 'id_genero'), null, ['placeholder' => '- Seleccione su género -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-lg">
                            {{ Form::label('telefono_fijo', 'Teléfono fijo') }}
                            {{ Form::text('telefono_fijo', null, ['placeholder' => 'Teléfono fijo', 'class' => 'form-control', 'data-mask' => '999999?9999', 'data-placeholder' => '']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group form-group-lg">
                            {{ Form::label('telefono_celular', 'Teléfono celular', ['class' => 'asterisk']) }}
                            {{ Form::text('telefono_celular', null, ['placeholder' => 'Teléfono celular', 'class' => 'form-control', 'data-mask' => '999999999', 'data-placeholder' => '']) }}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>NOTA IMPORTANTE:</strong> 
                    <br>
                    La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('password', 'Contraseña', ['class' => 'asterisk']) }}
                            {{ Form::password('password', ['placeholder' => 'Contraseña', 'class' => 'form-control description', 'maxlength'=> '16']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('password_confirmation', 'Repetir contraseña', ['class' => 'asterisk']) }}
                            {{ Form::password('password_confirmation', ['placeholder' => 'Repetir contraseña', 'class' => 'form-control description', 'maxlength'=> '16']) }}
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Datos institucionales</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_tipo_entidad', 'Tipo de entidad', ['class' => 'asterisk']) }}
                            {{ Form::select('id_tipo_entidad', Arr::pluck($arr_tipo_entidad, 'descripcion', 'id_tipo_entidad'), null, ['placeholder' => '- Seleccione su tipo de entidad -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg" style="display: none">
                            {{ Form::label('id_dre_gre', 'DRE / GRE', ['class' => 'asterisk']) }}
                            {{ Form::select('id_dre_gre', Arr::pluck($arr_dre_gre, 'descripcion', 'id_dre_gre'), null, ['placeholder' => '- Seleccione su DRE / GRE -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg" style="display: none">
                            {{ Form::label('id_ugel', 'UGEL', ['class' => 'asterisk']) }}
                            {{ Form::select('id_ugel', [], null, ['placeholder' => '- Seleccione su UGEL -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg" style="display: none">
                            {{ Form::label('id_entidad_externa', 'Entidad externa', ['class' => 'asterisk']) }}
                            {{ Form::select('id_entidad_externa', Arr::pluck($arr_entidad_externa, 'descripcion', 'id_entidad_externa'), null, ['placeholder' => '- Seleccione su entidad externa -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg" style="display: none">
                            {{ Form::label('id_area', 'Área en la que labora') }}
                            {{ Form::select('id_area', Arr::pluck($arr_area, 'descripcion', 'id_area'), null, ['placeholder' => '- Seleccione su área -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_nivel_puesto', 'Nivel del puesto', ['class' => 'asterisk']) }}
                            {{ Form::select('id_nivel_puesto', [], null, ['placeholder' => '- Seleccione su nivel del puesto -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_puesto', 'Nombre del puesto', ['class' => 'asterisk']) }}
                            {{ Form::select('id_puesto', [], null, ['placeholder' => '- Seleccione su nombre del puesto -', 'class' => 'form-control']) }}
                        </div>
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('flg_ejerce_cargo') }} ¿Ejerce actualmente el cargo?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('id_regimen_laboral', 'Régimen laboral', ['class' => 'asterisk']) }}
                            {{ Form::select('id_regimen_laboral', Arr::pluck($arr_regimen_laboral, 'descripcion', 'id_regimen_laboral'), null, ['placeholder' => '- Seleccione su régimen laboral -', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg">
                            {{ Form::label('url_documento', 'Adjunte resolución, oficio o contrato vigente') }}
                            {{ Form::fileinput('url_documento', ['accept' => 'application/pdf']) }}
                            <span class="text-primary">Documento formato PDF | Peso máx. 2MB</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group form-group-lg">
                            <img src="{{ Captcha::src('flat') }}" class="img-thumbnail captcha" alt="">
                            {{ Form::label('captcha', 'Ingrese el código de la imagen', ['class' => 'asterisk']) }}
                            {{ Form::text('captcha', null, ['placeholder' => 'Captcha', 'class' => 'form-control text-lowercase alpha-num', 'maxlength' => '255']) }}
                        </div>
                    </div>
                </div>
            </fieldset>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Guardar</button>
            {{ Form::close() }}
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
                url: "{{ route('reniec') }}",
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
                            "id_genero": ""
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
                        var reniec = {
                            "apellido_paterno": "",
                            "apellido_materno": "",
                            "nombres": "",
                            "fecha_nacimiento": "",
                            "direccion": "",
                            "id_genero": ""
                        };
                        $.each(reniec, function(key, value) {
                            $("#" + key).val(value);
                            $("#" + key).attr("readonly", false);
                        });
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
                "id_genero": ""
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
            $("#id_area").closest(".form-group").hide();
            $("#id_entidad_externa").closest(".form-group").hide();
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
                    url: "{{ route('listar_ugel') }}",
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
        $("#id_tipo_entidad").change(function(e) {
            $.ajax({
                url: "{{ route('listar_nivel_puesto') }}",
                data: {
                    id_tipo_entidad: $(this).val()
                },
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(data) {
                    $("#id_nivel_puesto").items({
                        placeholder: "- Seleccione su nivel del puesto -",
                        text: "descripcion",
                        value: "id_nivel_puesto",
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
        $("#id_nivel_puesto").change(function(e) {
            $.ajax({
                url: "{{ route('listar_puesto') }}",
                data: {
                    id_tipo_entidad: $("#id_tipo_entidad").val(),
                    id_nivel_puesto: $(this).val()
                },
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(data) {
                    $("#id_puesto").items({
                        placeholder: "- Seleccione su nombre del puesto -",
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
                            //$("#password").val("");
                            //$("#password_confirmation").val("");
                            $("#captcha").val("");
                            $(".captcha").captcha("{{ route('recaptcha') }}");
                        });
                        $.unblockUI();
                    } else {
                        $.redirect("{{ route('intranet') }}");
                    }
                },
                error: function(xhr, status) {
                    if (xhr.status === 422) {
                        $(self).errors(xhr.responseJSON.errors, function(divError) {
                            //$("#password").val("");
                            //$("#password_confirmation").val("");
                            $("#captcha").val("");
                            $(".captcha").captcha("{{ route('recaptcha') }}");
                        });
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