<?php

namespace App\Repositories;

use App\GobiernoLocal;
use Exception;
use Illuminate\Support\Facades\Log;

class GobiernoLocalRepository
{
    public function insertar($data)
    {
        try {
            $gobierno_local = new GobiernoLocal();
            $gobierno_local->id_dre_gre = $data['id_dre_gre'];
            $gobierno_local->descripcion = $data['descripcion'];
            $gobierno_local->flg_estado = true;
            $gobierno_local->id_usu_ingresa = auth()->id();
            $gobierno_local->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $gobierno_local = GobiernoLocal::find($id);
            $gobierno_local->id_dre_gre = $data['id_dre_gre'];
            $gobierno_local->descripcion = $data['descripcion'];
            $gobierno_local->flg_estado = $data['flg_estado'];
            $gobierno_local->id_usu_modifica = auth()->id();
            $gobierno_local->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $gobierno_local = GobiernoLocal::with('dre_gre')
            ->find($id);
        return $gobierno_local;
    }

    public function listar()
    {
        $lista = GobiernoLocal::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = GobiernoLocal::with('dre_gre')
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
        $lista = GobiernoLocal::where([
            ['id_dre_gre', '=', $id_dre_gre],
            ['flg_estado', '=', true]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
