{{ Form::open(['route' => 'tema.guardar', 'autocomplete' => 'off', 'id' => 'editar']) }}
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
                {{ Form::label('id_categoria', 'Categoría', ['class' => 'asterisk']) }}
                {{ Form::select('id_categoria', Arr::pluck($arr_categoria, 'descripcion', 'id_categoria'), null, ['placeholder' => '- Seleccione su Categoría -', 'class' => 'form-control']) }}
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('descripcion', 'Descripción', ['class' => 'asterisk']) }}
                {{ Form::text('descripcion', null, ['placeholder' => 'Descripción', 'class' => 'form-control description', 'maxlength' => '255']) }}
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