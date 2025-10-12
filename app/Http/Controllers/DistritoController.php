<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionDistrito;
use App\Repositories\ProvinciaRepository;
use App\Repositories\DistritoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DistritoController extends Controller
{
    protected $distrito;
    protected $provincia;

    public function __construct(DistritoRepository $distrito, ProvinciaRepository $provincia)
    {
        $this->distrito = $distrito;
        $this->provincia = $provincia;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->distrito->paginar($request->get('limit'), $request->only([
                'id_provincia',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_provincia = $this->provincia->listar();
        return view('distrito.index')->with('arr_provincia', $arr_provincia);
    }

    public function crear()
    {
        $arr_provincia = $this->provincia->listar();
        return view('distrito.crear')->with('arr_provincia', $arr_provincia);
    }

    public function guardar(ValidacionDistrito $request)
    {
        $rpta = $this->distrito->insertar($request->only([
            'id_provincia',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $distrito = $this->distrito->obtener($id);
        if (empty($distrito)) {
            abort(404);
        }
        return view('distrito.detalles')->with('distrito', $distrito);
    }

    public function editar($id)
    {
        $distrito = $this->distrito->obtener($id);
        if (empty($distrito)) {
            abort(404);
        }
        $arr_provincia = $this->provincia->listar();
        return view('distrito.editar')->with([
            'distrito' => $distrito,
            'arr_provincia' => $arr_provincia
        ]);
    }

    public function grabar(ValidacionDistrito $request, $id)
    {
        $rpta = $this->distrito->editar($id, $request->only([
            'id_provincia',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
