<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionPerfil;
use App\Repositories\MenuRepository;
use App\Repositories\ModuloRepository;
use App\Repositories\PerfilRepository;
use App\Repositories\PermisoRepository;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    protected $perfil;
    protected $modulo;
    protected $permiso;
    protected $menu;

    public function __construct(
        PerfilRepository $perfil,
        ModuloRepository $modulo,
        PermisoRepository $permiso,
        MenuRepository $menu
    ) {
        $this->perfil = $perfil;
        $this->modulo = $modulo;
        $this->permiso = $permiso;
        $this->menu = $menu;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->perfil->paginar($request->get('limit'), $request->only([
                'descripcion',
                'flg_estado'
            ]));
            return response()->json($rpta);
        }
        return view('perfil.index');
    }

    public function crear()
    {
        $arr_modulo = $this->modulo->listar();
        $arr_menu = $this->menu->listar();
        return view('perfil.crear')->with([
            'arr_modulo' => $arr_modulo,
            'arr_menu' => $arr_menu
        ]);
    }

    public function guardar(ValidacionPerfil $request)
    {
        $rpta = $this->perfil->insertar($request->only([
            'descripcion',
            'id_permiso',
            'id_menu'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $perfil = $this->perfil->obtener($id);
        if (empty($perfil)) {
            abort(404);
        }
        $arr_modulo = $this->modulo->listar();
        $arr_menu = $this->menu->listar();
        return view('perfil.detalles')->with([
            'perfil' => $perfil,
            'arr_modulo' => $arr_modulo,
            'arr_menu' => $arr_menu
        ]);
    }

    public function editar($id)
    {
        $perfil = $this->perfil->obtener($id);
        if (empty($perfil)) {
            abort(404);
        }
        $arr_modulo = $this->modulo->listar();
        $arr_menu = $this->menu->listar();
        return view('perfil.editar')->with([
            'perfil' => $perfil,
            'arr_modulo' => $arr_modulo,
            'arr_menu' => $arr_menu
        ]);
    }

    public function grabar(ValidacionPerfil $request, $id)
    {
        $rpta = $this->perfil->editar($id, $request->only([
            'descripcion',
            'id_permiso',
            'id_menu',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
