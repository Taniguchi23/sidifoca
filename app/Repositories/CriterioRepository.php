<?php

namespace App\Repositories;

use App\Criterio;
use Exception;
use Illuminate\Support\Facades\Log;

class CriterioRepository
{
    public function insertar($data)
    {
        try {
            $criterio = new Criterio();
            $criterio->id_modalidad = $data['id_modalidad'];
            $criterio->descripcion = $data['descripcion'];
            $criterio->detalles = $data['detalles'];
            $criterio->puntaje_maximo = $data['puntaje_maximo'];
            $criterio->flg_estado = true;
            $criterio->id_usu_ingresa = auth()->id();
            $criterio->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $criterio = Criterio::find($id);
            $criterio->id_modalidad = $data['id_modalidad'];
            $criterio->descripcion = $data['descripcion'];
            $criterio->detalles = $data['detalles'];
            $criterio->puntaje_maximo = $data['puntaje_maximo'];
            $criterio->flg_estado = $data['flg_estado'];
            $criterio->id_usu_modifica = auth()->id();
            $criterio->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $criterio = Criterio::with('modalidad')
            ->find($id);
        return $criterio;
    }

    public function listar()
    {
        $lista = Criterio::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Criterio::with('modalidad')
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
}
