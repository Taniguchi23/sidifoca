<?php

namespace App\Repositories;

use App\Concurso;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConcursoRepository
{
    public function insertar($data)
    {
        try {
            DB::transaction(function () use ($data) {
                DB::table('T_GENM_CONCURSO')
                    ->where('flg_estado', '=', true)
                    ->update([
                        'flg_estado' => false,
                        'id_usu_modifica' => auth()->id()
                    ]);
                $concurso = new Concurso();
                $concurso->descripcion = $data['descripcion'];
                $concurso->fecha_inicio = $data['fecha_inicio'];
                $concurso->fecha_termino = $data['fecha_termino'];
                if (isset($data['url_bases_concurso']))
                    $concurso->url_bases_concurso = $data['url_bases_concurso']->store('uploads');
                if (isset($data['url_acta_modalidad_colectiva']))
                    $concurso->url_acta_modalidad_colectiva = $data['url_acta_modalidad_colectiva']->store('uploads');
                $concurso->flg_estado = true;
                $concurso->id_usu_ingresa = auth()->id();
                $concurso->save();
            });
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            DB::transaction(function () use ($id, $data) {
                if ($data['flg_estado']) {
                    DB::table('T_GENM_CONCURSO')
                        ->where('flg_estado', '=', true)
                        ->update([
                            'flg_estado' => false,
                            'id_usu_modifica' => auth()->id()
                        ]);
                }
                $concurso = Concurso::find($id);
                $concurso->descripcion = $data['descripcion'];
                $concurso->fecha_inicio = $data['fecha_inicio'];
                $concurso->fecha_termino = $data['fecha_termino'];
                if (isset($data['url_bases_concurso']))
                    $concurso->url_bases_concurso = $data['url_bases_concurso']->store('uploads');
                if (isset($data['url_acta_modalidad_colectiva']))
                    $concurso->url_acta_modalidad_colectiva = $data['url_acta_modalidad_colectiva']->store('uploads');
                $concurso->flg_estado = $data['flg_estado'];
                $concurso->id_usu_modifica = auth()->id();
                $concurso->save();
            });
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $concurso = Concurso::find($id);
        return $concurso;
    }

    public function listar()
    {
        $lista = Concurso::where('flg_estado', '=', true)
            ->orderBy('flg_estado', 'desc')
            ->orderBy('fecha_termino', 'asc')
            ->get();
        return $lista;
    }

    public function todo()
    {
        $lista = Concurso::select([
            'id_concurso',
            DB::raw('CASE WHEN flg_estado = 1 THEN CONCAT(descripcion, " (VIGENTE)") ELSE descripcion END AS descripcion')
        ])
            ->orderBy('flg_estado', 'desc')
            ->orderBy('fecha_termino', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = Concurso::where([
            ['flg_estado', '=', $data['flg_estado']],
            ['descripcion', 'like', '%' . $data['descripcion'] . '%']
        ])
            ->orderBy('descripcion', 'asc')
            ->paginate($limit);
        return $rpta;
    }

    public function basesConcurso($id_concurso)
    {
        $rpta = DB::table('T_GENM_CONCURSO')
            ->select('url_bases_concurso')
            ->where('id_concurso', '=', $id_concurso)
            ->first();
        return empty($rpta) ? null : $rpta->url_bases_concurso;
    }

    public function bpgActaAcuerdosColectiva($id_concurso)
    {
        $rpta = DB::table('T_GENM_CONCURSO')
            ->select('url_acta_modalidad_colectiva')
            ->where('id_concurso', '=', $id_concurso)
            ->first();
        return empty($rpta) ? null : $rpta->url_acta_modalidad_colectiva;
    }

    public function activo()
    {
        $concurso = Concurso::where('flg_estado', '=', true)
            ->first();
        return $concurso;
    }

    public function vigente()
    {
        $concurso = Concurso::where([
            ['fecha_inicio', '<=', Carbon::now()->toDateString()],
            ['fecha_termino', '>=', Carbon::now()->toDateString()],
            ['flg_estado', '=', true]
        ])->first();
        return $concurso;
    }

    public function basesConcursoVigente()
    {
        $rpta = DB::table('T_GENM_CONCURSO')
            ->select('url_bases_concurso')
            ->where([
                ['fecha_inicio', '<=', Carbon::now()->toDateString()],
                ['fecha_termino', '>=', Carbon::now()->toDateString()],
                ['flg_estado', '=', true]
            ])
            ->first();
        return empty($rpta) ? null : $rpta->url_bases_concurso;
    }

    public function bpgActaAcuerdosColectivaVigente()
    {
        $rpta = DB::table('T_GENM_CONCURSO')
            ->select('url_acta_modalidad_colectiva')
            ->where([
                ['fecha_inicio', '<=', Carbon::now()->toDateString()],
                ['fecha_termino', '>=', Carbon::now()->toDateString()],
                ['flg_estado', '=', true]
            ])
            ->first();
        return empty($rpta) ? null : $rpta->url_acta_modalidad_colectiva;
    }
}
