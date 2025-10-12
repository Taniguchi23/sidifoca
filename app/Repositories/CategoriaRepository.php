<?php

namespace App\Repositories;

use App\Categoria;
use Exception;
use Illuminate\Support\Facades\Log;

class CategoriaRepository
{
    public function insertar($data)
    {
        try {
            $categoria = new Categoria();
            $categoria->descripcion = $data['descripcion'];
            $categoria->flg_estado = true;
            $categoria->id_usu_ingresa = auth()->id();
            $categoria->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $categoria = Categoria::find($id);
            $categoria->descripcion = $data['descripcion'];
            $categoria->flg_estado = $data['flg_estado'];
            $categoria->id_usu_modifica = auth()->id();
            $categoria->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $categoria = Categoria::find($id);
        return $categoria;
    }

    public function listar()
    {
        $lista = Categoria::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Categoria::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
