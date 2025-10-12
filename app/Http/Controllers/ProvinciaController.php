<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionProvincia;
use App\Repositories\DreGreRepository;
use App\Repositories\ProvinciaRepository;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    protected $provincia;
    protected $dreGre;

    public function __construct(ProvinciaRepository $provincia, DreGreRepository $dreGre)
    {
        $this->provincia = $provincia;
        $this->dreGre = $dreGre;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->provincia->paginar($request->get('limit'), $request->only([
                'id_dre_gre',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_dre_gre = $this->dreGre->listar();
        return view('provincia.index')->with('arr_dre_gre', $arr_dre_gre);
    }

    public function crear()
    {
        $arr_dre_gre = $this->dreGre->listar();
        return view('provincia.crear')->with('arr_dre_gre', $arr_dre_gre);
    }

    public function guardar(ValidacionProvincia $request)
    {
        $rpta = $this->provincia->insertar($request->only([
            'id_dre_gre',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $provincia = $this->provincia->obtener($id);
        if (empty($provincia)) {
            abort(404);
        }
        return view('provincia.detalles')->with('provincia', $provincia);
    }

    public function editar($id)
    {
        $provincia = $this->provincia->obtener($id);
        if (empty($provincia)) {
            abort(404);
        }
        $arr_dre_gre = $this->dreGre->listar();
        return view('provincia.editar')->with([
            'provincia' => $provincia,
            'arr_dre_gre' => $arr_dre_gre
        ]);
    }

    public function grabar(ValidacionProvincia $request, $id)
    {
        $rpta = $this->provincia->editar($id, $request->only([
            'id_dre_gre',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
