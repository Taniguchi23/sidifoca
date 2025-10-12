<?php

namespace App\Repositories;

use App\Pregunta;
use Exception;
use Illuminate\Support\Facades\Log;

class PreguntaRepository
{
    public function insertar($data)
    {
        try {
            $pregunta = new Pregunta();
            $pregunta->id_dimension = $data['id_dimension'];
            $pregunta->descripcion = $data['descripcion'];
            $pregunta->flg_estado = true;
            $pregunta->id_usu_ingresa = auth()->id();
            $pregunta->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $pregunta = Pregunta::find($id);
            $pregunta->id_dimension = $data['id_dimension'];
            $pregunta->descripcion = $data['descripcion'];
            $pregunta->flg_estado = $data['flg_estado'];
            $pregunta->id_usu_modifica = auth()->id();
            $pregunta->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $pregunta = Pregunta::with('dimension')
            ->find($id);
        return $pregunta;
    }

    public function listar()
    {
        $lista = Pregunta::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Pregunta::with([
            'dimension',
            'dimension.modalidad'
        ])
            ->where([
                ['flg_estado', '=', $data['flg_estado']],
                ['descripcion', 'like', '%' . $data['descripcion'] . '%']
            ])
            ->when($data['id_dimension'], function ($query) use ($data) {
                return $query->where([
                    ['id_dimension', '=', $data['id_dimension']]
                ]);
            })
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }
}
