<?php

namespace App\Http\Controllers\AulaVirtual;

use App\Http\Controllers\Controller;
use App\Repositories\AulaVirtual\Contracts\CourseRepositoryInterface;
use Illuminate\Http\Request;

class CentroAcademicoController extends Controller
{
    public function index(CourseRepositoryInterface  $courseRepository){
        $rows = $courseRepository->listByYearAndCategory();

        $collection = collect($rows)->map(function ($item) {
            $item->categoria = $item->categoria ?? 'Sin definir';
            return $item;
        });

        $listas = $collection
            ->groupBy(['anio', 'categoria'])
            ->map(function ($categories) {
                return $categories->map(function ($cursos) {
                    return $cursos->map(function ($curso) {
                        return [
                            'id' => $curso->id,
                            'curso' => $curso->curso,
                            'codigo_curso' => $curso->codigo_curso,
                        ];
                    })->values();
                });
            });
        return view('aula-virtual.centro-academico.index', compact('listas'));
    }

    public function actividades(Request $req, CourseRepositoryInterface  $courseRepository)
    {
        $idCurso = (int) $req->route('id');
        $limit   = (int) $req->query('limit', 20);
        $offset  = (int) $req->query('offset', 0);
        $search  = trim((string) $req->query('search', ''));
        $tipoRaw   = $req->query('tipo');
        $estadoRaw = $req->query('estado');
        $fecha   = trim((string) $req->query('fecha', ''));

        $tipo   = in_array($tipoRaw,   ['quiz','survey','work','forum'], true) ? $tipoRaw   : null;
        $estado = in_array($estadoRaw, ['Publicado','No publicado','Expirado','Oculto'], true) ? $estadoRaw : null;

        [$rows, $total] = $courseRepository->listByCourseServer($idCurso, $limit, $offset, $search,$tipo, $fecha);

        // Grid.js espera { data, total }
        return response()->json([
            'data'  => $rows,
            'total' => $total,
        ]);
    }

}
