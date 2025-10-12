<h3>Bienvenido</h3>

<p>¡Hola, {{ $usuario->nombres }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}!</p>

<p>¡Gracias por registrarte! Aquí tienes la información de tu cuenta:</p>

<p>
Nombre de usuario: {{ $usuario->email }}
<br>
Contraseña: El que ingresó en el formulario de registro.
<br>
Si no recuerda su contraseña puede recuperar ingresando: <a href="{{ route('recuperar_contrasena') }}">¿Ha olvidado su contraseña?</a>
</p>

<p>
Para acceder al sistema ingresar a través del siguiente link: <a href="{{ route('home') }}">{{ route('home') }}</a>
</p>

<p>
<b>Cordialmente</b>
<br>
<b>El equipo de DIFOCA</b>
</p>