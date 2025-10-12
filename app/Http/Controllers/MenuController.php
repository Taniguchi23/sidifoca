<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionMenu;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menu;

    public function __construct(MenuRepository $menu)
    {
        $this->menu = $menu;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tree = $this->menu->tree();
            return response()->json($tree);
        }
        return view('menu.index');
    }

    public function crear()
    {
        $arr_menu = $this->menu->listar();
        return view('menu.crear')->with('arr_menu', $arr_menu);
    }

    public function guardar(ValidacionMenu $request)
    {
        $rpta = $this->menu->insertar($request->only([
            'p_id_menu',
            'descripcion',
            'ruta',
            'posicion',
            'icono'
        ]));
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $menu = $this->menu->obtener($id);
        if (empty($menu)) {
            abort(404);
        }
        return view('menu.detalles')->with('menu', $menu);
    }

    public function editar($id)
    {
        $menu = $this->menu->obtener($id);
        if (empty($menu)) {
            abort(404);
        }
        $arr_menu = $this->menu->listar();
        return view('menu.editar')->with([
            'menu' => $menu,
            'arr_menu' => $arr_menu
        ]);
    }

    public function grabar(ValidacionMenu $request, $id)
    {
        $rpta = $this->menu->editar($id, $request->only([
            'p_id_menu',
            'descripcion',
            'ruta',
            'posicion',
            'icono',
            'flg_estado'
        ]));
        return response()->json($rpta);
    }
}
