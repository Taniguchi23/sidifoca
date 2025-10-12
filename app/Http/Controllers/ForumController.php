<?php

namespace App\Http\Controllers;

use App\Exports\ForumExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ForumController extends Controller
{
    protected $dre_gre;
    protected $ugel;

    public function __construct()
    {
        $this->dre_gre = config('constants.tipo_entidad.dre_gre');
        $this->ugel = config('constants.tipo_entidad.ugel');
    }

    public function index()
    {
        $courses =  $this->courses();
        return view('forum.index')->with('courses', $courses);
    }

    public function reporte(Request $request)
    {
        $params = $request->only('c_id');
        $users = $this->users($params);
        $forums = $this->forums($params);
        $users = $this->extra_field($users, $forums, $params);
        return view('forum.exportar')->with([
            'forums' => $forums,
            'users' => $users,
        ]);
    }

    public function exportar(Request $request)
    {
        $params = $request->only('c_id');
        $users = $this->users($params);
        $forums = $this->forums($params);
        $users = $this->extra_field($users, $forums, $params);
        $filename =  'foros' . Carbon::now()->format('d-m-Y') . '.xlsx';
        return Excel::download(new ForumExport($forums, $users), $filename);
    }

    public function extra_field($users, $forums, $params)
    {
        $rpta = [];
        $posts = $this->posts($params);
        foreach ($users as $user) {
            $item = [
                'DNI' => $user->official_code,
                'NOMBRE' => '',
                'APELLIDOS' => '',
                'SEXO' => '',
                'FECHA_NACIMIENTO' => '',
                'NOMBRE_IGED' => '',
                'CODIGO_IGED' => '',
                'REGION' => '',
                'CELULAR1' => '',
                'AREA' => '',
                'DATOS_PUESTO' => '',
                'PUESTO_HOMOLOGADO' => '',
                'GRUPO_O_AULA' => $user->name
            ];
            if ($user->official_code) {
                $arr_user = DB::select('call sp_usuario(:nro_documento)', ['nro_documento' => $user->official_code]);
                if ($arr_user) {
                    $user = $arr_user[0];
                    $item['DNI'] = $user->nro_documento;
                    $item['NOMBRE'] = $user->nombres;
                    $item['APELLIDOS'] = $this->fullname($user);
                    $item['SEXO'] = $user->genero->descripcion;
                    $item['FECHA_NACIMIENTO']= $user->fecha_nacimiento;
                    $item['CELULAR1'] = $user->telefono_celular;
                    $item['NOMBRE_IGED'] = $user->id_iged;
                    $item['CODIGO_IGED'] = $user->iged;
                    $item['REGION'] = $user->region;
                    $item['AREA'] = $user->area;
                    $item['DATOS_PUESTO'] = $user->puesto;
                    $item['PUESTO_HOMOLOGADO'] = $user->nivel_puesto;
                }
            }
            foreach ($forums as $forum) {
                $count = 0;
                foreach ($posts as $post) {
                    if ($post->poster_id == $user->user_id && $post->c_id == $forum->c_id) {
                        $count = $post->posts;
                        break;
                    }
                }
                $item[$forum->forum_title] = $count;
            }
            array_push($rpta, (object)$item);
        }
        return $rpta;
    }

    public function fullname($user)
    {
        $fullname = $user->apellido_paterno;
        if ($user->apellido_materno) {
            $fullname .= ' ' . $user->apellido_materno;
        }
        return $fullname;
    }

    public function posts(array $params)
    {
        $posts = DB::Connection('chamilo')->select('select 
        c_id, 
        poster_id, 
        forum_id,
        count(1) as posts
        from c_forum_post
        where c_id = :c_id
        group by c_id, poster_id, forum_id', $params);
        return $posts;
    }

    public function users(array $params)
    {
        $users = DB::Connection('chamilo')->select('select distinct
        c.c_id,
        u.user_id, 
        u.official_code, 
        u.firstname,
        u.lastname,
        i.name
        from user u
        inner join course_rel_user c on c.user_id = u.user_id
        inner join c_group_rel_user g on g.user_id = u.user_id and g.c_id = c.c_id
        left join c_group_info i on i.id = g.group_id
        where c.c_id = :c_id
        and coalesce(c.is_tutor, 0) = 0
        and c.status = 5
        order by u.firstname, u.lastname, i.name', $params);
        return $users;
    }

    public function courses()
    {
        $courses = DB::Connection('chamilo')->select('select id, title from course');
        return $courses;
    }

    public function forums(array $params)
    {
        $forums = DB::Connection('chamilo')->select('select 
            c_id, 
            forum_id, 
            forum_title 
            from c_forum_forum 
            where c_id = :c_id', $params);
        return $forums;
    }
}
