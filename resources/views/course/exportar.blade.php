<table class="table table-bordered tabla">
    <thead>
        <tr>
            <th>Consolidado</th>
            <th class="text-center" width="200">Fecha de creación</th>
            <th class="text-center" width="200">Tiempo de ejecución</th>
            <th class="text-center" width="200">Acción</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <a href="{{ route('course.exportar', ['filename' => $filename]) }}" target="_blank" title="Descargar">{{ $filename }}</a>
            </td>
            <td class="text-center">{{ date('d-m-Y') }}</td>
            <td class="text-center">{{ $execution_time | number_format(2) }} minutos</td>
            <td class="text-center">
                <a href="{{ route('course.exportar', ['filename' => $filename]) }}" target="_blank" class="btn btn-success" title="Descargar"><i class="fa fa-download"></i></a>
            </td>
        </tr>
    </tbody>
</table>