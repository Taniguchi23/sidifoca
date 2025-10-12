@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Detalles registro</h1>
    </div>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('perfil') }}"><strong>Gestión de Perfil</strong></a>
        </li>
        <li class="active">Detalles registro</li>
    </ol>
    <fieldset>
        <legend>Perfil</legend>
        <div class="form-horizontal">
            <div class="form-group form-group-lg">
                {{ Form::label(null, 'Descripción', ['class' => 'control-label col-md-3']) }}
                <div class="col-md-9">
                    <p class="form-control-static">{{ $perfil->descripcion }}</p>
                </div>
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label(null, 'Estado', ['class' => 'control-label col-md-3']) }}
                <div class="col-md-9">
                    <p class="form-control-static">{{ $perfil->flg_estado ? "Activo" : "Inactivo" }}</p>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Permisos</legend>
        <div class="row">
            @foreach($arr_modulo as $modulo)
            <div class="col-md-4 widget-header-item">
                <h4>{{ $modulo->descripcion }}</h4>
                <hr>
                @foreach($modulo->arr_permiso as $permiso)
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('id_permiso[]', $permiso->id_permiso, $perfil->arr_perfil_permiso->contains('id_permiso', $permiso->id_permiso), ['disabled' => 'disabled']) }} {{ $permiso->descripcion }}
                    </label>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </fieldset>
    <fieldset>
        <legend>Menus</legend>
        @foreach($arr_menu as $parent)
        <h4>
            <label>
                {{ Form::checkbox('id_menu[]', $parent->id_menu, $perfil->arr_perfil_menu->contains('id_menu', $parent->id_menu), ['disabled' => 'disabled']) }} {{ $parent->descripcion }}
            </label>
        </h4>
        @foreach($parent->children as $menu)
        <div class="checkbox sub-menu">
            <label>
                {{ Form::checkbox('id_menu[]', $menu->id_menu, $perfil->arr_perfil_menu->contains('id_menu', $menu->id_menu), ['disabled' => 'disabled']) }} {{ $menu->descripcion }}
            </label>
        </div>
        @endforeach
        @endforeach
    </fieldset>
</div>
@endsection