<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionGobiernoLocal;
use App\Repositories\DreGreRepository;
use App\Repositories\GobiernoLocalRepository;
use Illuminate\Http\Request;

class GobiernoLocalController extends Controller
{
    protected $gobiernoLocal;
    protected $dreGre;

    public function __construct(GobiernoLocalRepository $gobiernoLocal, DreGreRepository $dreGre)
    {
        $this->gobiernoLocal = $gobiernoLocal;
        $this->dreGre = $dreGre;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->gobiernoLocal->paginar($request->get('limit'), $request->only([
                'id_dre_gre',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_dre_gre = $this->dreGre->listar();
        return view('gobierno-local.index')->with('arr_dre_gre', $arr_dre_gre);
    }

    public function crear()
    {
        $arr_dre_gre = $this->dreGre->listar();
        return view('gobierno-local.crear')->with('arr_dre_gre', $arr_dre_gre);
    }

    public function guardar(ValidacionGobiernoLocal $request)
    {
        $rpta = $this->gobiernoLocal->insertar($request->only([
            'id_dre_gre',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $gobierno_local = $this->gobiernoLocal->obtener($id);
        if (empty($gobierno_local)) {
            abort(404);
        }
        return view('gobierno-local.detalles')->with('gobierno_local', $gobierno_local);
    }

    public function editar($id)
    {
        $gobierno_local = $this->gobiernoLocal->obtener($id);
        if (empty($gobierno_local)) {
            abort(404);
        }
        $arr_dre_gre = $this->dreGre->listar();
        return view('gobierno-local.editar')->with([
            'gobierno_local' => $gobierno_local,
            'arr_dre_gre' => $arr_dre_gre
        ]);
    }

    public function grabar(ValidacionGobiernoLocal $request, $id)
    {
        $rpta = $this->gobiernoLocal->editar($id, $request->only([
            'id_dre_gre',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
