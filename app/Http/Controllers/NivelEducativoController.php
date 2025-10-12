<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionNivelEducativo;
use App\Repositories\NivelEducativoRepository;
use Illuminate\Http\Request;

class NivelEducativoController extends Controller
{
    protected $nivelEducativo;

    public function __construct(NivelEducativoRepository $nivelEducativo)
    {
        $this->nivelEducativo = $nivelEducativo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->nivelEducativo->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('nivel-educativo.index');
    }

    public function crear()
    {
        return view('nivel-educativo.crear');
    }

    public function guardar(ValidacionNivelEducativo $request)
    {
        $rpta = $this->nivelEducativo->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $nivel_educativo = $this->nivelEducativo->obtener($id);
        if (empty($nivel_educativo)) {
            abort(404);
        }
        return view('nivel-educativo.detalles')->with('nivel_educativo', $nivel_educativo);
    }

    public function editar($id)
    {
        $nivel_educativo = $this->nivelEducativo->obtener($id);
        if (empty($nivel_educativo)) {
            abort(404);
        }
        return view('nivel-educativo.editar')->with('nivel_educativo', $nivel_educativo);
    }

    public function grabar(ValidacionNivelEducativo $request, $id)
    {
        $rpta = $this->nivelEducativo->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
