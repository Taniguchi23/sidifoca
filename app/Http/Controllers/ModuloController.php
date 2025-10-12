<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionModulo;
use App\Repositories\ModuloRepository;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    protected $modulo;

    public function __construct(ModuloRepository $modulo)
    {
        $this->modulo = $modulo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->modulo->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('modulo.index');
    }

    public function crear()
    {
        return view('modulo.crear');
    }

    public function guardar(ValidacionModulo $request)
    {
        $rpta = $this->modulo->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $modulo = $this->modulo->obtener($id);
        if (empty($modulo)) {
            abort(404);
        }
        return view('modulo.detalles')->with('modulo', $modulo);
    }

    public function editar($id)
    {
        $modulo = $this->modulo->obtener($id);
        if (empty($modulo)) {
            abort(404);
        }
        return view('modulo.editar')->with('modulo', $modulo);
    }

    public function grabar(ValidacionModulo $request, $id)
    {
        $rpta = $this->modulo->editar($id, $request->only([
            'id_categoria',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
