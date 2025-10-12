<?php

namespace App\Repositories;

use App\Profesion;
use Exception;
use Illuminate\Support\Facades\Log;

class ProfesionRepository
{
    public function insertar($data)
    {
        try {
            $profesion = new Profesion();
            $profesion->descripcion = $data['descripcion'];
            $profesion->flg_estado = true;
            $profesion->id_usu_ingresa = auth()->id();
            $profesion->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $profesion = Profesion::find($id);
            $profesion->descripcion = $data['descripcion'];
            $profesion->flg_estado = $data['flg_estado'];
            $profesion->id_usu_modifica = auth()->id();
            $profesion->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $profesion = Profesion::find($id);
        return $profesion;
    }

    public function listar()
    {
        $lista = Profesion::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Profesion::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
