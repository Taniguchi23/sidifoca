<?php

namespace App\Repositories;

use App\Calificacion;
use App\Postulacion;
use App\PostulacionAdmitida;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostulacionConcursoRepository
{
    protected $individual;
    protected $colectiva;
    protected $completo;
    protected $incompleto;
    protected $rechazado;

    public function __construct()
    {
        $this->individual = config('constants.modalidad.individual');
        $this->colectiva = config('constants.modalidad.colectiva');
        $this->completo = config('constants.estado.completo');
        $this->incompleto = config('constants.estado.incompleto');
        $this->rechazado = config('constants.estado.rechazado');
    }

    public function vigente($id)
    {
        $postulacion = DB::table('T_GENM_POSTULACION')
            ->join('T_GENM_CONCURSO', 'T_GENM_CONCURSO.id_concurso', '=', 'T_GENM_POSTULACION.id_concurso')
            ->select('T_GENM_POSTULACION.*')
            ->where([
                ['T_GENM_CONCURSO.fecha_inicio', '<=', Carbon::now()],
                ['T_GENM_CONCURSO.fecha_termino', '>=', Carbon::now()],
                ['T_GENM_CONCURSO.flg_estado', '=', true],
                ['T_GENM_POSTULACION.flg_estado', '=', true],
                ['T_GENM_POSTULACION.id_postulacion', '=', $id]
            ])
            ->first();
        return $postulacion;
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
                'arr_equipo_gobierno_local.cargo'
            ])
                ->where([
                    ['flg_estado', '=', true],
                    ['flg_enviado', '=', true],
                    ['flg_aprobado', '=', false],
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
            $postulacion = Postulacion::where([
                ['flg_estado', '=', true],
                ['flg_enviado', '=', true],
                ['flg_aprobado', '=', false],
                ['id_postulacion', '=', $id]
            ])
                ->first();
            DB::transaction(function () use ($postulacion, $data) {
                switch ($data['estado']) {
                    case $this->completo:
                        $postulacion->flg_aprobado = true;
                        $postulacion_admitida = new PostulacionAdmitida();
                        $postulacion_admitida->id_postulacion = $postulacion->id_postulacion;
                        $postulacion_admitida->puntaje_total = 0;
                        $postulacion_admitida->flg_estado = true;
                        $postulacion_admitida->id_usu_ingresa = auth()->id();
                        $postulacion_admitida->save();
                        $arr_criterio = DB::table('T_MAE_CRITERIO')
                            ->where([
                                ['id_modalidad', '=', $postulacion->id_modalidad],
                                ['flg_estado', '=', true]
                            ])
                            ->get();
                        foreach ($arr_criterio as $criterio) {
                            $calificacion = new Calificacion();
                            $calificacion->id_postulacion_admitida = $postulacion_admitida->id_postulacion_admitida;
                            $calificacion->id_criterio = $criterio->id_criterio;
                            $calificacion->puntaje = 0;
                            $calificacion->flg_estado = true;
                            $calificacion->id_usu_ingresa = auth()->id();
                            $calificacion->save();
                        }
                        break;
                    case $this->incompleto:
                        $postulacion->fecha_envio = null;
                        $postulacion->flg_enviado = false;
                        break;
                    case $this->rechazado:
                        $postulacion->flg_estado = false;
                        break;
                }
                $postulacion->observacion = $data['observacion'];
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
            'tema'
        ])
            ->where([
                ['flg_estado', '=', true],
                ['flg_enviado', '=', true],
                ['flg_aprobado', '=', false],
                ['buena_practica', 'like', '%' . $data['buena_practica'] . '%']
            ])
            ->whereHas('concurso', function ($query) {
                $query->where('flg_estado', '=', true);
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
