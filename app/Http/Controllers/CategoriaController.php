<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionCategoria;
use App\Repositories\CategoriaRepository;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    protected $categoria;

    public function __construct(CategoriaRepository $categoria)
    {
        $this->categoria = $categoria;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->categoria->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('categoria.index');
    }

    public function crear()
    {
        return view('categoria.crear');
    }

    public function guardar(ValidacionCategoria $request)
    {
        $rpta = $this->categoria->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $categoria = $this->categoria->obtener($id);
        if (empty($categoria)) {
            abort(404);
        }
        return view('categoria.detalles')->with('categoria', $categoria);
    }

    public function editar($id)
    {
        $categoria = $this->categoria->obtener($id);
        if (empty($categoria)) {
            abort(404);
        }
        return view('categoria.editar')->with('categoria', $categoria);
    }

    public function grabar(ValidacionCategoria $request, $id)
    {
        $rpta = $this->categoria->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
