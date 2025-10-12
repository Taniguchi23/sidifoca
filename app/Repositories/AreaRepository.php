<?php

namespace App\Repositories;

use App\Area;
use Exception;
use Illuminate\Support\Facades\Log;

class AreaRepository
{
    public function insertar($data)
    {
        try {
            $area = new Area();
            $area->descripcion = $data['descripcion'];
            $area->flg_estado = true;
            $area->id_usu_ingresa = auth()->id();
            $area->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $area = Area::find($id);
            $area->descripcion = $data['descripcion'];
            $area->flg_estado = $data['flg_estado'];
            $area->id_usu_modifica = auth()->id();
            $area->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $area = Area::find($id);
        return $area;
    }

    public function listar()
    {
        $lista = Area::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Area::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
