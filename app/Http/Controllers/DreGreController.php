<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionDreGre;
use App\Repositories\DreGreRepository;
use Illuminate\Http\Request;

class DreGreController extends Controller
{
    protected $dreGre;

    public function __construct(DreGreRepository $dreGre)
    {
        $this->dreGre = $dreGre;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->dreGre->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('dre-gre.index');
    }

    public function crear()
    {
        return view('dre-gre.crear');
    }

    public function guardar(ValidacionDreGre $request)
    {
        $rpta = $this->dreGre->insertar($request->only([
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $dre_gre = $this->dreGre->obtener($id);
        if (empty($dre_gre)) {
            abort(404);
        }
        return view('dre-gre.detalles')->with('dre_gre', $dre_gre);
    }

    public function editar($id)
    {
        $dre_gre = $this->dreGre->obtener($id);
        if (empty($dre_gre)) {
            abort(404);
        }
        return view('dre-gre.editar')->with('dre_gre', $dre_gre);
    }

    public function grabar(ValidacionDreGre $request, $id)
    {
        $rpta = $this->dreGre->editar($id, $request->only([
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
