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
                {{ Form::label(null, 'Descripción') }}
                <p class="form-control-static">{{ $concurso->descripcion }}</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label(null, 'Fecha de Inicio') }}
                        <p class="form-control-static">{{ $concurso->fecha_inicio }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label(null, 'Fecha de Termino') }}
                        <p class="form-control-static">{{ $concurso->fecha_termino }}</p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label(null, 'Bases del concurso') }}
                <p class="form-control-static">
                    @isset($concurso->url_bases_concurso)
                    <a href="{{ route('concurso.bases_concurso',[$concurso->id_concurso, $token]) }}" target="_blank"><i class="fa fa-download"></i> Descargar</a>
                    @endisset
                </p>
            </div>
            <div class="form-group">
                {{ Form::label(null, 'Acta Modalidad Colectiva') }}
                <p class="form-control-static">
                    @isset($concurso->url_acta_modalidad_colectiva)
                    <a href="{{ route('concurso.bpg_acta_acuerdos_colectiva',[$concurso->id_concurso, $token]) }}" target="_blank" class="link-download"><i class="fa fa-download"></i> Descargar</a>
                    @endisset
                </p>
            </div>
            <div class="form-group">
                {{ Form::label(null, 'Estado') }}
                <p class="form-control-static">{{ $concurso->flg_estado ? "Activo" : "Inactivo" }}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>