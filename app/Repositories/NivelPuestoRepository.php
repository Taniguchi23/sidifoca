<?php

namespace App\Repositories;

use App\NivelPuesto;
use Exception;
use Illuminate\Support\Facades\Log;

class NivelPuestoRepository
{
    public function insertar($data)
    {
        try {
            $nivel_puesto = new NivelPuesto();
            $nivel_puesto->descripcion = $data['descripcion'];
            $nivel_puesto->flg_estado = true;
            $nivel_puesto->id_usu_ingresa = auth()->id();
            $nivel_puesto->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $nivel_puesto = NivelPuesto::find($id);
            $nivel_puesto->descripcion = $data['descripcion'];
            $nivel_puesto->flg_estado = $data['flg_estado'];
            $nivel_puesto->id_usu_modifica = auth()->id();
            $nivel_puesto->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $nivel_puesto = NivelPuesto::find($id);
        return $nivel_puesto;
    }

    public function listar()
    {
        $lista = NivelPuesto::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = NivelPuesto::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
