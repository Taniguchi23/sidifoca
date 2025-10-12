<div class="fileinput fileinput-new input-group" data-provides="fileinput">
    <div class="form-control truncar" data-trigger="fileinput">
        <i class="glyphicon glyphicon-file fileinput-exists"></i><span class="fileinput-filename"></span>
    </div>
    <div class="input-group-addon btn btn-default btn-file">
        <span class="fileinput-new">Seleccione archivo</span><span class="fileinput-exists">Cambiar</span>
        {{ Form::file($name, $attributes) }}
    </div>
    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
</div>