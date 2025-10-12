<?php

namespace App\Repositories;

use App\Provincia;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProvinciaRepository
{
    public function insertar($data)
    {
        try {
            $provincia = new Provincia();
            $provincia->id_dre_gre = $data['id_dre_gre'];
            $provincia->descripcion = $data['descripcion'];
            $provincia->flg_estado = true;
            $provincia->id_usu_ingresa = auth()->id();
            $provincia->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $provincia = Provincia::find($id);
            $provincia->id_dre_gre = $data['id_dre_gre'];
            $provincia->descripcion = $data['descripcion'];
            $provincia->flg_estado = $data['flg_estado'];
            $provincia->id_usu_modifica = auth()->id();
            $provincia->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $provincia = Provincia::with('dre_gre')
            ->find($id);
        return $provincia;
    }

    public function listar()
    {
        $lista = DB::table('T_MAE_PROVINCIA')
            ->join('T_MAE_DRE_GRE', 'T_MAE_PROVINCIA.id_dre_gre', '=', 'T_MAE_DRE_GRE.id_dre_gre')
            ->select(
                'T_MAE_PROVINCIA.*',
                DB::raw('CONCAT(T_MAE_PROVINCIA.descripcion, " - ", T_MAE_DRE_GRE.descripcion) AS fullname')
            )
            ->where('T_MAE_PROVINCIA.flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Provincia::with('dre_gre')
            ->where([
                ['flg_estado', '=', $data['flg_estado']],
                ['descripcion', 'like', '%' . $data['descripcion'] . '%']
            ])
            ->when($data['id_dre_gre'], function ($query) use ($data) {
                return $query->where([
                    ['id_dre_gre', '=', $data['id_dre_gre']]
                ]);
            })
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function filtrarPorDreGre($id_dre_gre)
    {
        $lista = Provincia::where([
            ['id_dre_gre', '=', $id_dre_gre],
            ['flg_estado', '=', true]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
