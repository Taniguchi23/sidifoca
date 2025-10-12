<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionDimension;
use App\Repositories\ModalidadRepository;
use App\Repositories\DimensionRepository;
use Illuminate\Http\Request;

class DimensionController extends Controller
{
    protected $dimension;
    protected $modalidad;

    public function __construct(DimensionRepository $dimension, ModalidadRepository $modalidad)
    {
        $this->dimension = $dimension;
        $this->modalidad = $modalidad;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->dimension->paginar($request->get('limit'), $request->only([
                'id_modalidad',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_modalidad = $this->modalidad->listar();
        return view('dimension.index')->with('arr_modalidad', $arr_modalidad);
    }

    public function crear()
    {
        $arr_modalidad = $this->modalidad->listar();
        return view('dimension.crear')->with('arr_modalidad', $arr_modalidad);
    }

    public function guardar(ValidacionDimension $request)
    {
        $rpta = $this->dimension->insertar($request->only([
            'id_modalidad',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $dimension = $this->dimension->obtener($id);
        if (empty($dimension)) {
            abort(404);
        }
        return view('dimension.detalles')->with('dimension', $dimension);
    }

    public function editar($id)
    {
        $dimension = $this->dimension->obtener($id);
        if (empty($dimension)) {
            abort(404);
        }
        $arr_modalidad = $this->modalidad->listar();
        return view('dimension.editar')->with([
            'dimension' => $dimension,
            'arr_modalidad' => $arr_modalidad
        ]);
    }

    public function grabar(ValidacionDimension $request, $id)
    {
        $rpta = $this->dimension->editar($id, $request->only([
            'id_modalidad',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
