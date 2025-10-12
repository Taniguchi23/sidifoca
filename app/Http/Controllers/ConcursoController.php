<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionConcurso;
use App\Repositories\ConcursoRepository;
use App\Traits\TokenTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConcursoController extends Controller
{
    use TokenTrait; 

    protected $concurso;

    public function __construct(ConcursoRepository $concurso)
    {
        $this->concurso = $concurso;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->concurso->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('concurso.index');
    }

    public function crear()
    {
        return view('concurso.crear');
    }

    public function guardar(ValidacionConcurso $request)
    {
        $rpta = $this->concurso->insertar($request->only([
            'descripcion',
            'fecha_inicio',
            'fecha_termino',
            'url_bases_concurso',
            'url_acta_modalidad_colectiva'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $concurso = $this->concurso->obtener($id);
        $token = $this->generarToken();
        if (empty($concurso)) {
            abort(404);
        }
        return view('concurso.detalles')->with([
            'concurso' => $concurso,
            'token' => $token
        ]);
    }

    public function editar($id)
    {
        $concurso = $this->concurso->obtener($id);
        $token = $this->generarToken();
        if (empty($concurso)) {
            abort(404);
        }
        return view('concurso.editar')->with([
            'concurso' => $concurso,
            'token' => $token
        ]);
    }

    public function grabar(ValidacionConcurso $request, $id)
    {
        $rpta = $this->concurso->editar($id, $request->only([
            'descripcion',
            'fecha_inicio',
            'fecha_termino',
            'url_bases_concurso',
            'url_acta_modalidad_colectiva',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }

    public function basesConcurso($id_concurso, $token)
    {
        if (!$this->validarToken($token)) {
            abort(521);
        }
        $bases_concurso = $this->concurso->basesConcurso($id_concurso);
        if (empty($bases_concurso)) {
            abort(404);
        }
        $ext = pathinfo($bases_concurso, PATHINFO_EXTENSION);
        return Storage::download($bases_concurso, 'bases-concurso.' . $ext);
    }

    public function bpgActaAcuerdosColectiva($id_concurso, $token)
    {
        if (!$this->validarToken($token)) {
            abort(521);
        }
        $bpg_acta_acuerdos_colectiva_vigente = $this->concurso->bpgActaAcuerdosColectiva($id_concurso);
        if (empty($bpg_acta_acuerdos_colectiva_vigente)) {
            abort(404);
        }
        $ext = pathinfo($bpg_acta_acuerdos_colectiva_vigente, PATHINFO_EXTENSION);
        return Storage::download($bpg_acta_acuerdos_colectiva_vigente, 'modelo-acuerdos-colectiva.' . $ext);
    }
}
