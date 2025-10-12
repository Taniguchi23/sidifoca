<?php

namespace App\Repositories;

use App\EntidadExterna;
use Exception;
use Illuminate\Support\Facades\Log;

class EntidadExternaRepository
{
    public function insertar($data)
    {
        try {
            $entidad_externa = new EntidadExterna();
            $entidad_externa->descripcion = $data['descripcion'];
            $entidad_externa->flg_estado = true;
            $entidad_externa->id_usu_ingresa = auth()->id();
            $entidad_externa->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $entidad_externa = EntidadExterna::find($id);
            $entidad_externa->descripcion = $data['descripcion'];
            $entidad_externa->flg_estado = $data['flg_estado'];
            $entidad_externa->id_usu_modifica = auth()->id();
            $entidad_externa->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $entidad_externa = EntidadExterna::find($id);
        return $entidad_externa;
    }

    public function listar()
    {
        $lista = EntidadExterna::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data = null)
    {
        $rpta = EntidadExterna::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
