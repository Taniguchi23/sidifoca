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
              SELECT
                u.id AS alumno_id,
                CONCAT(u.firstname, ' ', u.lastname) AS alumno,
                u.username,
                u.official_code AS alumno_codigo,
                u.email,
                u.registration_date
              FROM course_rel_user cru
              JOIN `user` u ON u.id = cru.user_id
              WHERE cru.c_id = ?
            ),

            quiz_sin_intento AS (
              SELECT
                a.alumno_id,
                a.alumno,
                a.alumno_codigo,
                a.username,
                'quiz'                         AS actividad_tipo,
                q.iid                          AS actividad_id,
                q.id                           AS actividad_legacy_id,
                q.title                        AS actividad_titulo,
                ip.visibility,
                ip.start_visible,
                ip.end_visible,
                ip.insert_date                 AS fecha_creacion_recurso,
                ip.lastedit_date               AS ultima_modificacion,
                ip.insert_user_id              AS creado_por_id,
                CONCAT(u_creador.firstname, ' ', u_creador.lastname) AS creador_nombre,
                NULL                           AS fecha_limite,
                NULL                           AS ultimo_evento,
                'Sin intento'                  AS estado_alumno
              FROM c_quiz q
              JOIN c_item_property ip
                   ON ip.c_id = q.c_id
                  AND ip.ref  = q.iid
                  AND ip.tool = 'quiz'
              LEFT JOIN `user` u_creador
                   ON u_creador.id = ip.insert_user_id
              CROSS JOIN alumnos a
              LEFT JOIN track_e_exercises tex
                   ON tex.c_id        = q.c_id
                  AND tex.exe_exo_id  = q.id
                  AND tex.exe_user_id = a.alumno_id
              WHERE q.c_id = ?
                AND tex.exe_id IS NULL
            ),

            encuesta_sin_respuesta AS (
              SELECT
                a.alumno_id,
                a.alumno,
                a.alumno_codigo,
                a.username,
                'survey'                      AS actividad_tipo,
                s.iid                         AS actividad_id,
                s.survey_id                   AS actividad_legacy_id,
                CAST(s.title AS CHAR(255))    AS actividad_titulo,
                ip.visibility,
                ip.start_visible,
                ip.end_visible,
                ip.insert_date                AS fecha_creacion_recurso,
                ip.lastedit_date              AS ultima_modificacion,
                ip.insert_user_id             AS creado_por_id,
                CONCAT(u_creador.firstname, ' ', u_creador.lastname) AS creador_nombre,
                NULL                          AS fecha_limite,
                NULL                          AS ultimo_evento,
                'Sin respuesta'               AS estado_alumno
              FROM c_survey s
              JOIN c_item_property ip
                   ON ip.c_id = s.c_id
                  AND ip.ref  = s.iid
                  AND ip.tool = 'survey'
              LEFT JOIN `user` u_creador
                   ON u_creador.id = ip.insert_user_id
              CROSS JOIN alumnos a
              LEFT JOIN c_survey_answer sa
                   ON sa.c_id      = s.c_id
                  AND sa.survey_id = s.survey_id
                  AND sa.`user`    = a.username
              WHERE s.c_id = ?
                AND sa.iid IS NULL
            ),

            tarea_sin_entrega AS (
              SELECT
                a.alumno_id,
                a.alumno,
                a.alumno_codigo,
                a.username,
                'work'                        AS actividad_tipo,
                sp.iid                        AS actividad_id,
                sp.id                         AS actividad_legacy_id,
                sp.title                      AS actividad_titulo,
                ip.visibility,
                ip.start_visible,
                ip.end_visible,
                ip.insert_date                AS fecha_creacion_recurso,
                ip.lastedit_date              AS ultima_modificacion,
                ip.insert_user_id             AS creado_por_id,
                CONCAT(u_creador.firstname, ' ', u_creador.lastname) AS creador_nombre,
                asp.expires_on                AS fecha_limite,
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
              LEFT JOIN `user` u_creador
                   ON u_creador.id = ip.insert_user_id
              CROSS JOIN alumnos a
              LEFT JOIN c_student_publication sub
                   ON sub.c_id      = sp.c_id
                  AND sub.parent_id = sp.id
                  AND sub.user_id   = a.alumno_id
              WHERE asp.c_id = ?
                AND sub.iid IS NULL
            ),

            foro_sin_post AS (
              SELECT
                a.alumno_id,
                a.alumno,
                a.alumno_codigo,
                a.username,
                'forum'                       AS actividad_tipo,
                ft.iid                        AS actividad_id,
                ft.thread_id                  AS actividad_legacy_id,
                ft.thread_title               AS actividad_titulo,
                ip.visibility,
                ip.start_visible,
                ip.end_visible,
                ip.insert_date                AS fecha_creacion_recurso,
                ip.lastedit_date              AS ultima_modificacion,
                ip.insert_user_id             AS creado_por_id,
                CONCAT(u_creador.firstname, ' ', u_creador.lastname) AS creador_nombre,
                NULL                          AS fecha_limite,
                NULL                          AS ultimo_evento,
                'Sin participación'           AS estado_alumno
              FROM c_forum_thread ft
              JOIN c_item_property ip
                   ON ip.c_id = ft.c_id
                  AND ip.ref  = ft.iid
                  AND ip.tool = 'forum'
              LEFT JOIN `user` u_creador
                   ON u_creador.id = ip.insert_user_id
              CROSS JOIN alumnos a
              LEFT JOIN c_forum_post fp
                   ON fp.c_id      = ft.c_id
                  AND fp.thread_id = ft.thread_id
                  AND fp.poster_id = a.alumno_id
              WHERE ft.c_id = ?
                AND fp.post_id IS NULL
            )

            SELECT
              alumno_id,
              alumno,
              alumno_codigo,
              username,
              actividad_tipo,
              actividad_id,
              actividad_legacy_id,
              actividad_titulo,
              creador_nombre,
              fecha_creacion_recurso,
              ultima_modificacion,
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
              END AS estado_publicacion,
              start_visible   AS fecha_publicacion_desde,
              end_visible     AS fecha_publicacion_hasta,
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
            ORDER BY alumno, actividad_tipo, actividad_titulo";

        return $this->connection->select($sql,[
            $idCurso, $idCurso, $idCurso, $idCurso, $idCurso
        ]);
    }

    public function listByCourseServer(
        int $idCurso,
        int $limit = 20,
        int $offset = 0,
        ?string $search = '',
        ?string $tipo = null,
        ?string $fecha = null
    ): array {
        // 🔎 Search
        $search = trim((string) $search);
        $hasSearch = $search !== '';
        $like = "%{$search}%";

        // === SQL base (CTE + UNION) ===
        $sqlBase = "
        WITH alumnos AS (
          SELECT
            u.id AS alumno_id,
            CONCAT(u.firstname, ' ', u.lastname) AS alumno,
            u.username,
            u.official_code AS alumno_codigo,
            u.email,
            u.registration_date
          FROM course_rel_user cru
          JOIN `user` u ON u.id = cru.user_id
          WHERE cru.c_id = ?
        ),

        quiz_sin_intento AS (
          SELECT
            a.alumno_id,
            a.alumno,
            a.alumno_codigo,
            a.username,
            'quiz'                         AS actividad_tipo,
            q.iid                          AS actividad_id,
            q.id                           AS actividad_legacy_id,
            q.title                        AS actividad_titulo,
            ip.visibility,
            ip.start_visible,
            ip.end_visible,
            ip.insert_date                 AS fecha_creacion_recurso,
            ip.lastedit_date               AS ultima_modificacion,
            ip.insert_user_id              AS creado_por_id,
            CONCAT(u_creador.firstname, ' ', u_creador.lastname) AS creador_nombre,
            NULL                           AS fecha_limite,
            NULL                           AS ultimo_evento,
            'Sin intento'                  AS estado_alumno
          FROM c_quiz q
          JOIN c_item_property ip
               ON ip.c_id = q.c_id
              AND ip.ref  = q.iid
              AND ip.tool = 'quiz'
          LEFT JOIN `user` u_creador
               ON u_creador.id = ip.insert_user_id
          CROSS JOIN alumnos a
          LEFT JOIN track_e_exercises tex
               ON tex.c_id        = q.c_id
              AND tex.exe_exo_id  = q.id
              AND tex.exe_user_id = a.alumno_id
          WHERE q.c_id = ?
            AND tex.exe_id IS NULL
        ),

        encuesta_sin_respuesta AS (
          SELECT
            a.alumno_id,
            a.alumno,
            a.alumno_codigo,
            a.username,
            'survey'                      AS actividad_tipo,
            s.iid                         AS actividad_id,
            s.survey_id                   AS actividad_legacy_id,
            CAST(s.title AS CHAR(255))    AS actividad_titulo,
            ip.visibility,
            ip.start_visible,
            ip.end_visible,
            ip.insert_date                AS fecha_creacion_recurso,
            ip.lastedit_date              AS ultima_modificacion,
            ip.insert_user_id             AS creado_por_id,
            CONCAT(u_creador.firstname, ' ', u_creador.lastname) AS creador_nombre,
            NULL                          AS fecha_limite,
            NULL                          AS ultimo_evento,
            'Sin respuesta'               AS estado_alumno
          FROM c_survey s
          JOIN c_item_property ip
               ON ip.c_id = s.c_id
              AND ip.ref  = s.iid
              AND ip.tool = 'survey'
          LEFT JOIN `user` u_creador
               ON u_creador.id = ip.insert_user_id
          CROSS JOIN alumnos a
          LEFT JOIN c_survey_answer sa
               ON sa.c_id      = s.c_id
              AND sa.survey_id = s.survey_id
              AND sa.`user`    = a.username
          WHERE s.c_id = ?
            AND sa.iid IS NULL
        ),

        tarea_sin_entrega AS (
          SELECT
            a.alumno_id,
            a.alumno,
            a.alumno_codigo,
            a.username,
            'work'                        AS actividad_tipo,
            sp.iid                        AS actividad_id,
            sp.id                         AS actividad_legacy_id,
            sp.title                      AS actividad_titulo,
            ip.visibility,
            ip.start_visible,
            ip.end_visible,
            ip.insert_date                AS fecha_creacion_recurso,
            ip.lastedit_date              AS ultima_modificacion,
            ip.insert_user_id             AS creado_por_id,
            CONCAT(u_creador.firstname, ' ', u_creador.lastname) AS creador_nombre,
            asp.expires_on                AS fecha_limite,
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
          LEFT JOIN `user` u_creador
               ON u_creador.id = ip.insert_user_id
          CROSS JOIN alumnos a
          LEFT JOIN c_student_publication sub
               ON sub.c_id      = sp.c_id
              AND sub.parent_id = sp.id
              AND sub.user_id   = a.alumno_id
          WHERE asp.c_id = ?
            AND sub.iid IS NULL
        ),

        foro_sin_post AS (
          SELECT
            a.alumno_id,
            a.alumno,
            a.alumno_codigo,
            a.username,
            'forum'                       AS actividad_tipo,
            ft.iid                        AS actividad_id,
            ft.thread_id                  AS actividad_legacy_id,
            ft.thread_title               AS actividad_titulo,
            ip.visibility,
            ip.start_visible,
            ip.end_visible,
            ip.insert_date                AS fecha_creacion_recurso,
            ip.lastedit_date              AS ultima_modificacion,
            ip.insert_user_id             AS creado_por_id,
            CONCAT(u_creador.firstname, ' ', u_creador.lastname) AS creador_nombre,
            NULL                          AS fecha_limite,
            NULL                          AS ultimo_evento,
            'Sin participación'           AS estado_alumno
          FROM c_forum_thread ft
          JOIN c_item_property ip
               ON ip.c_id = ft.c_id
              AND ip.ref  = ft.iid
              AND ip.tool = 'forum'
          LEFT JOIN `user` u_creador
               ON u_creador.id = ip.insert_user_id
          CROSS JOIN alumnos a
          LEFT JOIN c_forum_post fp
               ON fp.c_id      = ft.c_id
              AND fp.thread_id = ft.thread_id
              AND fp.poster_id = a.alumno_id
          WHERE ft.c_id = ?
            AND fp.post_id IS NULL
        )

        SELECT
          alumno_id,
          alumno,
          alumno_codigo,
          username,
          actividad_tipo,
          actividad_id,
          actividad_legacy_id,
          actividad_titulo,
          creador_nombre,
          fecha_creacion_recurso,
          ultima_modificacion,
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
          END AS estado_publicacion,
          start_visible   AS fecha_publicacion_desde,
          end_visible     AS fecha_publicacion_hasta,
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
    ";

        // ===== WHERE dinámico sobre x =====
        $whereSql = " WHERE 1=1 ";
        $whereBindings = [];

        if ($hasSearch) {
            $whereSql .= " AND (x.alumno LIKE ? OR x.username LIKE ? OR x.actividad_titulo LIKE ? OR x.actividad_tipo LIKE ?) ";
            array_push($whereBindings, $like, $like, $like, $like);
        }
        if (!empty($tipo)) {
            $whereSql .= " AND x.actividad_tipo = ? ";
            $whereBindings[] = $tipo;
        }

        if (!empty($fecha)) {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                // día exacto: >= 'Y-m-d 00:00:00' AND < 'Y-m-d' + 1 día
                $whereSql .= " AND x.fecha_creacion_recurso >= ? AND x.fecha_creacion_recurso < DATE_ADD(?, INTERVAL 1 DAY) ";
                $whereBindings[] = $fecha . ' 00:00:00';
                $whereBindings[] = $fecha . ' 00:00:00';
            } elseif (preg_match('/^(\d{4}-\d{2}-\d{2})\.\.(\d{4}-\d{2}-\d{2})$/', $fecha, $m)) {
                $desde = $m[1];
                $hasta = $m[2];
                if ($desde <= $hasta) {
                    $whereSql .= " AND x.fecha_creacion_recurso >= ? AND x.fecha_creacion_recurso < DATE_ADD(?, INTERVAL 1 DAY) ";
                    $whereBindings[] = $desde . ' 00:00:00';
                    $whereBindings[] = $hasta . ' 00:00:00';
                }
            }
        }

        $orderBy = " ORDER BY x.alumno, x.actividad_tipo, x.actividad_titulo ";

        // Bindings de la parte base (5 veces idCurso por las 5 CTEs)
        $baseBindings = [$idCurso, $idCurso, $idCurso, $idCurso, $idCurso];

        // ---------- TOTAL ----------
        $sqlTotal = "SELECT COUNT(*) AS total FROM ( {$sqlBase} ) x {$whereSql}";
        $bindingsTotal = array_merge($baseBindings, $whereBindings);

        $totalRow = $this->connection->selectOne($sqlTotal, $bindingsTotal);
        $total = (int) ($totalRow->total ?? 0);

        // ---------- DATA (paginado) ----------
        $sqlData = $sqlBase . $whereSql . $orderBy . " LIMIT ? OFFSET ? ";
        $bindingsData = array_merge($baseBindings, $whereBindings, [(int)$limit, (int)$offset]);

        $rows = $this->connection->select($sqlData, $bindingsData);

        return [$rows, $total];
    }

}
