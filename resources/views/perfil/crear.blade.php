@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Nuevo registro</h1>
    </div>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('perfil') }}"><strong>Gestión de Perfil</strong></a>
        </li>
        <li class="active">Nuevo registro</li>
    </ol>
    {{ Form::open(['route' => 'perfil.guardar', 'autocomplete' => 'off', 'id' => 'editar']) }}
    {{ Form::divError() }}
    <fieldset>
        <legend>Perfil</legend>
        <div class="form-horizontal">
            <div class="form-group form-group-lg">
                {{ Form::label('descripcion', 'Descripción', ['class' => 'control-label col-md-3 asterisk']) }}
                <div class="col-md-9">
                    {{ Form::text('descripcion', null, ['placeholder' => 'Descripción', 'class' => 'form-control description', 'maxlength' => '255']) }}
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Permisos</legend>
        <div class="row widget-header-div">
            @foreach($arr_modulo as $modulo)
            <div class="col-md-4 widget-header-item">
                <h4>{{ $modulo->descripcion }}</h4>
                <hr>
                @foreach($modulo->arr_permiso as $permiso)
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('id_permiso[]', $permiso->id_permiso) }} {{ $permiso->descripcion }}
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
                {{ Form::checkbox('id_menu[]', $parent->id_menu, null, ['class' => 'menu']) }} {{ $parent->descripcion }}
            </label>
        </h4>
        @foreach($parent->children as $menu)
        <div class="checkbox sub-menu">
            <label>
                {{ Form::checkbox('id_menu[]', $menu->id_menu, null, ['class' => 'sub-menu', 'data-parent' => $parent->id_menu]) }} {{ $menu->descripcion }}
            </label>
        </div>
        @endforeach
        @endforeach
    </fieldset>
    <button type="submit" class="btn btn-primary btn-block btn-lg">Guardar</button>
    {{ Form::close() }}
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    $(function() {
        $(".menu").change(function (e) {
            var $children = $(".sub-menu[data-parent='" + $(this).val() + "']");
            if ($(this).is(":checked")) {
                $children.prop("checked", true);
            } else {
                $children.prop("checked", false);
            }
        });
        $(".sub-menu").change(function (e) {
            var $parent = $(".menu[value='" + $(this).data("parent") + "']");
            if ($(this).is(":checked")) {
                $parent.prop("checked", true);
            } else {
                var $children = $(".sub-menu[data-parent='" + $(this).data("parent") + "']:checked");
                if ($children.length == 0) {
                    $parent.prop("checked", false);
                }
            }
        });
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
                        $.redirect("{{ route('perfil') }}");
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
@endsection