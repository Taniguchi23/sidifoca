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
                {{ Form::label(null, 'DRE / GRE') }}
                <p class="form-control-static">{{ $ugel->dre_gre->descripcion }}</p>
            </div>
            <div class="form-group">
                {{ Form::label(null, 'Descripción') }}
                <p class="form-control-static">{{ $ugel->descripcion }}</p>
            </div>
            <div class="form-group">
                {{ Form::label(null, 'Grupo especial') }}
                <p class="form-control-static">{{ $ugel->flg_grupo_especial ? "Si" : "No" }}</p>
            </div>
            <div class="form-group">
                {{ Form::label(null, 'Estado') }}
                <p class="form-control-static">{{ $ugel->flg_estado ? "Activo" : "Inactivo" }}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>