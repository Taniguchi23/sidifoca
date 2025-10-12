<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionNivelPuesto;
use App\Repositories\NivelPuestoRepository;
use Illuminate\Http\Request;

class NivelPuestoController extends Controller
{
    protected $nivelPuesto;

    public function __construct(NivelPuestoRepository $nivelPuesto)
    {
        $this->nivelPuesto = $nivelPuesto;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->nivelPuesto->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('nivel-puesto.index');
    }

    public function crear()
    {
        return view('nivel-puesto.crear');
    }

    public function guardar(ValidacionNivelPuesto $request)
    {
        $rpta = $this->nivelPuesto->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $nivel_puesto = $this->nivelPuesto->obtener($id);
        if (empty($nivel_puesto)) {
            abort(404);
        }
        return view('nivel-puesto.detalles')->with('nivel_puesto', $nivel_puesto);
    }

    public function editar($id)
    {
        $nivel_puesto = $this->nivelPuesto->obtener($id);
        if (empty($nivel_puesto)) {
            abort(404);
        }
        return view('nivel-puesto.editar')->with('nivel_puesto', $nivel_puesto);
    }

    public function grabar(ValidacionNivelPuesto $request, $id)
    {
        $rpta = $this->nivelPuesto->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
