@extends('layout')

@section('content')
<div class="container">
    <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
        {{ Form::open(['route' => 'authenticate', 'autocomplete' => 'off', 'id' => 'ingresar']) }}
        {{ Form::divError() }}
        <div class="well">
            <h2 class="text-center">Bienvenido</h2>
            <hr>
            <div class="form-group form-group-lg">
                {{ Form::label('username', 'Usuario', ['class' => 'asterisk']) }}
                {{ Form::text('username', null, ['placeholder' => 'Usuario o correo electrónico', 'class' => 'form-control', 'maxlength' => '255']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('password', 'Contraseña', ['class' => 'asterisk']) }}
                {{ Form::password('password', ['placeholder' => 'Contraseña', 'class' => 'form-control description', 'maxlength' => '16']) }}
            </div>
            <div class="checkbox">
                <label>
                    {{ Form::checkbox('remember', true) }} Recuérdame los próximos 30 días.
                </label>
            </div>
            <div class="form-group form-group-lg">
                <img src="{{ Captcha::src('flat') }}" class="img-thumbnail captcha" alt="">
                {{ Form::label('captcha', 'Ingrese el código de la imagen', ['class' => 'asterisk']) }}
                {{ Form::text('captcha', null, ['placeholder' => 'Captcha', 'class' => 'form-control text-lowercase alpha-num', 'maxlength' => '255']) }}
            </div>
            <button type="submit" class="btn btn-success btn-block btn-lg">Ingresar</button>
            <a href="{{ route('registrarse') }}" class="btn btn-primary btn-block btn-lg">Registrarse</a>
        </div>
        <div class="contrasena">
            <a href="{{ route('recuperar_contrasena') }}">¿Ha olvidado su contraseña?</a>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    $(function() {
        $("#ingresar").submit(function(e) {
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
                        $.unblockUI();
                    } else {
                        $.redirect("{{ route('intranet') }}");
                    }
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