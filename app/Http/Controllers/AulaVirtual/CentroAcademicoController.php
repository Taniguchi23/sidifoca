<?php

namespace App\Http\Controllers\AulaVirtual;

use App\Exports\ActividadesCursoExport;
use App\Http\Controllers\Controller;
use App\Repositories\AulaVirtual\Contracts\CourseRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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

    public function cursos($id, CourseRepositoryInterface $courseRepository)
    {
        $rows = $courseRepository->listByYearAndCategory();
        $cursoActual = collect($rows)->firstWhere('id', (int) $id);
        $anioActual = $cursoActual->anio ?? null;
        $categoriaActual = $cursoActual->categoria ?? 'Sin definir';
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

        $data = [
            'id' => $id,
            'listas' => $listas,
            'anioActual' => $anioActual,
            'categoriaActual' => $categoriaActual,
            'cursoActual' => $cursoActual,
        ];

        return view('aula-virtual.centro-academico.curso', $data);
    }

    public function actividades(Request $req, CourseRepositoryInterface $repo)
    {
        $idCurso = (int) $req->route('id');

        $limit   = (int) $req->query('limit', 20);
        $offset  = (int) $req->query('offset', 0);
        $search  = trim((string) $req->query('search', ''));
        $fecha   = trim((string) $req->query('fecha', ''));

        // MULTI-SELECT
        $tipos   = (array) $req->query('tipo', []);     // viene de tipo[]
        $estados = (array) $req->query('estado', []);   // viene de estado[]

        // Validación blanca
        $tiposPermitidos   = ['quiz','survey','work','forum'];
        $estadosPermitidos = ['Publicado','No publicado','Expirado','Oculto'];

        $tipos   = array_values(array_intersect($tipos,   $tiposPermitidos));
        $estados = array_values(array_intersect($estados, $estadosPermitidos));

        // pásalos al repositorio (ajústalo para soportar arrays -> WHERE IN)
        [$rows, $total] = $repo->listByCourseServer(
            $idCurso,
            $limit,
            $offset,
            $search,
            $tipos,     // <--- ahora array
            $fecha,
            $estados    // <--- si tu firma lo requiere; si no, intercambia orden
        );

        return response()->json([
            'data'  => $rows,
            'total' => $total,
        ]);
    }


    public function export(Request $req, CourseRepositoryInterface $repo)
    {
        $idCurso = (int) $req->route('id');

        $search  = trim((string) $req->query('search', ''));
        $fecha   = trim((string) $req->query('fecha', ''));
        $tipos   = (array) $req->query('tipo', []);     // tipo[]
        $estados = (array) $req->query('estado', []);   // estado[]

        // mismas listas blancas que en el server-side
        $tiposPermitidos   = ['quiz','survey','work','forum'];
        $estadosPermitidos = ['Publicado','No publicado','Expirado','Oculto'];

        $tipos   = array_values(array_intersect($tipos,   $tiposPermitidos));
        $estados = array_values(array_intersect($estados, $estadosPermitidos));

        // trae TODO (sin paginar) con los filtros
        $rows = $repo->listByCourseAll($idCurso, $search, $tipos, $fecha, $estados);

        $fileName = 'actividades_curso_'.$idCurso.'_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new ActividadesCursoExport($rows), $fileName);
    }

}
