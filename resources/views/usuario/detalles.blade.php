@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Ficha de Administrado</h1>
    </div>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('usuario') }}"><strong>Gestión de Administrados</strong></a>
        </li>
        <li class="active">Ficha de Administrado</li>
    </ol>
    <fieldset>
        <legend>
            Datos personales
            @show ('editar_usuario')
            <a href="{{ route('usuario.editar', $usuario->id_usuario) }}" title="Editar"><i class="fa fa-pencil"></i></a>
            @endshow
        </legend>
        <div class="row">
            <div class="col-md-3">
                <p>
                    @empty($usuario->url_fotografia)
                    <img src="{{ asset('images/imagen190x140.svg') }}" alt="" class="img-thumbnail">
                    @else
                    <img src="{{ route('usuario.fotografia', $usuario->id_usuario) }}" alt="" class="img-thumbnail">
                    @endempty
                </p>
                @if ($usuario->flg_discapacidad)
                    @isset($usuario->url_carnet_conadis)
                    <a href="{{ route('usuario.carnet_conadis', $usuario->id_usuario) }}" class="btn btn-primary btn-block"><i class="fa fa-download"></i> Carnet de Conadis</a>
                    @endisset
                @endif
            </div>
            <div class="col-md-9">
                <div class="form-horizontal">
                    <div class="form-group">
                        {{ Form::label(null, 'Documento de Identidad', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->tipo_documento->descripcion }} {{ $usuario->nro_documento }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Nombre Completo', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">
                                {{ $usuario->nombres }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Fecha de nacimiento', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->fecha_nacimiento }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Dirección', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($usuario->direccion)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">{{ $usuario->direccion }}</p>
                            @endempty
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Género', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->id_genero == 1 ? 'MASCULINO' : 'FEMENINO' }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Teléfono celular', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($usuario->telefono_celular)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">{{ $usuario->telefono_celular }}</p>
                            @endempty
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Teléfono fijo', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($usuario->telefono_fijo)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">{{ $usuario->telefono_fijo }}</p>
                            @endempty
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Correo electrónico', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->email }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Persona con discapacidad', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->flg_discapacidad ? 'SI' : 'NO' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Datos institucionales</legend>
        <div class="panel-group" id="accordion">
            @forelse ($usuario->arr_contrato as $contrato)
            <div class="panel panel-{{ $contrato->flg_estado ? 'primary' : 'danger' }}">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        @if($contrato->flg_estado)
                        @show ('editar_usuario')
                        <a href="{{ route('usuario.editar_contrato', $contrato->id_contrato) }}" class="pull-right" title="Editar"><i class="fa fa-pencil"></i></a>
                        @endshow
                        @endif
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $contrato->id_contrato }}">
                            @if($contrato->flg_estado)
                            Vigente: {{ $contrato->fecha_inicio }} - {{ $contrato->fecha_fin }}
                            @else
                            Histórico: {{ $contrato->fecha_inicio }} - {{ $contrato->fecha_fin }}
                            @endif
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse {{ $contrato->flg_estado ? 'in' : '' }}" id="collapse-{{ $contrato->id_contrato }}">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Tipo de entidad') }}
                                    <p class="form-control-static">{{ $contrato->tipo_entidad->descripcion }}</p>
                                </div>
                            </div>
                            @isset ($contrato->dre_gre)
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'DRE / GRE') }}
                                    <p class="form-control-static">{{ $contrato->dre_gre->descripcion }}</p>
                                </div>
                            </div>
                            @endisset
                            @isset ($contrato->ugel)
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'UGEL') }}
                                    <p class="form-control-static">{{ $contrato->ugel->descripcion }}</p>
                                </div>
                            </div>
                            @endisset
                            @isset ($contrato->entidad_externa)
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Entidad Externa') }}
                                    <p class="form-control-static">{{ $contrato->entidad_externa->descripcion }}</p>
                                </div>
                            </div>
                            @endisset
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Área en la que labora') }}
                                    @empty ($contrato->area)
                                    <p class="form-control-static">-</p>
                                    @else
                                    <p class="form-control-static">{{ $contrato->area->descripcion }}</p>
                                    @endempty
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Nivel del puesto') }}
                                    <p class="form-control-static">{{ $contrato->nivel_puesto->descripcion }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Nombre del puesto') }}
                                    <p class="form-control-static">{{ $contrato->puesto->descripcion }}</p>
                                    <div class="help-block">
                                        @if ($contrato->flg_ejerce_cargo)
                                        <i class="fa fa-check-square-o"></i> ¿Ejerce actualmente el cargo?
                                        @else
                                        <i class="fa fa-square-o"></i> ¿Ejerce actualmente el cargo?
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Régimen laboral') }}
                                    <p class="form-control-static">{{ $contrato->regimen_laboral->descripcion }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Fecha de inicio del contrato') }}
                                    @empty ($contrato->fecha_inicio)
                                    <p class="form-control-static">-</p>
                                    @else
                                    <p class="form-control-static">{{ $contrato->fecha_inicio }}</p>
                                    @endempty
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Fecha de fin del contrato') }}
                                    @empty ($contrato->fecha_fin)
                                    <p class="form-control-static">-</p>
                                    @else
                                    <p class="form-control-static">{{ $contrato->fecha_fin }}</p>
                                    @endempty
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Contrato/Resolución/Orden de Servicio') }}
                                    @empty ($contrato->url_documento)
                                    <p class="form-control-static">-</p>
                                    @else
                                    <p class="form-control-static">
                                        <a href="{{ route('usuario.contrato', $contrato->id_contrato) }}" target="_blank"><i class="fa fa-download"></i> Contrato</a>
                                    </p>
                                    @endempty
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Último nivel educativo alcanzado') }}
                                    @empty ($contrato->nivel_educativo)
                                    <p class="form-control-static">-</p>
                                    @else
                                    <p class="form-control-static">{{ $contrato->nivel_educativo->descripcion }}</p>
                                    @endempty
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label(null, 'Profesión') }}
                                    @empty ($contrato->profesion)
                                    <p class="form-control-static">-</p>
                                    @else
                                    <p class="form-control-static">{{ $contrato->profesion->descripcion }}</p>
                                    @endempty
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p>No hay contrato de trabajo</p>
            @endforelse
        </div>
    </fieldset>
</div>
@endsection