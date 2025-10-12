<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionAdmision;
use App\Repositories\CategoriaRepository;
use App\Repositories\ConcursoRepository;
use App\Repositories\ModalidadRepository;
use App\Repositories\PostulacionConcursoRepository;
use App\Repositories\TemaRepository;
use App\Repositories\TipoPostulacionRepository;
use App\Services\AdmisionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostulacionConcursoController extends Controller
{
    protected $postulacionConcurso;
    protected $concurso;
    protected $modalidad;
    protected $tipoPostulacion;
    protected $categoria;
    protected $tema;
    protected $admision;

    public function __construct(
        PostulacionConcursoRepository $postulacionConcurso,
        ConcursoRepository $concurso,
        ModalidadRepository $modalidad,
        TipoPostulacionRepository $tipoPostulacion,
        CategoriaRepository $categoria,
        TemaRepository $tema,
        AdmisionService $admision
    ) {
        $this->postulacionConcurso = $postulacionConcurso;
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
            $rpta = $this->postulacionConcurso->paginar($request->get('limit'), $request->only([
                'id_modalidad',
                'id_tipo_postulacion',
                'id_categoria',
                'id_tema',
                'buena_practica'
            ]));
            return response()->json($rpta);
        }
        $concurso = $this->concurso->activo();
        $arr_modalidad = $this->modalidad->listar();
        $arr_categoria = $this->categoria->listar();
        return view('postulacion-concurso.index')->with([
            'concurso' => $concurso,
            'arr_modalidad' => $arr_modalidad,
            'arr_categoria' => $arr_categoria
        ]);
    }

    public function detalles($id)
    {
        $postulacion = $this->postulacionConcurso->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        }
        return view('postulacion-concurso.detalles-' . $postulacion->view)->with('postulacion', $postulacion);
    }

    public function editar($id)
    {
        $postulacion = $this->postulacionConcurso->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        }
        return view('postulacion-concurso.editar-' . $postulacion->view)->with('postulacion', $postulacion);
    }

    public function grabar(ValidacionAdmision $request, $id)
    {
        $rpta = $this->postulacionConcurso->editar($id, $request->only([
            'estado',
            'observacion'
        ]));
        if ($rpta['success']) {
            $this->admision->notificar($request->get('estado'), $rpta['data']);
        }
        return response()->json($rpta);
    }

    public function noVigente()
    {
        return view('postulacion-concurso.no-vigente');
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
        $declaracion_representante = $this->postulacionConcurso->declaracionRepresentante($id);
        if (empty($declaracion_representante)) {
            abort(404);
        }
        $ext = pathinfo($declaracion_representante, PATHINFO_EXTENSION);
        return Storage::download($declaracion_representante, 'declaracion-representante.' . $ext);
    }

    public function declaracionEquipo($id)
    {
        $declaracion_equipo = $this->postulacionConcurso->declaracionEquipo($id);
        if (empty($declaracion_equipo)) {
            abort(404);
        }
        $ext = pathinfo($declaracion_equipo, PATHINFO_EXTENSION);
        return Storage::download($declaracion_equipo, 'declaracion-equipo.' . $ext);
    }

    public function actaModalidadColectiva($id)
    {
        $acta_modalidad_colectiva = $this->postulacionConcurso->actaModalidadColectiva($id);
        if (empty($acta_modalidad_colectiva)) {
            abort(404);
        }
        $ext = pathinfo($acta_modalidad_colectiva, PATHINFO_EXTENSION);
        return Storage::download($acta_modalidad_colectiva, 'acta-modalidad-colectiva.' . $ext);
    }
}
