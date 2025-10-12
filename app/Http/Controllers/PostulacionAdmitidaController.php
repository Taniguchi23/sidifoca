<?php

namespace App\Http\Controllers;

use App\Repositories\CategoriaRepository;
use App\Repositories\ConcursoRepository;
use App\Repositories\ModalidadRepository;
use App\Repositories\PostulacionAdmitidaRepository;
use App\Repositories\TemaRepository;
use App\Repositories\TipoPostulacionRepository;
use App\Services\AdmisionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostulacionAdmitidaController extends Controller
{
    protected $postulacionAdmitida;
    protected $concurso;
    protected $modalidad;
    protected $tipoPostulacion;
    protected $categoria;
    protected $tema;
    protected $admision;

    public function __construct(
        PostulacionAdmitidaRepository $postulacionAdmitida,
        ConcursoRepository $concurso,
        ModalidadRepository $modalidad,
        TipoPostulacionRepository $tipoPostulacion,
        CategoriaRepository $categoria,
        TemaRepository $tema,
        AdmisionService $admision
    ) {
        $this->postulacionAdmitida = $postulacionAdmitida;
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
            $rpta = $this->postulacionAdmitida->paginar($request->get('limit'), $request->only([
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
        return view('postulacion-admitida.index')->with([
            'concurso' => $concurso,
            'arr_modalidad' => $arr_modalidad,
            'arr_categoria' => $arr_categoria
        ]);
    }

    public function detalles($id)
    {
        $postulacion = $this->postulacionAdmitida->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        }
        return view('postulacion-admitida.detalles-' . $postulacion->view)->with('postulacion', $postulacion);
    }

    public function editar($id)
    {
        $postulacion = $this->postulacionAdmitida->obtener($id);
        if (empty($postulacion)) {
            abort(404);
        }
        return view('postulacion-admitida.editar-' . $postulacion->view)->with([
            'postulacion' => $postulacion,
            'postulacion_admitida' => $postulacion->postulacion_admitida
        ]);
    }

    public function grabar(Request $request, $id)
    {
        $arr_calificacion = json_decode($request->get('calificaciones'));
        $rpta = $this->postulacionAdmitida->editar($id, $arr_calificacion);
        return response()->json($rpta);
    }

    public function noVigente()
    {
        return view('postulacion-admitida.no-vigente');
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
        $declaracion_representante = $this->postulacionAdmitida->declaracionRepresentante($id);
        if (empty($declaracion_representante)) {
            abort(404);
        }
        $ext = pathinfo($declaracion_representante, PATHINFO_EXTENSION);
        return Storage::download($declaracion_representante, 'declaracion-representante.' . $ext);
    }

    public function declaracionEquipo($id)
    {
        $declaracion_equipo = $this->postulacionAdmitida->declaracionEquipo($id);
        if (empty($declaracion_equipo)) {
            abort(404);
        }
        $ext = pathinfo($declaracion_equipo, PATHINFO_EXTENSION);
        return Storage::download($declaracion_equipo, 'declaracion-equipo.' . $ext);
    }

    public function actaModalidadColectiva($id)
    {
        $acta_modalidad_colectiva = $this->postulacionAdmitida->actaModalidadColectiva($id);
        if (empty($acta_modalidad_colectiva)) {
            abort(404);
        }
        $ext = pathinfo($acta_modalidad_colectiva, PATHINFO_EXTENSION);
        return Storage::download($acta_modalidad_colectiva, 'acta-modalidad-colectiva.' . $ext);
    }
}
