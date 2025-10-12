<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionPuesto;
use App\Repositories\NivelPuestoRepository;
use App\Repositories\PuestoRepository;
use App\Repositories\TipoEntidadRepository;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    protected $puesto;
    protected $nivelPuesto;
    protected $tipoEntidad;

    public function __construct(
        PuestoRepository $puesto,
        NivelPuestoRepository $nivelPuesto,
        TipoEntidadRepository $tipoEntidad
    ) {
        $this->puesto = $puesto;
        $this->nivelPuesto = $nivelPuesto;
        $this->tipoEntidad = $tipoEntidad;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->puesto->paginar($request->get('limit'), $request->only([
                'id_tipo_entidad',
                'id_nivel_puesto',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        $arr_nivel_puesto = $this->nivelPuesto->listar();
        return view('puesto.index')->with([
            'arr_tipo_entidad' => $arr_tipo_entidad,
            'arr_nivel_puesto' => $arr_nivel_puesto
        ]);
    }

    public function crear()
    {
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        $arr_nivel_puesto = $this->nivelPuesto->listar();
        return view('puesto.crear')->with([
            'arr_tipo_entidad' => $arr_tipo_entidad,
            'arr_nivel_puesto' => $arr_nivel_puesto
        ]);
    }

    public function guardar(ValidacionPuesto $request)
    {
        $rpta = $this->puesto->insertar($request->only([
            'id_tipo_entidad',
            'id_nivel_puesto',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $puesto = $this->puesto->obtener($id);
        if (empty($puesto)) {
            abort(404);
        }
        return view('puesto.detalles')->with('puesto', $puesto);
    }

    public function editar($id)
    {
        $puesto = $this->puesto->obtener($id);
        if (empty($puesto)) {
            abort(404);
        }
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        $arr_nivel_puesto = $this->nivelPuesto->listar();
        return view('puesto.editar')->with([
            'puesto' => $puesto,
            'arr_tipo_entidad' => $arr_tipo_entidad,
            'arr_nivel_puesto' => $arr_nivel_puesto
        ]);
    }

    public function grabar(ValidacionPuesto $request, $id)
    {
        $rpta = $this->puesto->editar($id, $request->only([
            'id_tipo_entidad',
            'id_nivel_puesto',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
