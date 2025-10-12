<?php

namespace App\Repositories;

use App\Ugel;
use Exception;
use Illuminate\Support\Facades\Log;

class UgelRepository
{
    public function insertar($data)
    {
        try {
            $ugel = new Ugel();
            $ugel->id_dre_gre = $data['id_dre_gre'];
            $ugel->descripcion = $data['descripcion'];
            $ugel->flg_grupo_especial = $data['flg_grupo_especial'];
            $ugel->flg_estado = true;
            $ugel->id_usu_ingresa = auth()->id();
            $ugel->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $ugel = Ugel::find($id);
            $ugel->id_dre_gre = $data['id_dre_gre'];
            $ugel->descripcion = $data['descripcion'];
            $ugel->flg_grupo_especial = $data['flg_grupo_especial'];
            $ugel->flg_estado = $data['flg_estado'];
            $ugel->id_usu_modifica = auth()->id();
            $ugel->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $ugel = Ugel::with('dre_gre')
            ->find($id);
        return $ugel;
    }

    public function listar()
    {
        $lista = Ugel::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Ugel::with('dre_gre')
            ->where([
                ['flg_estado', '=', $data['flg_estado']],
                ['descripcion', 'like', '%' . $data['descripcion'] . '%']
            ])
            ->when($data['id_dre_gre'], function ($query) use ($data) {
                return $query->where('id_dre_gre', '=', $data['id_dre_gre']);
            })
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function filtrarPorDreGre($id_dre_gre)
    {
        $lista = Ugel::where([
            ['id_dre_gre', '=', $id_dre_gre],
            ['flg_estado', '=', true]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
