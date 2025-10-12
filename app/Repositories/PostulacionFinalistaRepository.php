<?php

namespace App\Repositories;

use App\Calificacion;
use App\Postulacion;
use App\PostulacionFinalista;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostulacionFinalistaRepository
{
    protected $individual;
    protected $colectiva;

    public function __construct()
    {
        $this->individual = config('constants.modalidad.individual');
        $this->colectiva = config('constants.modalidad.colectiva');
    }

    public function obtener($id)
    {
        try {
            $postulacion = Postulacion::with([
                'gobierno_regional',
                'tipo_postulacion',
                'dre_gre',
                'ugel',
                'arr_postulacion_ugel',
                'arr_postulacion_ugel.ugel',
                'arr_postulacion_provincia',
                'arr_postulacion_provincia.provincia',
                'arr_postulacion_distrito',
                'arr_postulacion_distrito.distrito',
                'categoria',
                'tema',
                'arr_respuesta',
                'arr_respuesta.pregunta',
                'gobierno_local_postulacion',
                'gobierno_local_postulacion.gobierno_local',
                'contacto_gobierno_local',
                'arr_director',
                'arr_director.dre_gre',
                'arr_director.ugel',
                'contacto_postulacion',
                'arr_equipo_postulacion',
                'arr_equipo_postulacion.cargo',
                'arr_equipo_gobierno_local',
                'arr_equipo_gobierno_local.cargo',
                'postulacion_admitida',
                'postulacion_admitida.arr_calificacion',
                'postulacion_admitida.arr_calificacion.criterio',
                'postulacion_finalista'
            ])
                ->where([
                    ['flg_estado', '=', true],
                    ['flg_enviado', '=', true],
                    ['flg_aprobado', '=', true],
                    ['flg_calificado', '=', true],
                    ['flg_terminado', '=', false],
                    ['id_postulacion', '=', $id]
                ])
                ->whereHas('concurso', function ($query) {
                    $query->where('flg_estado', '=', true);
                })
                ->first();
            $postulacion->arr_dimension = DB::table('T_MAE_DIMENSION')
                ->join('T_GEND_RESPUESTA', 'T_GEND_RESPUESTA.id_dimension', '=', 'T_MAE_DIMENSION.id_dimension')
                ->select('T_MAE_DIMENSION.*')
                ->where([
                    ['T_GEND_RESPUESTA.flg_estado', '=', true],
                    ['T_GEND_RESPUESTA.id_postulacion', '=', $id]
                ])
                ->orderBy('id_dimension', 'asc')
                ->distinct()
                ->get();
            $postulacion->view = ($postulacion->id_modalidad == $this->individual)
                ? "individual"
                : "colectiva";
            return $postulacion;
        } catch (Exception $e) {
            return null;
        }
    }

    public function editar($id, $data)
    {
        try {
            $postulacion = Postulacion::with('postulacion_admitida')
                ->where([
                    ['flg_estado', '=', true],
                    ['flg_enviado', '=', true],
                    ['flg_aprobado', '=', true],
                    ['flg_calificado', '=', true],
                    ['flg_terminado', '=', false],
                    ['id_postulacion', '=', $id]
                ])
                ->whereHas('postulacion_admitida', function ($query) {
                    $query->where('flg_finalista', '=', true);
                })
                ->first();
            DB::transaction(function () use ($postulacion, $data) {
                $postulacion_finalista = PostulacionFinalista::where([
                    ['flg_estado', '=', true],
                    ['id_postulacion', '=', $postulacion->id_postulacion]
                ])
                    ->first();
                $postulacion_finalista->flg_ganador =  $data['flg_ganador'];
                $postulacion_finalista->comentario =  $data['comentario'];
                $postulacion_finalista->id_usu_modifica = auth()->id();
                $postulacion_finalista->save();
                $postulacion->flg_ganador =  $data['flg_ganador'];
                $postulacion->flg_terminado =  true;
                $postulacion->id_usu_modifica = auth()->id();
                $postulacion->save();
            });
            return ['success' => true, 'data' => $postulacion];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function paginar($limit, $data)
    {
        $rpta = Postulacion::with([
            'concurso',
            'modalidad',
            'tipo_postulacion',
            'categoria',
            'tema',
            'postulacion_admitida'
        ])
            ->where([
                ['flg_estado', '=', true],
                ['flg_enviado', '=', true],
                ['flg_aprobado', '=', true],
                ['flg_calificado', '=', true],
                ['flg_terminado', '=', false],
                ['buena_practica', 'like', '%' . $data['buena_practica'] . '%']
            ])
            ->whereHas('concurso', function ($query) {
                $query->where('flg_estado', '=', true);
            })
            ->whereHas('postulacion_admitida', function ($query) {
                $query->where('flg_finalista', '=', true);
            })
            ->when($data['id_modalidad'], function ($query) use ($data) {
                return $query->where('id_modalidad', '=', $data['id_modalidad']);
            })
            ->when($data['id_tipo_postulacion'], function ($query) use ($data) {
                return $query->where('id_tipo_postulacion', '=', $data['id_tipo_postulacion']);
            })
            ->when($data['id_categoria'], function ($query) use ($data) {
                return $query->where('id_categoria', '=', $data['id_categoria']);
            })
            ->when($data['id_tema'], function ($query) use ($data) {
                return $query->where('id_tema', '=', $data['id_tema']);
            })
            ->orderBy('fecha_envio', 'desc')
            ->paginate($limit);
        return $rpta;
    }

    public function declaracionRepresentante($id)
    {
        $rpta = DB::table('T_GENM_POSTULACION')
            ->select('url_declaracion_representante')
            ->where('id_postulacion', '=', $id)
            ->first();
        return empty($rpta) ? null : $rpta->url_declaracion_representante;
    }

    public function declaracionEquipo($id)
    {
        $rpta = DB::table('T_GENM_POSTULACION')
            ->select('url_declaracion_equipo')
            ->where('id_postulacion', '=', $id)
            ->first();
        return empty($rpta) ? null : $rpta->url_declaracion_equipo;
    }

    public function actaModalidadColectiva($id)
    {
        $rpta = DB::table('T_GENM_POSTULACION')
            ->select('url_acta_modalidad_colectiva')
            ->where('id_postulacion', '=', $id)
            ->first();
        return empty($rpta) ? null : $rpta->url_acta_modalidad_colectiva;
    }
}
