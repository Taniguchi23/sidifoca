<?php

namespace App\Repositories;

use App\Modulo;
use Exception;
use Illuminate\Support\Facades\Log;

class ModuloRepository
{
    public function insertar($data)
    {
        try {
            $modulo = new Modulo();
            $modulo->descripcion = $data['descripcion'];
            $modulo->flg_estado = true;
            $modulo->id_usu_ingresa = auth()->id();
            $modulo->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $modulo = Modulo::find($id);
            $modulo->descripcion = $data['descripcion'];
            $modulo->flg_estado = $data['flg_estado'];
            $modulo->id_usu_modifica = auth()->id();
            $modulo->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $modulo = Modulo::find($id);
        return $modulo;
    }

    public function listar()
    {
        $lista = Modulo::with([
            'arr_permiso' => function ($query) {
                $query->where('flg_estado', '=', true)->orderBy('descripcion', 'asc');
            }
        ])
            ->where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Modulo::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
