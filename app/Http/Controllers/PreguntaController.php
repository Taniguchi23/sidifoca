<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionPregunta;
use App\Repositories\DimensionRepository;
use App\Repositories\PreguntaRepository;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    protected $pregunta;
    protected $dimension;

    public function __construct(PreguntaRepository $pregunta, DimensionRepository $dimension)
    {
        $this->pregunta = $pregunta;
        $this->dimension = $dimension;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->pregunta->paginar($request->get('limit'), $request->only([
                'id_dimension',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_dimension = $this->dimension->listar();
        return view('pregunta.index')->with('arr_dimension', $arr_dimension);
    }

    public function crear()
    {
        $arr_dimension = $this->dimension->listar();
        return view('pregunta.crear')->with('arr_dimension', $arr_dimension);
    }

    public function guardar(ValidacionPregunta $request)
    {
        $rpta = $this->pregunta->insertar($request->only([
            'id_dimension',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $pregunta = $this->pregunta->obtener($id);
        if (empty($pregunta)) {
            abort(404);
        }
        return view('pregunta.detalles')->with('pregunta', $pregunta);
    }

    public function editar($id)
    {
        $pregunta = $this->pregunta->obtener($id);
        if (empty($pregunta)) {
            abort(404);
        }
        $arr_dimension = $this->dimension->listar();
        return view('pregunta.editar')->with([
            'pregunta' => $pregunta,
            'arr_dimension' => $arr_dimension
        ]);
    }

    public function grabar(ValidacionPregunta $request, $id)
    {
        $rpta = $this->pregunta->editar($id, $request->only([
            'id_dimension',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
