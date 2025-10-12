<?php

namespace App\Repositories;

use App\Dimension;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DimensionRepository
{
    public function insertar($data)
    {
        try {
            $dimension = new Dimension();
            $dimension->id_modalidad = $data['id_modalidad'];
            $dimension->descripcion = $data['descripcion'];
            $dimension->flg_estado = true;
            $dimension->id_usu_ingresa = auth()->id();
            $dimension->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $dimension = Dimension::find($id);
            $dimension->id_modalidad = $data['id_modalidad'];
            $dimension->descripcion = $data['descripcion'];
            $dimension->flg_estado = $data['flg_estado'];
            $dimension->id_usu_modifica = auth()->id();
            $dimension->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $dimension = Dimension::with('modalidad')
            ->find($id);
        return $dimension;
    }

    public function listar()
    {
        $lista = DB::table('T_MAE_DIMENSION')
            ->join('T_MAE_MODALIDAD', 'T_MAE_MODALIDAD.id_modalidad', '=', 'T_MAE_DIMENSION.id_modalidad')
            ->select([
                'T_MAE_DIMENSION.*',
                DB::raw('CONCAT(T_MAE_DIMENSION.descripcion, " - ", T_MAE_MODALIDAD.descripcion) AS fullname')
            ])
            ->where('T_MAE_DIMENSION.flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Dimension::with('modalidad')
            ->where([
                ['flg_estado', '=', $data['flg_estado']],
                ['descripcion', 'like', '%' . $data['descripcion'] . '%']
            ])
            ->when($data['id_modalidad'], function ($query) use ($data) {
                return $query->where([
                    ['id_modalidad', '=', $data['id_modalidad']]
                ]);
            })
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function filtrarPorModalidad($id_modalidad)
    {
        $lista = Dimension::where([
            ['id_modalidad', '=', $id_modalidad],
            ['flg_estado', '=', true]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
