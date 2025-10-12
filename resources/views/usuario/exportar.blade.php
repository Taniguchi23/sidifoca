<table>
    <thead>
    <tr>
        <th>id</th>
        <th>username</th>
        <th>email</th>
        <th>tipo_documento</th>
        <th>apellido_paterno</th>
        <th>apellido_materno</th>
        <th>nombres</th>
        <th>nro_documento</th>
        <th>fecha_nacimiento</th>
        <th>telefono_fijo</th>
        <th>telefono_celular</th>
        <th>direccion</th>
        <th>flg_discapacidad</th>
        <th>tipo_entidad</th>
        <th>iged</th>
        <th>region</th>
        <th>area</th>
        <th>nivel_puesto</th>
        <th>puesto</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id_usuario }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <th>{{ $user->tipo_documento }}</th>
            <th>{{ $user->apellido_paterno }}</th>
            <th>{{ $user->apellido_materno }}</th>
            <th>{{ $user->nombres }}</th>
            <th>{{ $user->nro_documento }}</th>
            <th>{{ $user->fecha_nacimiento }}</th>
            <th>{{ $user->telefono_fijo }}</th>
            <th>{{ $user->telefono_celular }}</th>
            <th>{{ $user->direccion }}</th>
            <th>{{ $user->flg_discapacidad }}</th>
            <th>{{ $user->tipo_entidad }}</th>
            <th>{{ $user->iged }}</th>
            <th>{{ $user->region }}</th>
            <th>{{ $user->area }}</th>
            <th>{{ $user->nivel_puesto }}</th>
            <th>{{ $user->puesto }}</th>
        </tr>
    @endforeach
    </tbody>
</table>