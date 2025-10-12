<table class="table table-bordered tabla">
    <thead>
        <tr>
            <th>DNI</th>
            <th>NOMBRE</th>
            <th>APELLIDOS</th>
            <th>SEXO</th>
            <th>FECHA_NACIMIENTO</th>
            <th>NOMBRE IGED</th>
            <th>CODIGO IGED</th>
            <th>REGION</th>
            <th>CELULAR1</th>
            <th>AREA</th>
            <th>DATOS_PUESTO</th>
            <th>PUESTO_HOMOLOGADO</th>
            <th>GRUPO O AULA</th>
            @foreach ($forums as $forum)
            <th>{{ $forum->forum_title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
        <tr>
            <td>{{ $user->DNI }}</td>
            <td>{{ $user->NOMBRE }}</td>
            <td>{{ $user->APELLIDOS }}</td>
            <td>{{ $user->SEXO }}</td>
            <td>{{ $user->FECHA_NACIMIENTO }}</td>
            <td>{{ $user->NOMBRE_IGED }}</td>
            <td>{{ $user->CODIGO_IGED }}</td>
            <td>{{ $user->REGION }}</td>
            <td>{{ $user->CELULAR1 }}</td>
            <td>{{ $user->AREA }}</td>
            <td>{{ $user->DATOS_PUESTO }}</td>
            <td>{{ $user->PUESTO_HOMOLOGADO }}</td>
            <td>{{ $user->GRUPO_O_AULA }}</td>
            @foreach ($forums as $forum)
            <th>{{ $user->{$forum->forum_title} }}</th>
            @endforeach
        </tr>
        @empty
        <tr>
            <td colspan="13">No se encontraron registros.</td>
        </tr>
        @endforelse
    </tbody>
</table>