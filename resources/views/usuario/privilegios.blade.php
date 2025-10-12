<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">
                Editar privilegios
            </h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                {{ Form::label(null, 'Administrado') }}
                <p class="form-control-static">{{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }} {{ $usuario->nombres }}</p>
            </div>
            <table class="table table-bordered table-hover tabla">
                <thead>
                    <tr>
                        <th>Perfil</th>
                        <th class="text-center">Activar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($arr_perfil as $perfil)
                    <tr>
                        <td>{{ $perfil->descripcion }}</td>
                        <td class="text-center">
                            {{ Form::open(['route' => ['usuario.grabar_usuario_perfil', $usuario->id_usuario, $perfil->id_perfil], 'autocomplete' => 'off']) }}
                            {{ Form::checkbox('flg_estado', 1, $arr_usuario_perfil->contains('id_perfil', $perfil->id_perfil), ['class' => 'toggle']) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>

<script nonce="{{ request()->nonce }}">
    $(function() {
        $(".toggle").change(function(e) {
            $.ajax({
                url: $(this).closest("form").attr("action"),
                data: {
                    flg_estado: $(this).is(':checked') ? 1 : 0
                },
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        alert("Se ha producido un error");
                    }
                    $.unblockUI();
                },
                error: function() {
                    alert("Se ha producido un error");
                    $.unblockUI();
                }
            });
        });
    });
</script>