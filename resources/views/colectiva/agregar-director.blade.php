{{ Form::open(['route' => ['colectiva.guardar_director', $postulacion->id_postulacion], 'autocomplete' => 'off', 'id' => 'grabar']) }}
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
            <fieldset>
                <legend class="pt-0">Director</legend>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_id_dre_gre', 'DRE / GRE', ['class' => 'asterisk']) }}
                    {{ Form::select('d_id_dre_gre', Arr::pluck($arr_dre_gre, 'descripcion', 'id_dre_gre'), null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_id_ugel', 'UGEL', ['class' => 'asterisk']) }}
                    {{ Form::select('d_id_ugel', Arr::pluck($arr_postulacion_ugel, 'ugel', 'id_ugel'), null, ['placeholder' => '- Seleccione su UGEL -', 'class' => 'form-control']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_nro_dni', 'N.° de DNI', ['class' => 'asterisk']) }}
                    <div class="input-group input-group-lg">
                        {{ Form::text('d_nro_dni', null, ['placeholder' => 'N.° de DNI', 'class' => 'form-control', 'maxlength' => '255', 'data-mask' => '99999999', 'data-placeholder' => '']) }}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary reniec" data-dni="d_nro_dni" data-state="0" title="Consultar DNI"><i class="fa fa-search"></i> Reniec</button>
                        </span>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_nombres', 'Nombres', ['class' => 'asterisk']) }}
                    {{ Form::text('d_nombres', null, ['placeholder' => 'Nombres', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255', 'readonly' => 'readonly']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_apellido_paterno', 'Apellido paterno', ['class' => 'asterisk']) }}
                    {{ Form::text('d_apellido_paterno', null, ['placeholder' => 'Apellido paterno', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255', 'readonly' => 'readonly']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_apellido_materno', 'Apellido materno') }}
                    {{ Form::text('d_apellido_materno', null, ['placeholder' => 'Apellido materno', 'class' => 'form-control text-uppercase only-letters', 'maxlength' => '255', 'readonly' => 'readonly']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_telefono_celular', 'Teléfono celular', ['class' => 'asterisk']) }}
                    {{ Form::text('d_telefono_celular', null, ['placeholder' => 'Teléfono celular', 'class' => 'form-control', 'maxlength' => '255', 'data-mask' => '999999999', 'data-placeholder' => '']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_telefono_fijo', 'Teléfono fijo') }}
                    {{ Form::text('d_telefono_fijo', null, ['placeholder' => 'Teléfono fijo', 'class' => 'form-control', 'maxlength' => '255', 'data-mask' => '999999?9999', 'data-placeholder' => '']) }}
                </div>
                <div class="form-group form-group-lg">
                    {{ Form::label('d_email', 'Correo electrónico', ['class' => 'asterisk']) }}
                    {{ Form::text('d_email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control', 'maxlength' => '255']) }}
                </div>
            </fieldset>
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
                        $("#accordion").accordion({
                            url: "{{ route('colectiva.listar_director', $postulacion->id_postulacion) }}"
                        });
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