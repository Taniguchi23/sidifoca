<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionEntidadExterna;
use App\Repositories\EntidadExternaRepository;
use Illuminate\Http\Request;

class EntidadExternaController extends Controller
{
    protected $entidadExterna;

    public function __construct(EntidadExternaRepository $entidadExterna)
    {
        $this->entidadExterna = $entidadExterna;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->entidadExterna->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('entidad-externa.index');
    }

    public function crear()
    {
        return view('entidad-externa.crear');
    }

    public function guardar(ValidacionEntidadExterna $request)
    {
        $rpta = $this->entidadExterna->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $entidad_externa = $this->entidadExterna->obtener($id);
        if (empty($entidad_externa)) {
            abort(404);
        }
        return view('entidad-externa.detalles')->with('entidad_externa', $entidad_externa);
    }

    public function editar($id)
    {
        $entidad_externa = $this->entidadExterna->obtener($id);
        if (empty($entidad_externa)) {
            abort(404);
        }
        return view('entidad-externa.editar')->with('entidad_externa', $entidad_externa);
    }

    public function grabar(ValidacionEntidadExterna $request, $id)
    {
        $rpta = $this->entidadExterna->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
