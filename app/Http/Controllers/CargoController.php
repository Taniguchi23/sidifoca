<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionCargo;
use App\Repositories\TipoEntidadRepository;
use App\Repositories\CargoRepository;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    protected $cargo;
    protected $tipoEntidad;

    public function __construct(CargoRepository $cargo, TipoEntidadRepository $tipoEntidad)
    {
        $this->cargo = $cargo;
        $this->tipoEntidad = $tipoEntidad;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->cargo->paginar($request->get('limit'), $request->only([
                'id_tipo_entidad',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        return view('cargo.index')->with('arr_tipo_entidad', $arr_tipo_entidad);
    }

    public function crear()
    {
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        return view('cargo.crear')->with('arr_tipo_entidad', $arr_tipo_entidad);
    }

    public function guardar(ValidacionCargo $request)
    {
        $rpta = $this->cargo->insertar($request->only([
            'id_tipo_entidad',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $cargo = $this->cargo->obtener($id);
        if (empty($cargo)) {
            abort(404);
        }
        return view('cargo.detalles')->with('cargo', $cargo);
    }

    public function editar($id)
    {
        $cargo = $this->cargo->obtener($id);
        if (empty($cargo)) {
            abort(404);
        }
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        return view('cargo.editar')->with([
            'cargo' => $cargo,
            'arr_tipo_entidad' => $arr_tipo_entidad
        ]);
    }

    public function grabar(ValidacionCargo $request, $id)
    {
        $rpta = $this->cargo->editar($id, $request->only([
            'id_tipo_entidad',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
