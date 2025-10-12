<?php

namespace App\Repositories;

use App\GobiernoRegional;
use Exception;
use Illuminate\Support\Facades\Log;

class GobiernoRegionalRepository
{
    public function insertar($data)
    {
        try {
            $gobierno_regional = new GobiernoRegional();
            $gobierno_regional->descripcion = $data['descripcion'];
            $gobierno_regional->flg_estado = true;
            $gobierno_regional->id_usu_ingresa = auth()->id();
            $gobierno_regional->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $gobierno_regional = GobiernoRegional::find($id);
            $gobierno_regional->descripcion = $data['descripcion'];
            $gobierno_regional->flg_estado = $data['flg_estado'];
            $gobierno_regional->id_usu_modifica = auth()->id();
            $gobierno_regional->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $gobierno_regional = GobiernoRegional::find($id);
        return $gobierno_regional;
    }

    public function listar()
    {
        $lista = GobiernoRegional::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = GobiernoRegional::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
