{{ Form::model($ugel, ['route' => ['ugel.grabar', $ugel->id_ugel], 'autocomplete' => 'off', 'files' => true, 'id' => 'editar']) }}
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
                {{ Form::label('id_dre_gre', 'DRE / GRE', ['class' => 'asterisk']) }}
                {{ Form::select('id_dre_gre', Arr::pluck($arr_dre_gre, 'descripcion', 'id_dre_gre'), null, ['placeholder' => '- Seleccione su DRE / GRE -', 'class' => 'form-control']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('descripcion', 'Descripción', ['class' => 'asterisk']) }}
                {{ Form::text('descripcion', null, ['placeholder' => 'Descripción', 'class' => 'form-control description', 'maxlength' => '255']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('flg_grupo_especial', 'Grupo especial') }}
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('flg_grupo_especial') }} Si
                    </label>
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
                        grid.reload({
                            page: 1
                        });
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