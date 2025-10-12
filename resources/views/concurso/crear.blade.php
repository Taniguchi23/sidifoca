{{ Form::open(['route' => 'concurso.guardar', 'autocomplete' => 'off', 'files' => true, 'id' => 'editar']) }}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">
                Nuevo registro
            </h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>NOTA IMPORTANTE:</strong> 
                <br>
                Estimado usuario al registrar un nuevo concurso, los demas concursos pasan a inactivo.
            </div>
            {{ Form::divError() }}
            <div class="form-group form-group-lg">
                {{ Form::label('descripcion', 'Descripción', ['class' => 'asterisk']) }}
                {{ Form::text('descripcion', null, ['placeholder' => 'Descripción', 'class' => 'form-control description', 'maxlength' => '255']) }}
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-lg">
                        {{ Form::label('fecha_inicio', 'Fecha de Inicio', ['class' => 'asterisk']) }}
                        <div class="input-group date" id="g_fecha_inicio">
                            {{ Form::text('fecha_inicio', null, ['placeholder' => 'Fecha de Inicio', 'class' => 'form-control', 'maxlength' => '255']) }}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-lg">
                        {{ Form::label('fecha_termino', 'Fecha de Termino', ['class' => 'asterisk']) }}
                        <div class="input-group date" id="g_fecha_termino">
                            {{ Form::text('fecha_termino', null, ['placeholder' => 'Fecha de Termino', 'class' => 'form-control', 'maxlength' => '255']) }}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('url_bases_concurso', 'Bases del concurso') }}
                {{ Form::fileinput('url_bases_concurso', ['accept' => 'application/pdf, application/msword, application/vnd.oasis.opendocument.text']) }}
                <span class="text-primary">Documento formato PDF o Imagen | Peso máx. 2MB</span>
            </div>
            <div class="form-group form-group-lg">
                {{ Form::label('url_acta_modalidad_colectiva', 'Acta Modalidad Colectiva') }}
                {{ Form::fileinput('url_acta_modalidad_colectiva', ['accept' => 'application/pdf, application/msword, application/vnd.oasis.opendocument.text']) }}
                <span class="text-primary">Documento formato PDF o Imagen | Peso máx. 2MB</span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
            <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
{{ Form::close() }}

<script nonce="{{ request()->nonce }}">
    $(function() {
        $("#g_fecha_inicio").datetimepicker({
            locale: "es",
            format: 'DD/MM/YYYY'
        });
        $("#g_fecha_termino").datetimepicker({
            locale: "es",
            format: 'DD/MM/YYYY'
        });
        $("#editar").submit(function(e) {
            e.preventDefault();
            var self = this;
            $.ajax({
                url: $(self).attr("action"),
                data: new FormData(self),
                type: "POST",
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $.blockUI();
                },
                success: function(json) {
                    if (!json.success) {
                        $(self).errors(json.errors);
                    } else {
                        grid.reload({
                            page: 1
                        });
                        $("#toast").toast("Se guardó correctamente.");
                        $("#contenedor").modal("hide");
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