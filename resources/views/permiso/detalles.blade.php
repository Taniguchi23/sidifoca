<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">
                Detalles registro
            </h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                {{ Form::label(null, 'Modulo', ['class' => 'asterisk']) }}
                <p class="form-control-static">{{ $permiso->modulo->descripcion }}</p>
            </div>
            <div class="form-group">
                {{ Form::label(null, 'Descripción', ['class' => 'asterisk']) }}
                <p class="form-control-static">{{ $permiso->descripcion }}</p>
            </div>
            <div class="form-group">
                {{ Form::label(null, 'Estado') }}
                <p class="form-control-static">{{ $permiso->flg_estado ? "Activo" : "Inactivo" }}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>