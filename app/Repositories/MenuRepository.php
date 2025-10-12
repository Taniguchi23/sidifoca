<?php

namespace App\Repositories;

use App\Menu;
use Exception;
use Illuminate\Support\Facades\Log;

class MenuRepository
{
    public function insertar($data)
    {
        try {
            $menu = new Menu();
            $menu->p_id_menu = $data['p_id_menu'];
            $menu->descripcion = $data['descripcion'];
            $menu->ruta = $data['ruta'];
            $menu->posicion = $data['posicion'];
            $menu->icono = $data['icono'];
            $menu->flg_estado = true;
            $menu->id_usu_ingresa = auth()->id();
            $menu->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $menu = Menu::find($id);
            $menu->p_id_menu = $data['p_id_menu'];
            $menu->descripcion = $data['descripcion'];
            $menu->ruta = $data['ruta'];
            $menu->posicion = $data['posicion'];
            $menu->icono = $data['icono'];
            $menu->flg_estado = $data['flg_estado'];
            $menu->id_usu_modifica = auth()->id();
            $menu->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $menu = Menu::with('children')
            ->find($id);
        return $menu;
    }

    public function listar()
    {
        $lista = Menu::with([
            'children' => function ($query) {
                $query->where('flg_estado', '=', true)->orderBy('posicion', 'asc');
            }
        ])
            ->where('flg_estado', '=', true)
            ->whereNull('p_id_menu')
            ->orderBy('posicion', 'asc')
            ->get();
        return $lista;
    }

    public function tree()
    {
        $tree = Menu::with('children')
            ->whereNull('p_id_menu')
            ->orderBy('posicion', 'asc')
            ->get();
        return $tree;
    }
}
