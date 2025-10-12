@extends('intranet')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Menus</h1>
    </div>
    <div class="botonera">
        <button type="button" class="btn btn-primary btn-lg pop-up" data-url="{{ route('menu.crear') }}">Nuevo registro</button>
    </div>
    <div class="table-responsive">
        <div id="tree"></div>
    </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->nonce }}">
    $(function() {
        tree();
        $("#busqueda").submit(function(e) {
            e.preventDefault();
            tree();
        });
    });

    function tree() {
        $("#tree").html("");
        $.ajax({
            url: $("#busqueda").attr("action"),
            data: $("#busqueda").inputs(),
            beforeSend: function() {
                $.blockUI();
            },
            success: function(data) {
                var tree = $("#tree");
                $.each(data, function(index, parent) {
                    var menu = $('<ul class="list-unstyled ' + (parent.flg_estado ? '' : 'del') + '" title="' + (parent.flg_estado ? '' : 'Inactivo') + '"><i class="fa fa-folder-open-o"></i> ' + parent.descripcion + ' <button type="button" class="btn btn-primary btn-link pop-up" data-url="{{ route("menu") }}/editar/' + parent.id_menu + '" title="Editar"><i class="fa fa-pencil"></i></button></ul>');
                    $.each(parent.children, function(index, children) {
                        menu.append($('<li class="' + (children.flg_estado ? '' : 'del') + '" title="' + (children.flg_estado ? '' : 'Inactivo') + '" class="sub-menu"><i class="fa fa-chevron-right"></i> ' + children.descripcion + ' <button type="button" class="btn btn-primary btn-link pop-up" data-url="{{ route("menu") }}/editar/' + children.id_menu + '" title="Editar"><i class="fa fa-pencil"></i></button></li>'));
                    });
                    tree.append(menu);
                });
                $.unblockUI();
            },
            error: function() {
                alert("Se ha producido un error.");
                $.unblockUI();
            }
        });
    }
</script>
@endsection