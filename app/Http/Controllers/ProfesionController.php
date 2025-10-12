<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionProfesion;
use App\Repositories\ProfesionRepository;
use Illuminate\Http\Request;

class ProfesionController extends Controller
{
    protected $profesion;

    public function __construct(ProfesionRepository $profesion)
    {
        $this->profesion = $profesion;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->profesion->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('profesion.index');
    }

    public function crear()
    {
        return view('profesion.crear');
    }

    public function guardar(ValidacionProfesion $request)
    {
        $rpta = $this->profesion->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $profesion = $this->profesion->obtener($id);
        if (empty($profesion)) {
            abort(404);
        }
        return view('profesion.detalles')->with('profesion', $profesion);
    }

    public function editar($id)
    {
        $profesion = $this->profesion->obtener($id);
        if (empty($profesion)) {
            abort(404);
        }
        return view('profesion.editar')->with('profesion', $profesion);
    }

    public function grabar(ValidacionProfesion $request, $id)
    {
        $rpta = $this->profesion->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
