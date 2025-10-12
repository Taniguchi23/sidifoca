<?php

namespace App\Repositories;

use App\NivelEducativo;
use Exception;
use Illuminate\Support\Facades\Log;

class NivelEducativoRepository
{
    public function insertar($data)
    {
        try {
            $nivel_educativo = new NivelEducativo();
            $nivel_educativo->descripcion = $data['descripcion'];
            $nivel_educativo->flg_estado = true;
            $nivel_educativo->id_usu_ingresa = auth()->id();
            $nivel_educativo->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $nivel_educativo = NivelEducativo::find($id);
            $nivel_educativo->descripcion = $data['descripcion'];
            $nivel_educativo->flg_estado = $data['flg_estado'];
            $nivel_educativo->id_usu_modifica = auth()->id();
            $nivel_educativo->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $nivel_educativo = NivelEducativo::find($id);
        return $nivel_educativo;
    }

    public function listar()
    {
        $lista = NivelEducativo::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = NivelEducativo::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
