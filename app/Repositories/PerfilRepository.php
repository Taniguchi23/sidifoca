<?php

namespace App\Repositories;

use App\Perfil;
use App\PerfilMenu;
use App\PerfilPermiso;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerfilRepository
{
    public function insertar($data)
    {
        try {
            $perfil = new Perfil();
            $perfil->descripcion = $data['descripcion'];
            $perfil->flg_estado = true;
            DB::transaction(function () use ($perfil, $data) {
                $perfil->id_usu_ingresa = auth()->id();
                $perfil->save();
                foreach ($data['id_permiso'] as $id_permiso) {
                    if ($id_permiso) {
                        $perfil_permiso = new PerfilPermiso();
                        $perfil_permiso->id_perfil = $perfil->id_perfil;
                        $perfil_permiso->id_permiso = $id_permiso;
                        $perfil_permiso->flg_estado = true;
                        $perfil_permiso->id_usu_ingresa = auth()->id();
                        $perfil_permiso->save();
                    }
                }
                foreach ($data['id_menu'] as $id_menu) {
                    if ($id_menu) {
                        $perfil_menu = new PerfilMenu();
                        $perfil_menu->id_perfil = $perfil->id_perfil;
                        $perfil_menu->id_menu = $id_menu;
                        $perfil_menu->flg_estado = true;
                        $perfil_menu->id_usu_ingresa = auth()->id();
                        $perfil_menu->save();
                    }
                }
            });
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $perfil = Perfil::find($id);
            $perfil->descripcion = $data['descripcion'];
            $perfil->flg_estado = $data['flg_estado'];
            DB::transaction(function () use ($perfil, $data) {
                $perfil->id_usu_modifica = auth()->id();
                $perfil->save();
                PerfilPermiso::where('id_perfil', '=', $perfil->id_perfil)
                    ->update([
                        'flg_estado' => false,
                        'id_usu_modifica' => auth()->id()
                    ]);
                foreach ($data['id_permiso'] as $id_permiso) {
                    if ($id_permiso) {
                        $perfil_permiso = new PerfilPermiso();
                        $perfil_permiso->id_perfil = $perfil->id_perfil;
                        $perfil_permiso->id_permiso = $id_permiso;
                        $perfil_permiso->flg_estado = true;
                        $perfil_permiso->id_usu_ingresa = auth()->id();
                        $perfil_permiso->save();
                    }
                }
                PerfilMenu::where('id_perfil', '=', $perfil->id_perfil)
                    ->update([
                        'flg_estado' => false,
                        'id_usu_modifica' => auth()->id()
                    ]);
                foreach ($data['id_menu'] as $id_menu) {
                    if ($id_menu) {
                        $perfil_menu = new PerfilMenu();
                        $perfil_menu->id_perfil = $perfil->id_perfil;
                        $perfil_menu->id_menu = $id_menu;
                        $perfil_menu->flg_estado = true;
                        $perfil_menu->id_usu_ingresa = auth()->id();
                        $perfil_menu->save();
                    }
                }
            });
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            dd($e);
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $perfil = Perfil::with([
            'arr_perfil_permiso' => function ($query) {
                $query->where('flg_estado', '=', true);
            },
            'arr_perfil_menu' => function ($query) {
                $query->where('flg_estado', '=', true);
            }
        ])
            ->find($id);
        return $perfil;
    }

    public function listar()
    {
        $lista = Perfil::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Perfil::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
