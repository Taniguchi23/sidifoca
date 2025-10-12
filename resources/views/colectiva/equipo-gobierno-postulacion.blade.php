<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EQUIPO TÉCNICO DEL GOBIERNO LOCAL DE LA POSTULACIÓN</title>
</head>

<body>
    <center>
        <h2>
            EQUIPO TÉCNICO DEL GOBIERNO LOCAL DE LA POSTULACIÓN
            <br>
            <small>
                Unidad de Gestión Educativa Local de {{ $postulacion->gobierno_local }}
            </small>
        </h2>
    </center>
    <p>Los integrantes del equipo técnico del gobierno local que postula la buena práctica declaran formalmente que:</p>
    <ol>
        <li>Conocen las bases del concurso y aceptan lo establecido en ellas y las decisiones del Jurado Calificador.</li>
        <li>Da fe de la veracidad de los documentos e información presentados en el concurso y se somete a las sanciones correspondientes (Texto Único Ordenado de la Ley N° 27444, Ley del Procedimiento Administrativo General, aprobado por Decreto Supremo N° 004-2019-JUS) en caso se determine la falsedad de algunos de ellos.</li>
        <li>Aseguran haber participado activamente en el proceso de implementación y sistematización de la misma.</li>
        <li>Asegura no tener ningún proceso administrativo, penal o civil en curso, ni sanción disciplinaria a la fecha de inscripción.</li>
    </ol>
    <table style="width: 100%;">
        @foreach($arr_equipo_postulacion as $equipo_postulacion)
        <tr>
            @foreach($equipo_postulacion as $participante)
            <td style="text-align:center">
                <hr style="width: 300px; height: 150px;">
                <br>
                {{ $participante->nombres }} {{ $participante->apellido_paterno }} {{ $participante->apellido_materno }}
                <br>
                DNI: {{ $participante->nro_dni }}
            </td>
            @endforeach
        </tr>
        @endforeach
    </table>
</body>

</html>