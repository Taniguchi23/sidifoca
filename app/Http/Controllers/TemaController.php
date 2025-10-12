<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionTema;
use App\Repositories\CategoriaRepository;
use App\Repositories\TemaRepository;
use Illuminate\Http\Request;

class TemaController extends Controller
{
    protected $tema;
    protected $categoria;

    public function __construct(TemaRepository $tema, CategoriaRepository $categoria)
    {
        $this->tema = $tema;
        $this->categoria = $categoria;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->tema->paginar($request->get('limit'), $request->only([
                'id_categoria',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_categoria = $this->categoria->listar();
        return view('tema.index')->with('arr_categoria', $arr_categoria);
    }

    public function crear()
    {
        $arr_categoria = $this->categoria->listar();
        return view('tema.crear')->with('arr_categoria', $arr_categoria);
    }

    public function guardar(ValidacionTema $request)
    {
        $rpta = $this->tema->insertar($request->only([
            'id_categoria',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $tema = $this->tema->obtener($id);
        if (empty($tema)) {
            abort(404);
        }
        return view('tema.detalles')->with('tema', $tema);
    }

    public function editar($id)
    {
        $tema = $this->tema->obtener($id);
        if (empty($tema)) {
            abort(404);
        }
        $arr_categoria = $this->categoria->listar();
        return view('tema.editar')->with([
            'tema' => $tema,
            'arr_categoria' => $arr_categoria
        ]);
    }

    public function grabar(ValidacionTema $request, $id)
    {
        $rpta = $this->tema->editar($id, $request->only([
            'id_categoria',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
