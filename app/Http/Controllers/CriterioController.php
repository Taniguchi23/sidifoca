<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionCriterio;
use App\Repositories\ModalidadRepository;
use App\Repositories\CriterioRepository;
use Illuminate\Http\Request;

class CriterioController extends Controller
{
    protected $criterio;
    protected $modalidad;

    public function __construct(CriterioRepository $criterio, ModalidadRepository $modalidad)
    {
        $this->criterio = $criterio;
        $this->modalidad = $modalidad;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->criterio->paginar($request->get('limit'), $request->only([
                'id_modalidad',
                'descripcion',
                'detalles',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_modalidad = $this->modalidad->listar();
        return view('criterio.index')->with('arr_modalidad', $arr_modalidad);
    }

    public function crear()
    {
        $arr_modalidad = $this->modalidad->listar();
        return view('criterio.crear')->with('arr_modalidad', $arr_modalidad);
    }

    public function guardar(ValidacionCriterio $request)
    {
        $rpta = $this->criterio->insertar($request->only([
            'id_modalidad',
            'descripcion',
            'detalles',
            'puntaje_maximo'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $criterio = $this->criterio->obtener($id);
        if (empty($criterio)) {
            abort(404);
        }
        return view('criterio.detalles')->with('criterio', $criterio);
    }

    public function editar($id)
    {
        $criterio = $this->criterio->obtener($id);
        if (empty($criterio)) {
            abort(404);
        }
        $arr_modalidad = $this->modalidad->listar();
        return view('criterio.editar')->with([
            'criterio' => $criterio,
            'arr_modalidad' => $arr_modalidad
        ]);
    }

    public function grabar(ValidacionCriterio $request, $id)
    {
        $rpta = $this->criterio->editar($id, $request->only([
            'id_modalidad',
            'descripcion',
            'detalles',
            'puntaje_maximo',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
