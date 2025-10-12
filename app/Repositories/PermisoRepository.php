<?php

namespace App\Repositories;

use App\Permiso;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermisoRepository
{
    public function insertar($data)
    {
        try {
            $permiso = new Permiso();
            $permiso->id_modulo = $data['id_modulo'];
            $permiso->descripcion = $data['descripcion'];
            $permiso->flg_estado = true;
            $permiso->id_usu_ingresa = auth()->id();
            $permiso->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $permiso = Permiso::find($id);
            $permiso->id_modulo = $data['id_modulo'];
            $permiso->descripcion = $data['descripcion'];
            $permiso->flg_estado = $data['flg_estado'];
            $permiso->id_usu_modifica = auth()->id();
            $permiso->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $permiso = Permiso::with('modulo')
            ->find($id);
        return $permiso;
    }

    public function listar()
    {
        $lista = Permiso::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = DB::table('T_MAE_PERMISO')
            ->join('T_MAE_MODULO', 'T_MAE_MODULO.id_modulo', '=', 'T_MAE_PERMISO.id_modulo')
            ->select([
                'T_MAE_PERMISO.*',
                'T_MAE_MODULO.descripcion AS modulo'
            ])
            ->where([
                ['T_MAE_PERMISO.flg_estado', '=', $data['flg_estado']],
                ['T_MAE_PERMISO.descripcion', 'like', '%' . $data['descripcion'] . '%']
            ])
            ->when($data['id_modulo'], function ($query) use ($data) {
                return $query->where('T_MAE_PERMISO.id_modulo', '=', $data['id_modulo']);
            })
            ->orderby('modulo', 'asc')
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function filtrarPorModulo($id_modulo)
    {
        $lista = Permiso::where([
            ['id_modulo', '=', $id_modulo],
            ['flg_estado', '=', true]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
