<?php


namespace App\Repositories\AulaVirtual\Database;

use App\Repositories\AulaVirtual\Contracts\CourseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DbCourseRepository implements CourseRepositoryInterface
{
    public function __construct()
    {
        $this->connection = DB::connection('chamilo');
    }
    public function listByYearAndCategory(): array
    {
        $sql = "
            SELECT
                YEAR(c.creation_date)               AS anio,
                COALESCE(cc.name, 'Sin categoría')  AS categoria,
                c.title                             AS curso,
                c.id                             AS id,
                c.code                              AS codigo_curso
            FROM course AS c
            LEFT JOIN course_category AS cc
                ON c.category_code = cc.code
            WHERE c.creation_date IS NOT NULL
            ORDER BY anio DESC, categoria, curso
        ";

        return $this->connection->select($sql);
    }

    public function listByCourse(?int $idCurso): array
    {
        $sql = "
                WITH alumnos AS (
                  SELECT u.id AS alumno_id,
                         CONCAT(u.firstname, ' ', u.lastname) AS alumno,
                         u.username
                  FROM course_rel_user cru
                  JOIN user u ON u.id = cru.user_id
                  WHERE cru.c_id = ?
                ),

                quiz_sin_intento AS (
                  SELECT
                    a.alumno_id,
                    a.alumno,
                    'quiz'                         AS actividad_tipo,
                    q.iid                          AS actividad_id,        -- iid interno del quiz
                    q.id                           AS actividad_legacy_id, -- id usado por track_e_exercises
                    q.title                        AS actividad_titulo,
                    ip.visibility,
                    ip.start_visible,
                    ip.end_visible,
                    NULL                           AS fecha_limite,
                    NULL                           AS ultimo_evento,
                    'Sin intento'                  AS estado_alumno
                  FROM c_quiz q
                  JOIN c_item_property ip
                       ON ip.c_id = q.c_id
                      AND ip.ref  = q.iid
                      AND ip.tool = 'quiz'
                  CROSS JOIN alumnos a
                  LEFT JOIN track_e_exercises tex
                       ON tex.c_id        = q.c_id
                      AND tex.exe_exo_id  = q.id       -- ojo: usa c_quiz.id
                      AND tex.exe_user_id = a.alumno_id
                  WHERE q.c_id = ?
                    AND tex.exe_id IS NULL
                ),

                encuesta_sin_respuesta AS (
                  SELECT
                    a.alumno_id,
                    a.alumno,
                    'survey'                      AS actividad_tipo,
                    s.iid                         AS actividad_id,        -- iid de la encuesta
                    s.survey_id                   AS actividad_legacy_id, -- identificador lógico de la encuesta
                    CAST(s.title AS CHAR(255))    AS actividad_titulo,
                    ip.visibility,
                    ip.start_visible,
                    ip.end_visible,
                    NULL                          AS fecha_limite,
                    NULL                          AS ultimo_evento,
                    'Sin respuesta'               AS estado_alumno
                  FROM c_survey s
                  JOIN c_item_property ip
                       ON ip.c_id = s.c_id
                      AND ip.ref  = s.iid
                      AND ip.tool = 'survey'
                  CROSS JOIN alumnos a
                  LEFT JOIN c_survey_answer sa
                       ON sa.c_id      = s.c_id
                      AND sa.survey_id = s.survey_id
                      AND sa.user      = a.username        -- match por username
                  WHERE s.c_id = ?
                    AND sa.iid IS NULL
                ),

                tarea_sin_entrega AS (
                  SELECT
                    a.alumno_id,
                    a.alumno,
                    'work'                        AS actividad_tipo,
                    sp.iid                        AS actividad_id,        -- iid del work para ip.ref
                    sp.id                         AS actividad_legacy_id, -- id lógico del work
                    sp.title                      AS actividad_titulo,
                    ip.visibility,
                    ip.start_visible,
                    ip.end_visible,
                    asp.expires_on                AS fecha_limite,        -- fechas del assignment
                    NULL                          AS ultimo_evento,
                    'Sin entrega'                 AS estado_alumno
                  FROM c_student_publication_assignment asp
                  JOIN c_student_publication sp
                       ON sp.c_id = asp.c_id
                      AND sp.id   = asp.publication_id
                  JOIN c_item_property ip
                       ON ip.c_id = sp.c_id
                      AND ip.ref  = sp.iid
                      AND ip.tool = 'work'
                  CROSS JOIN alumnos a
                  LEFT JOIN c_student_publication sub
                       ON sub.c_id     = sp.c_id
                      AND sub.parent_id= sp.id
                      AND sub.user_id  = a.alumno_id
                  WHERE asp.c_id = ?
                    AND sub.iid IS NULL
                ),

                foro_sin_post AS (
                  SELECT
                    a.alumno_id,
                    a.alumno,
                    'forum'                       AS actividad_tipo,
                    ft.iid                        AS actividad_id,        -- iid del hilo (para ip.ref)
                    ft.thread_id                  AS actividad_legacy_id, -- id del hilo
                    ft.thread_title               AS actividad_titulo,
                    ip.visibility,
                    ip.start_visible,
                    ip.end_visible,
                    NULL                          AS fecha_limite,
                    NULL                          AS ultimo_evento,
                    'Sin participación'           AS estado_alumno
                  FROM c_forum_thread ft
                  JOIN c_item_property ip
                       ON ip.c_id = ft.c_id
                      AND ip.ref  = ft.iid
                      AND ip.tool = 'forum'
                  CROSS JOIN alumnos a
                  LEFT JOIN c_forum_post fp
                       ON fp.c_id     = ft.c_id
                      AND fp.thread_id= ft.thread_id
                      AND fp.poster_id= a.alumno_id
                  WHERE ft.c_id = ?
                    AND fp.post_id IS NULL
                )

                SELECT
                  alumno_id,
                  alumno,
                  actividad_tipo,
                  actividad_id,
                  actividad_legacy_id,
                  actividad_titulo,
                  CASE
                    WHEN visibility = 1
                     AND (start_visible IS NULL OR NOW() >= start_visible)
                     AND (end_visible   IS NULL OR NOW() <= end_visible)
                      THEN 'Publicado'
                    WHEN visibility = 1
                     AND end_visible IS NOT NULL AND NOW() > end_visible
                      THEN 'Expirado'
                    WHEN visibility = 0 THEN 'Oculto'
                    ELSE 'No publicado'
                  END                                         AS estado_publicacion,
                  start_visible                               AS fecha_publicacion_desde,
                  end_visible                                 AS fecha_publicacion_hasta,
                  fecha_limite,
                  ultimo_evento,
                  estado_alumno
                FROM (
                  SELECT * FROM quiz_sin_intento
                  UNION ALL
                  SELECT * FROM encuesta_sin_respuesta
                  UNION ALL
                  SELECT * FROM tarea_sin_entrega
                  UNION ALL
                  SELECT * FROM foro_sin_post
                ) x
                ORDER BY alumno, actividad_tipo, actividad_titulo;
        ";

        return $this->connection->select($sql,[
            $idCurso, $idCurso, $idCurso, $idCurso, $idCurso
        ]);
    }

}
