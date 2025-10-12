<h3>Buen Día Estimado Postulante.</h3>

<p>La ficha de postulación con código {{ $postulacion->codigo }} han sido registrado correctamente, proceda con el siguiente paso <a href="{{ route('home') }}">(Paso 3: Adjuntar y enviar documentos)</a>.</p>

<h4>Nombre de la Buena Práctica</h4>
<p>{{ $postulacion->buena_practica }}</p>

<h4>Categoría de postulación</h4>
<p>{{ $postulacion->categoria->descripcion }}</p>

<h4>Tema</h4>
<p>{{ $postulacion->tema->descripcion }}</p>

<h4>Tiempo de implementación de la Buena Práctica</h4>
<p>{{ $postulacion->nro_meses }} meses / {{ $postulacion->nro_dias }} dias</p>

<p>
<b>Cordialmente</b>
<br>
<b>El equipo de DIFOCA</b>
</p>