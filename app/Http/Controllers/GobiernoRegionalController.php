<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionGobiernoRegional;
use App\Repositories\GobiernoRegionalRepository;
use Illuminate\Http\Request;

class GobiernoRegionalController extends Controller
{
    protected $gobiernoRegional;

    public function __construct(GobiernoRegionalRepository $gobiernoRegional)
    {
        $this->gobiernoRegional = $gobiernoRegional;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->gobiernoRegional->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('gobierno-regional.index');
    }

    public function crear()
    {
        return view('gobierno-regional.crear');
    }

    public function guardar(ValidacionGobiernoRegional $request)
    {
        $rpta = $this->gobiernoRegional->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $gobierno_regional = $this->gobiernoRegional->obtener($id);
        if (empty($gobierno_regional)) {
            abort(404);
        }
        return view('gobierno-regional.detalles')->with('gobierno_regional', $gobierno_regional);
    }

    public function editar($id)
    {
        $gobierno_regional = $this->gobiernoRegional->obtener($id);
        if (empty($gobierno_regional)) {
            abort(404);
        }
        return view('gobierno-regional.editar')->with('gobierno_regional', $gobierno_regional);
    }

    public function grabar(ValidacionGobiernoRegional $request, $id)
    {
        $rpta = $this->gobiernoRegional->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
