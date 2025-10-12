{{ Form::open(['route' => ['mi_perfil.grabar_contrasena'], 'autocomplete' => 'off', 'id' => 'editar']) }}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">
                Editar contraseña
            </h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>NOTA IMPORTANTE:</strong> 
                <br>
                La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.
            </div>
            {{ Form::divError() }}
            <div class="form-group form-group-lg">
                {{ Form::label('current_password', 'Contraseña actual', ['class' => 'asterisk']) }}
                {{ Form::password('current_password', ['placeholder' => 'Contraseña actual', 'class' => 'form-control description', 'maxlength' => '16']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('password', 'Nueva contraseña', ['class' => 'asterisk']) }}
                {{ Form::password('password', ['placeholder' => 'Nueva contraseña', 'class' => 'form-control description', 'maxlength' => '16']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('password_confirmation', 'Repetir contraseña', ['class' => 'asterisk']) }}
                {{ Form::password('password_confirmation', ['placeholder' => 'Repetir contraseña', 'class' => 'form-control description', 'maxlength' => '16']) }}
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
            <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
{{ Form::close() }}

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
                        $(self).errors(json.errors);
                    } else {
                        $("#toast").toast("Se guardó correctamente.");
                        $("#contenedor").modal("hide");
                    }
                    $.unblockUI();
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