<?php

namespace App\Repositories;

use App\Cargo;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CargoRepository
{
    protected $ugel;
    protected $externo;

    public function __construct()
    {
        $this->ugel = config('constants.tipo_entidad.ugel');
        $this->externo = config('constants.tipo_entidad.externa');
    }

    public function insertar($data)
    {
        try {
            $cargo = new Cargo();
            $cargo->id_tipo_entidad = $data['id_tipo_entidad'];
            $cargo->descripcion = $data['descripcion'];
            $cargo->flg_estado = true;
            $cargo->id_usu_ingresa = auth()->id();
            $cargo->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $cargo = Cargo::find($id);
            $cargo->id_tipo_entidad = $data['id_tipo_entidad'];
            $cargo->descripcion = $data['descripcion'];
            $cargo->flg_estado = $data['flg_estado'];
            $cargo->id_usu_modifica = auth()->id();
            $cargo->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $cargo = Cargo::with('tipo_entidad')
            ->find($id);
        return $cargo;
    }

    public function listar()
    {
        $lista = Cargo::where('flg_estado', '=', true)
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Cargo::with('tipo_entidad')
            ->where([
                ['flg_estado', '=', $data['flg_estado']],
                ['descripcion', 'like', '%' . $data['descripcion'] . '%']
            ])
            ->when($data['id_tipo_entidad'], function ($query) use ($data) {
                return $query->where([
                    ['id_tipo_entidad', '=', $data['id_tipo_entidad']]
                ]);
            })
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function interno($id_postulacion)
    {
        $tipo_entidad = DB::table('T_MAE_TIPO_ENTIDAD')
            ->join('T_MAE_TIPO_POSTULACION', 'T_MAE_TIPO_POSTULACION.id_tipo_entidad', '=', 'T_MAE_TIPO_ENTIDAD.id_tipo_entidad')
            ->join('T_GENM_POSTULACION', 'T_GENM_POSTULACION.id_tipo_postulacion', '=', 'T_MAE_TIPO_POSTULACION.id_tipo_postulacion')
            ->select('T_MAE_TIPO_ENTIDAD.*')
            ->where([
                ['T_GENM_POSTULACION.id_postulacion', '=', $id_postulacion],
                ['T_MAE_TIPO_ENTIDAD.flg_estado', '=', true]
            ])
            ->first();
        $lista = Cargo::where([
            ['flg_estado', '=', true],
            ['id_tipo_entidad', '=', $tipo_entidad ? $tipo_entidad->id_tipo_entidad : null]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function externo()
    {
        $lista = Cargo::where('flg_estado', '=', true)
            ->whereIn('id_tipo_entidad', [$this->externo])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function soloUgel()
    {
        $lista = Cargo::where([
            ['flg_estado', '=', true],
            ['id_tipo_entidad', '=', $this->ugel]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }
}
