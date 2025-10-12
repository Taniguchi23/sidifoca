<?php

namespace App\Repositories;

use App\Puesto;
use Exception;
use Illuminate\Support\Facades\Log;

class PuestoRepository
{
    public function insertar($data)
    {
        try {
            $puesto = new Puesto();
            $puesto->id_tipo_entidad = $data['id_tipo_entidad'];
            $puesto->id_nivel_puesto = $data['id_nivel_puesto'];
            $puesto->descripcion = $data['descripcion'];
            $puesto->flg_estado = true;
            $puesto->id_usu_ingresa = auth()->id();
            $puesto->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $puesto = Puesto::find($id);
            $puesto->id_tipo_entidad = $data['id_tipo_entidad'];
            $puesto->id_nivel_puesto = $data['id_nivel_puesto'];
            $puesto->descripcion = $data['descripcion'];
            $puesto->flg_estado = $data['flg_estado'];
            $puesto->id_usu_modifica = auth()->id();
            $puesto->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $puesto = Puesto::with([
            'tipo_entidad',
            'nivel_puesto'
        ])
            ->find($id);
        return $puesto;
    }

    public function listar()
    {
        $lista = Puesto::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Puesto::with([
            'tipo_entidad',
            'nivel_puesto'
        ])
            ->where([
                ['descripcion', 'like', '%' . $data['descripcion'] . '%'],
                ['flg_estado', '=', $data['flg_estado']]
            ])
            ->when($data['id_tipo_entidad'], function ($query) use ($data) {
                return $query->where('id_tipo_entidad', '=', $data['id_tipo_entidad']);
            })
            ->when($data['id_nivel_puesto'], function ($query) use ($data) {
                return $query->where('id_nivel_puesto', '=', $data['id_nivel_puesto']);
            })
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function filtrarPorFiltro($id_tipo_entidad, $id_nivel_puesto)
    {
        $lista = Puesto::where('flg_estado', '=', true)
            ->where([
                ['id_tipo_entidad', '=', $id_tipo_entidad],
                ['id_nivel_puesto', '=', $id_nivel_puesto]
            ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
