<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPRESENTANTE DE LA POSTULACIÓN</title>
</head>

<body>
    <center>
        <h2><u>REPRESENTANTE DE LA POSTULACIÓN</u></h2>
    </center>
    <p>El representante de la buena práctica, Director(a) {{ $postulacion->d_nombres }} {{ $postulacion->d_apellido_paterno }} {{ $postulacion->d_apellido_materno }}, declara formalmente que:</p>
    <ol>
        <li>Conoce las bases del concurso y acepta lo establecido en ellas y las decisiones del Jurado Calificador.</li>
        <li>Da fe de la veracidad de los documentos e información presentados en el concurso y se somete a las sanciones correspondientes (Texto Único Ordenado de la Ley N° 27444, Ley del Procedimiento Administrativo General, aprobado por Decreto Supremo N° 004-2019-JUS), en caso se determine la falsedad de algunos de ellos.</li>
        <li>Acredita que la Buena Práctica postulada data con un mínimo de seis (06) meses de implementación y que no ha sido ganadora de un reconocimiento o galardón similar a convocatorias anteriores de este concurso.</li>
        <li>Autoriza la sistematización y difusión de la(s) buenas(s) práctica(s) que resulte(n) ganadora(s) del Concurso de Buenas Prácticas de Gestión Educativa en las Direcciones o Gerencias Regionales de Educación y las Unidades de Gestión Educativa Local - 2020, así como la imagen de la entidad que representa, sin contraprestación alguna.</li>
        <li>Se compromete, en caso de resultar ganadora su propuesta, a participar junto con el equipo técnico de la buena práctica, en la Ceremonia de Reconocimiento organizada por el Ministerio de Educación, asumiendo los costos de traslado, alojamiento y alimentación de los mismos.</li>
        <li>Asegura no tener ningún proceso administrativo, penal o civil en curso, ni sanción disciplinaria a la fecha de inscripción.</li>
    </ol>
    <div style="text-align: center; margin-top: 100px;">
        <hr style="width: 300px;">
        <strong>{{ $postulacion->d_nombres }} {{ $postulacion->d_apellido_paterno }} {{ $postulacion->d_apellido_materno }}</strong>
        <br>
        @if($postulacion->id_tipo_postulacion == config('constants.tipo_postulacion.dre_gre'))
        Director(a) de la Dirección Regional de Educación de {{ $postulacion->dre_gre }}
        @else
        Director(a) de la Unidad de Gestión Educativa Local de {{ $postulacion->ugel }}
        @endif
        <br>
        <strong>DNI: {{ $postulacion->d_nro_dni }}</strong>
    </div>
</body>

</html>