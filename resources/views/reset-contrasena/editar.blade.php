@extends('layout')

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title titulo">Recuperar contraseña</h3>
        </div>
        <div class="panel-body">
            {{ Form::model($reset_contrasena, ['route' => ['grabar_contrasena', $reset_contrasena->id_reset_contrasena], 'autocomplete' => 'off', 'id' => 'editar']) }}
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>NOTA IMPORTANTE:</strong>
                <br>
                La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.
            </div>
            {{ Form::divError() }}
            <fieldset>
                <legend>Editar contraseña</legend>
                <div class="form-group form-group-lg">
                    {{ Form::label('password', 'Nueva contraseña', ['class' => 'asterisk']) }}
                    {{ Form::password('password', ['placeholder' => 'Nueva contraseña', 'class' => 'form-control description', 'maxlength' => '16']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('password_confirmation', 'Repetir contraseña', ['class' => 'asterisk']) }}
                    {{ Form::password('password_confirmation', ['placeholder' => 'Repetir contraseña', 'class' => 'form-control description', 'maxlength' => '16']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('captcha', 'Ingrese el código de la imagen', ['class' => 'asterisk']) }}
                    <div class="">
                        <img src="{{ Captcha::src('flat') }}" class="img-thumbnail captcha" alt="">
                        {{ Form::text('captcha', null, ['placeholder' => 'Captcha', 'class' => 'form-control text-lowercase', 'maxlength' => '255']) }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg">Guardar</button>
            </fieldset>
            {{ Form::close() }}
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
                        $.unblockUI();
                    } else {
                        $.redirect("{{ route('login') }}");
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