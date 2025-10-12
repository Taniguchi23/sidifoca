@foreach($arr_director as $director)
<div class="panel panel-primary">
    <div class="panel-heading" id="heading-{{ $director->id_director }}">
        <h4 class="panel-title">
            <a href="#collapse-{{ $director->id_director }}" data-toggle="collapse" data-parent="#accordion" data-key="{{ $director->id_director }}" class="open">
                Director: {{ $director->nombres }} {{ $director->apellido_paterno }} {{ $director->apellido_materno }}, N.° de DNI. {{ $director->nro_dni }}
            </a>
            <a href="javascript:void(0)" data-key="{{ $director->id_director }}" class="trash pull-right" title="Eliminar"><i class="fa fa-trash"></i></a>
        </h4>
    </div>
    <div class="panel-collapse collapse" id="collapse-{{ $director->id_director }}">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <h3>DRE / GRE</h3>
                    <p>{{ $director->dre_gre }}</p>
                    <h3>UGEL</h3>
                    <p>{{ $director->ugel }}</p>
                </div>
                <div class="col-md-6">
                    <h3>
                        Participantes <span class="small">(min: 1 / max: 4)</span>
                        @if(count($director->arr_equipo_postulacion) < 4) 
                        <button type="button" data-key="{{ $director->id_director }}" class="btn btn-link pull-right add">[ Agregar participante ]</button>
                        @endif
                    </h3>
                    <ul class="participantes">
                        @foreach($director->arr_equipo_postulacion as $equipo_postulacion)
                        <li><span title="N.° de DNI">{{ $equipo_postulacion->nro_dni }}</span> - {{ $equipo_postulacion->nombres }} {{ $equipo_postulacion->apellido_paterno }} {{ $equipo_postulacion->apellido_materno }} <a href="javascript:void(0)" data-key="{{ $equipo_postulacion->id_equipo_postulacion }}" class="btn-trash text-danger pull-right" title="Eliminar"><i class="fa fa-trash-o"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach