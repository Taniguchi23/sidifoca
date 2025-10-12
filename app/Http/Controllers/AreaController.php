<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionArea;
use App\Repositories\AreaRepository;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    protected $area;

    public function __construct(AreaRepository $area)
    {
        $this->area = $area;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->area->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('area.index');
    }

    public function crear()
    {
        return view('area.crear');
    }

    public function guardar(ValidacionArea $request)
    {
        $rpta = $this->area->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $area = $this->area->obtener($id);
        if (empty($area)) {
            abort(404);
        }
        return view('area.detalles')->with('area', $area);
    }

    public function editar($id)
    {
        $area = $this->area->obtener($id);
        if (empty($area)) {
            abort(404);
        }
        return view('area.editar')->with('area', $area);
    }

    public function grabar(ValidacionArea $request, $id)
    {
        $rpta = $this->area->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
