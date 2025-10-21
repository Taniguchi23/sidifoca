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
        $rows = $courseRepository->listByCourse($idCurso);
        return response()->json(['data' => $rows]);
    }

}
