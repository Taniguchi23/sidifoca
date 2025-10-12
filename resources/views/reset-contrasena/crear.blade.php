@extends('layout')

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title titulo">¿Ha olvidado su contraseña?</h3>
        </div>
        <div class="panel-body">
            {{ Form::open(['route' => 'enviar_correo', 'autocomplete' => 'off', 'id' => 'editar']) }}
            {{ Form::divError() }}
            <div class="form-horizontal" data-display="1">
                <fieldset>
                    <legend>Recuperar contraseña</legend>
                    <p>Escriba su correo electrónico con la que está registrado y le remitiremos un enlace para restablecer su contraseña.</p>
                    <div class="form-group form-group-lg">
                        {{ Form::label('email', 'Correo electrónico', ['class' => 'control-label col-md-4 asterisk']) }}
                        <div class="col-md-4">
                            {{ Form::text('email', null, ['placeholder' => 'Correo electrónico.', 'class' => 'form-control', 'maxlength' => '255']) }}
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        {{ Form::label('captcha', 'Ingrese el código de la imagen', ['class' => 'control-label col-md-4 asterisk']) }}
                        <div class="col-md-4">
                            <img src="{{ Captcha::src('flat') }}" class="img-thumbnail captcha" alt="">
                            {{ Form::text('captcha', null, ['placeholder' => 'Captcha', 'class' => 'form-control text-lowercase alpha-num', 'maxlength' => '255']) }}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Guardar</button>
                </fieldset>
            </div>
            {{ Form::close() }}
            <div class="form-horizontal to" data-display="2" style="display: none;">
                <fieldset>
                    <legend>Revisa tu correo electrónico</legend>
                    <p>Enviamos un correo electrónico a <span id="email"></span>. Haz clic en el enlace que aparece en el correo para restablecer tu contraseña.</p>
                    <p>Si no ves el correo electrónico en tu bandeja de entrada, revisa otros lugares donde podría estar, como tus carpetas de correo no deseado, sociales u otras.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-block btn-lg">Ir al Portal</a>
                </fieldset>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    $(function() {
        $("#editar").submit(function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: $(self).attr("action"),
                data: $(self).encrypt(),
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        $(self).errors(json.errors, function(divError) {
                            $("#captcha").val("");
                            $(".captcha").captcha("{{ route('recaptcha') }}");
                        });
                    } else {
                        $("#error").hide();
                        $("[data-display]").hide();
                        $("[data-display='2']").show("slow");
                        $(".to").find("#email").text(json.data.email);
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    if (xhr.status === 422) {
                        $(self).errors(xhr.responseJSON.errors, function(divError) {
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