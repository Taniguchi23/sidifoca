<?php

namespace App\Repositories;

use App\RegimenLaboral;
use Exception;
use Illuminate\Support\Facades\Log;

class RegimenLaboralRepository
{
    public function insertar($data)
    {
        try {
            $regimen_laboral = new RegimenLaboral();
            $regimen_laboral->descripcion = $data['descripcion'];
            $regimen_laboral->flg_estado = true;
            $regimen_laboral->id_usu_ingresa = auth()->id();
            $regimen_laboral->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $regimen_laboral = RegimenLaboral::find($id);
            $regimen_laboral->descripcion = $data['descripcion'];
            $regimen_laboral->flg_estado = $data['flg_estado'];
            $regimen_laboral->id_usu_modifica = auth()->id();
            $regimen_laboral->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $regimen_laboral = RegimenLaboral::find($id);
        return $regimen_laboral;
    }

    public function listar()
    {
        $lista = RegimenLaboral::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = RegimenLaboral::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
