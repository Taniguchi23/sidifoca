<h3>Bienvenido</h3>

<p>¡Hola, {{ $usuario->nombres }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}!, el equipo de DIFOCA te ha registrado en el sistema Edutalentos.</p>

<p>Aquí tienes la información de tu cuenta:</p>

<p>
Nombre de usuario: {{ $usuario->email }}
<br>
Contraseña: {{ $random }}
</p>

<p>
Para acceder al sistema ingresar a través de este link: <a href="{{ route('home') }}">{{ route('home') }}</a>
</p>

<p>
<b>Cordialmente</b>
<br>
<b>El equipo de DIFOCA</b>
</p>