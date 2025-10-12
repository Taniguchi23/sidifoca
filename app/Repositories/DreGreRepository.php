<?php

namespace App\Repositories;

use App\DreGre;
use Exception;
use Illuminate\Support\Facades\Log;

class DreGreRepository
{
    public function insertar($data)
    {
        try {
            $dre_gre = new DreGre();
            $dre_gre->descripcion = $data['descripcion'];
            $dre_gre->flg_estado = true;
            $dre_gre->id_usu_ingresa = auth()->id();
            $dre_gre->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $dre_gre = DreGre::find($id);
            $dre_gre->descripcion = $data['descripcion'];
            $dre_gre->flg_estado = $data['flg_estado'];
            $dre_gre->id_usu_modifica = auth()->id();
            $dre_gre->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $dre_gre = DreGre::find($id);
        return $dre_gre;
    }

    public function listar()
    {
        $lista = DreGre::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = DreGre::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
