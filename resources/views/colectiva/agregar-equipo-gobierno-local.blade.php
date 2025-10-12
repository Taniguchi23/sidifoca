{{ Form::open(['route' => ['colectiva.guardar_equipo_gobierno_local', $id_postulacion], 'autocomplete' => 'off', 'id' => 'grabar']) }}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">
                Nuevo registro
            </h4>
        </div>
        <div class="modal-body">
            {{ Form::divError() }}
            <div class="form-group form-group-lg">
                {{ Form::label('p_nro_dni', 'N.° de DNI', ['class' => 'asterisk']) }}
                <div class="input-group input-group-lg">
                    {{ Form::text('p_nro_dni', null, ['placeholder' => 'N.° de DNI', 'class' => 'form-control', 'maxlength' => '255', 'data-mask' => '99999999', 'data-placeholder' => '']) }}
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary reniec" data-dni="p_nro_dni" data-state="0" title="Consultar DNI"><i class="fa fa-search"></i> Reniec</button>
                    </span>
                </div>
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('p_nombres', 'Nombres', ['class' => 'asterisk']) }}
                {{ Form::text('p_nombres', null, ['placeholder' => 'Nombres', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255', 'readonly' => 'readonly']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('p_apellido_paterno', 'Apellido paterno', ['class' => 'asterisk']) }}
                {{ Form::text('p_apellido_paterno', null, ['placeholder' => 'Apellido paterno', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255', 'readonly' => 'readonly']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('p_apellido_materno', 'Apellido materno') }}
                {{ Form::text('p_apellido_materno', null, ['placeholder' => 'Apellido materno', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255', 'readonly' => 'readonly']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('p_telefono', 'Teléfono celular', ['class' => 'asterisk']) }}
                {{ Form::text('p_telefono', null, ['placeholder' => 'Teléfono celular', 'class' => 'form-control', 'maxlength' => '255', 'data-mask' => '999999999', 'data-placeholder' => '']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('p_email', 'Correo electrónico', ['class' => 'asterisk']) }}
                {{ Form::text('p_email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control', 'maxlength' => '255']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('p_id_cargo', 'Cargo', ['class' => 'asterisk']) }}
                {{ Form::select('p_id_cargo', Arr::pluck($arr_cargo, 'descripcion', 'id_cargo'), null, ['placeholder' => '- Seleccione su Cargo -', 'class' => 'form-control']) }}
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
        $("#grabar").submit(function(e) {
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
                        grid.reload();
                        $("#contenedor").modal("hide");
                    }
                    $.unblockUI();
                },
                error: function(xhr, status) {
                    if (xhr.status === 422) {
                        $(self).errors(xhr.responseJSON.errors);
                    } else {
                        alert("Se ha producido un error");
                    }
                    $.unblockUI();
                }
            });
        });
    });
</script>