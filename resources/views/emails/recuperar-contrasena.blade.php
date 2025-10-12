<h3>Estimado Usuario: {{ $reset_contrasena->usuario }}</h3>

<p>A través del sistema de la DIFOCA ha solicitado el reenvió de su contraseña. Si no lo ha solicitado o ya ha recuperado su contraseña puede ignorar este correo.</p>

<p>Estos son sus datos de acceso:</p>

<p>
Nombre de usuario: {{ $reset_contrasena->email }}
</p>

<p>
Pulse en el siguiente enlace para regenerar su contraseña: <a href="{{ route('editar_contrasena', $reset_contrasena->id_reset_contrasena) }}">{{ route('home') }}</a>
</p>

<p>
<b>Cordialmente</b>
<br>
<b>El equipo de DIFOCA</b>
</p>