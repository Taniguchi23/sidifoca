{{ Form::model($menu, ['route' => ['menu.grabar', $menu->id_menu], 'autocomplete' => 'off', 'id' => 'editar']) }}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">
                Editar registro
            </h4>
        </div>
        <div class="modal-body">
            {{ Form::divError() }}
            <div class="form-group form-group-lg">
                {{ Form::label('p_id_menu', 'Padre') }}
                {{ Form::select("p_id_menu", Arr::pluck($arr_menu, 'descripcion', 'id_menu'), null, ['placeholder' => '- Seleccione su padre -', 'class' => 'form-control']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('descripcion', 'Menu', ['class' => 'asterisk']) }}
                {{ Form::text('descripcion', null, ['placeholder' => 'Descripción', 'class' => 'form-control description', 'maxlength' => '255']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('ruta', 'Ruta', ['class' => 'asterisk']) }}
                {{ Form::text('ruta', null, ['placeholder' => 'Ruta', 'class' => 'form-control description', 'maxlength' => '255']) }}
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-lg">
                        {{ Form::label('posicion', 'Posición', ['class' => 'asterisk']) }}
                        {{ Form::text('posicion', null, ['placeholder' => 'Posición', 'class' => 'form-control', 'maxlength' => '255', 'data-mask' => '9?999', 'data-placeholder' => '']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-lg">
                        {{ Form::label('icono', 'Icono') }}
                        {{ Form::text('icono', null, ['placeholder' => 'Icono', 'class' => 'form-control description', 'maxlength' => '255']) }}
                    </div>
                </div>
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label(null, 'Estado') }}
                <div class="radio">
                    <label class="radio-inline">
                        {{ Form::radio('flg_estado', 1, true) }} Activo
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('flg_estado', 0, false) }} Inactivo
                    </label>
                </div>
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
                data: $(self).inputs(),
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        $(self).errors(json.errors);
                    } else {
                        tree();
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