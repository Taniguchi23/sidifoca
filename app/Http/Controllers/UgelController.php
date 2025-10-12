<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionUgel;
use App\Repositories\DreGreRepository;
use App\Repositories\UgelRepository;
use Illuminate\Http\Request;

class UgelController extends Controller
{
    protected $ugel;
    protected $dreGre;

    public function __construct(UgelRepository $ugel, DreGreRepository $dreGre)
    {
        $this->ugel = $ugel;
        $this->dreGre = $dreGre;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->ugel->paginar($request->get('limit'), $request->only([
                'id_dre_gre',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_dre_gre = $this->dreGre->listar();
        return view('ugel.index')->with('arr_dre_gre', $arr_dre_gre);
    }

    public function crear()
    {
        $arr_dre_gre = $this->dreGre->listar();
        return view('ugel.crear')->with('arr_dre_gre', $arr_dre_gre);
    }

    public function guardar(ValidacionUgel $request)
    {
        $rpta = $this->ugel->insertar($request->only([
            'id_dre_gre',
            'descripcion',
            'flg_grupo_especial'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $ugel = $this->ugel->obtener($id);
        if (empty($ugel)) {
            abort(404);
        }
        return view('ugel.detalles')->with('ugel', $ugel);
    }

    public function editar($id)
    {
        $ugel = $this->ugel->obtener($id);
        if (empty($ugel)) {
            abort(404);
        }
        $arr_dre_gre = $this->dreGre->listar();
        return view('ugel.editar')->with([
            'ugel' => $ugel,
            'arr_dre_gre' => $arr_dre_gre
        ]);
    }

    public function grabar(ValidacionUgel $request, $id)
    {
        $rpta = $this->ugel->editar($id, $request->only([
            'id_dre_gre',
            'descripcion',
            'flg_grupo_especial',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
