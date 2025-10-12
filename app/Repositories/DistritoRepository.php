<?php

namespace App\Repositories;

use App\Distrito;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DistritoRepository
{
    public function insertar($data)
    {
        try {
            $distrito = new Distrito();
            $distrito->id_provincia = $data['id_provincia'];
            $distrito->descripcion = $data['descripcion'];
            $distrito->flg_estado = true;
            $distrito->id_usu_ingresa = auth()->id();
            $distrito->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $distrito = Distrito::find($id);
            $distrito->id_provincia = $data['id_provincia'];
            $distrito->descripcion = $data['descripcion'];
            $distrito->flg_estado = $data['flg_estado'];
            $distrito->id_usu_modifica = auth()->id();
            $distrito->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $distrito = Distrito::with('provincia')
            ->find($id);
        return $distrito;
    }

    public function listar()
    {
        $lista = Distrito::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Distrito::with([
            'provincia',
            'provincia.dre_gre'
        ])
            ->where([
                ['flg_estado', '=', $data['flg_estado']],
                ['descripcion', 'like', '%' . $data['descripcion'] . '%']
            ])
            ->when($data['id_provincia'], function ($query) use ($data) {
                return $query->where([
                    ['id_provincia', '=', $data['id_provincia']]
                ]);
            })
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function filtrarPorPostulacion($id_postulacion)
    {
        $lista = DB::table('T_MAE_DISTRITO')
            ->join('T_GEND_POSTULACION_PROVINCIA', 'T_GEND_POSTULACION_PROVINCIA.id_provincia', '=', 'T_MAE_DISTRITO.id_provincia')
            ->select('T_MAE_DISTRITO.*')
            ->where([
                ['T_GEND_POSTULACION_PROVINCIA.id_postulacion', '=', $id_postulacion],
                ['T_MAE_DISTRITO.flg_estado', '=', true]
            ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
