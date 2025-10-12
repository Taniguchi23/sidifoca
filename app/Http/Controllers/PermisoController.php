<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionPermiso;
use App\Repositories\ModuloRepository;
use App\Repositories\PermisoRepository;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    protected $permiso;
    protected $modulo;

    public function __construct(PermisoRepository $permiso, ModuloRepository $modulo)
    {
        $this->permiso = $permiso;
        $this->modulo = $modulo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->permiso->paginar($request->get('limit'), $request->only([
                'id_modulo',
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        $arr_modulo = $this->modulo->listar();
        return view('permiso.index')->with('arr_modulo', $arr_modulo);
    }

    public function crear()
    {
        $arr_modulo = $this->modulo->listar();
        return view('permiso.crear')->with('arr_modulo', $arr_modulo);
    }

    public function guardar(ValidacionPermiso $request)
    {
        $rpta = $this->permiso->insertar($request->only([
            'id_modulo',
            'descripcion'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $permiso = $this->permiso->obtener($id);
        if (empty($permiso)) {
            abort(404);
        }
        return view('permiso.detalles')->with('permiso', $permiso);
    }

    public function editar($id)
    {
        $permiso = $this->permiso->obtener($id);
        if (empty($permiso)) {
            abort(404);
        }
        $arr_modulo = $this->modulo->listar();
        return view('permiso.editar')->with([
            'permiso' => $permiso,
            'arr_modulo' => $arr_modulo
        ]);
    }

    public function grabar(ValidacionPermiso $request, $id)
    {
        $rpta = $this->permiso->editar($id, $request->only([
            'id_modulo',
            'descripcion',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
