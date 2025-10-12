<?php

namespace App\Repositories;

use App\Tema;
use Exception;
use Illuminate\Support\Facades\Log;

class TemaRepository
{
    public function insertar($data)
    {
        try {
            $tema = new Tema();
            $tema->id_categoria = $data['id_categoria'];
            $tema->descripcion = $data['descripcion'];
            $tema->flg_estado = true;
            $tema->id_usu_ingresa = auth()->id();
            $tema->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $tema = Tema::find($id);
            $tema->id_categoria = $data['id_categoria'];
            $tema->descripcion = $data['descripcion'];
            $tema->flg_estado = $data['flg_estado'];
            $tema->id_usu_modifica = auth()->id();
            $tema->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $tema = Tema::with('categoria')
            ->find($id);
        return $tema;
    }

    public function listar()
    {
        $lista = Tema::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Tema::with('categoria')
            ->where([
                ['flg_estado', '=', $data['flg_estado']],
                ['descripcion', 'like', '%' . $data['descripcion'] . '%']
            ])
            ->when($data['id_categoria'], function ($query) use ($data) {
                return $query->where('id_categoria', '=', $data['id_categoria']);
            })
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function filtrarPorCategoria($id_categoria)
    {
        $lista = Tema::where([
            ['id_categoria', '=', $id_categoria],
            ['flg_estado', '=', true]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
