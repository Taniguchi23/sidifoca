@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Bienvenido</h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-horizontal">
                <fieldset>
                    <legend>Datos de usuario</legend>
                    <div class="form-group">
                        {{ Form::label(null, 'Usuario', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->username }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Contraseña', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">
                                <i class="fa fa-asterisk"></i>
                                <i class="fa fa-asterisk"></i>
                                <i class="fa fa-asterisk"></i>
                                <i class="fa fa-asterisk"></i>
                                <i class="fa fa-asterisk"></i>
                                <button type="button" data-url="{{ route('mi_perfil.editar_contrasena') }}" class="btn btn-link pop-up" title="Editar"><i class="fa fa-edit"></i></button>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Perfiles', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">
                                @forelse ($arr_usuario_perfil as $usuario_perfil)
                                <span class="badge">{{ $usuario_perfil->perfil->descripcion }}</span>
                                @empty
                                -
                                @endforelse
                            </p>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <fieldset>
                    <legend>Enlaces externos</legend>
                </fieldset>
                <div class="col-lg-3 col-md-4 dash-widget">
                    <div class="label-primary">
                        <button class="btn btn-primary btn-lg btn-block disabled" role="button">
                            <div class="fa fa-graduation-cap fa-3x"></div>
                            <div class="icon-label">Aula virtual</div>
                        </button> 
                        <a href="http://aula.edutalentos.pe/" target="_blank" class="btn btn-default btn-block">
                            Aula virtual
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-horizontal">
                <fieldset>
                    <legend>
                        Datos personales
                        <a href="{{ route('mi_perfil') }}" title="Editar"><i class="fa fa-pencil"></i></a>
                    </legend>
                    <div class="form-group">
                        {{ Form::label(null, 'Foto', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">
                                @empty ($usuario->url_fotografia)
                                <img src="{{ asset('images/imagen190x140.svg') }}" class="img-thumbnail miniatura" alt="...">
                                @else
                                <img src="{{ route('intranet.fotografia') }}" class="img-thumbnail miniatura" alt="...">
                                @endempty
                            </p>
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
                        {{ Form::label(null, 'Tipo de documento', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->tipo_documento->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Número de documento', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->nro_documento }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Género', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->genero->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Fecha de nacimiento', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $usuario->fecha_nacimiento }}</p>
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
                        {{ Form::label(null, 'Persona con discapacidad', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static"> {{ $usuario->flg_discapacidad ? 'SI' : 'NO' }}</p>
                        </div>
                    </div>
                    @if($usuario->flg_discapacidad)
                    <div class="form-group">
                        {{ Form::label(null, 'Carnet de Conadis', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static truncar">
                                @isset($usuario->url_carnet_conadis)
                                <a href="{{ route('intranet.carnet_conadis') }}"><i class="fa fa-download"></i> Carnet de Conadis</a>
                                @endisset
                            </p>
                        </div>
                    </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="col-md-6">
            @empty($contrato)
            <div class="form-horizontal">
                <fieldset>
                    <legend>Datos institucionales</legend>
                    <p>No hay contrato de trabajo registrado.</p>
                </fieldset>
            </div>
            @else
            <div class="form-horizontal">
                <fieldset>
                    <legend>
                        Datos institucionales
                        <a href="{{ route('mi_perfil.editar_contrato') }}" title="Editar"><i class="fa fa-pencil"></i></a>
                    </legend>
                    <div class="form-group">
                        {{ Form::label(null, 'Tipo de entidad', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $contrato->tipo_entidad->descripcion }}</p>
                        </div>
                    </div>
                    @isset ($contrato->dre_gre)
                    <div class="form-group">
                        {{ Form::label(null, 'DRE / GRE', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $contrato->dre_gre->descripcion }}</p>
                        </div>
                    </div>
                    @endisset
                    @isset ($contrato->ugel)
                    <div class="form-group">
                        {{ Form::label(null, 'UGEL', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $contrato->ugel->descripcion }}</p>
                        </div>
                    </div>
                    @endisset
                    @isset ($contrato->entidad_externa)
                    <div class="form-group">
                        {{ Form::label(null, 'Entidad Externa', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $contrato->entidad_externa->descripcion }}</p>
                        </div>
                    </div>
                    @endisset
                    <div class="form-group">
                        {{ Form::label(null, 'Área', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($contrato->area)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">{{ $contrato->area->descripcion }}</p>
                            @endempty
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Nivel del puesto', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $contrato->nivel_puesto->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Nombre del Puesto', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $contrato->puesto->descripcion }}</p>
                            <div>
                                @if ($contrato->flg_ejerce_cargo)
                                <i class="fa fa-check-square-o"></i> ¿Ejerce actualmente el cargo?
                                @else
                                <i class="fa fa-square-o"></i> ¿Ejerce actualmente el cargo?
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Régimen laboral', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            <p class="form-control-static">{{ $contrato->regimen_laboral->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Fecha de inicio del contrato', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($contrato->fecha_inicio)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">{{ $contrato->fecha_inicio }}</p>
                            @endempty
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Fecha de fin del contrato', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($contrato->fecha_fin)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">{{ $contrato->fecha_fin }}</p>
                            @endempty
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Contrato/Resolución/Orden de Servicio', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($contrato->url_documento)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">
                                <a href="{{ route('intranet.contrato', $contrato->id_contrato) }}" target="_blank"><i class="fa fa-download"></i> Contrato</a>
                            </p>
                            @endempty
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Último nivel educativo alcanzado', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($contrato->nivel_educativo)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">{{ $contrato->nivel_educativo->descripcion }}</p>
                            @endempty
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(null, 'Profesión', ['class' => 'control-label col-md-4']) }}
                        <div class="col-md-8">
                            @empty ($contrato->profesion)
                            <p class="form-control-static">-</p>
                            @else
                            <p class="form-control-static">{{ $contrato->profesion->descripcion }}</p>
                            @endempty
                        </div>
                    </div>
                </fieldset>
            </div>
            @endempty
        </div>
    </div>
</div>
@endsection