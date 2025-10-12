<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionAdmision;
use App\Repositories\CategoriaRepository;
use App\Repositories\ConcursoRepository;
use App\Repositories\ModalidadRepository;
use App\Repositories\PostulacionRepository;
use App\Repositories\TemaRepository;
use App\Repositories\TipoPostulacionRepository;
use App\Services\AdmisionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostulacionController extends Controller
{
    protected $postulacion;
    protected $concurso;
    protected $modalidad;
    protected $tipoPostulacion;
    protected $categoria;
    protected $tema;
    protected $admision;

    public function __construct(
        PostulacionRepository $postulacion,
        ConcursoRepository $concurso,
        ModalidadRepository $modalidad,
        TipoPostulacionRepository $tipoPostulacion,
        CategoriaRepository $categoria,
        TemaRepository $tema,
        AdmisionService $admision
    ) {
        $this->postulacion = $postulacion;
        $this->concurso = $concurso;
        $this->modalidad = $modalidad;
        $this->tipoPostulacion = $tipoPostulacion;
        $this->categoria = $categoria;
        $this->tema = $tema;
        $this->admision = $admision;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->postulacion->paginar($request->get('limit'), $request->only([
                'id_concurso',
                'id_modalidad',
                'id_tipo_postulacion',
                'id_categoria',
                'id_tema',
                'buena_practica'
            ]));
            return response()->json($rpta);
        }
        $arr_concurso = $this->concurso->todo();
        $arr_modalidad = $this->modalidad->listar();
        $arr_categoria = $this->categoria->listar();
        return view('postulacion.index')->with([
            'arr_concurso' => $arr_concurso,
            'arr_modalidad' => $arr_modalidad,
            'arr_categoria' => $arr_categoria
        ]);
    }

    public function detalles($id)
    {
        $postulacion = $this->postulacion->obtener($id);
        $fases = $this->postulacion->fases($id);
        if (empty($postulacion)) {
            abort(404);
        }
        return view('postulacion.detalles-' . $postulacion->view)->with([
            'postulacion' => $postulacion,
            'fases' => $fases
        ]);
    }

    public function listarTipoPostulacion(Request $request)
    {
        $arr_tipo_postulacion = $this->tipoPostulacion->filtrarPorModalidad($request->get('id_modalidad'));
        return response()->json($arr_tipo_postulacion);
    }

    public function listarTema(Request $request)
    {
        $arr_tema = $this->tema->filtrarPorCategoria($request->get('id_categoria'));
        return response()->json($arr_tema);
    }

    public function declaracionRepresentante($id)
    {
        $declaracion_representante = $this->postulacion->declaracionRepresentante($id);
        if (empty($declaracion_representante)) {
            abort(404);
        }
        $ext = pathinfo($declaracion_representante, PATHINFO_EXTENSION);
        return Storage::download($declaracion_representante, 'declaracion-representante.' . $ext);
    }

    public function declaracionEquipo($id)
    {
        $declaracion_equipo = $this->postulacion->declaracionEquipo($id);
        if (empty($declaracion_equipo)) {
            abort(404);
        }
        $ext = pathinfo($declaracion_equipo, PATHINFO_EXTENSION);
        return Storage::download($declaracion_equipo, 'declaracion-equipo.' . $ext);
    }

    public function actaModalidadColectiva($id)
    {
        $acta_modalidad_colectiva = $this->postulacion->actaModalidadColectiva($id);
        if (empty($acta_modalidad_colectiva)) {
            abort(404);
        }
        $ext = pathinfo($acta_modalidad_colectiva, PATHINFO_EXTENSION);
        return Storage::download($acta_modalidad_colectiva, 'acta-modalidad-colectiva.' . $ext);
    }
}
