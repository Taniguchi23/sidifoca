<?php

namespace App\Repositories;

use App\ContactoGobiernoLocal;
use App\ContactoPostulacion;
use App\Director;
use App\EquipoGobiernoLocal;
use App\EquipoPostulacion;
use App\GobiernoLocalPostulacion;
use App\PostulacionDistrito;
use App\PostulacionColectiva;
use App\PostulacionProvincia;
use App\PostulacionUgel;
use App\Respuesta;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostulacionColectivaRepository
{
    protected $modalidad;
    protected $tipo_postulacion_ugl;

    public function __construct()
    {
        $this->modalidad = config('constants.modalidad.colectiva');
        $this->tipo_postulacion_ugl = config('constants.tipo_postulacion.ugeles_gobierno_local');
    }

    public function insertar()
    {
        try {
            $postulacion = new PostulacionColectiva();
            $postulacion->nro_meses = 0;
            $postulacion->nro_dias = 0;
            $postulacion->flg_editado = false;
            $postulacion->flg_enviado = false;
            $postulacion->flg_aprobado = false;
            $postulacion->flg_calificado = false;
            $postulacion->flg_ganador = false;
            DB::transaction(function () use ($postulacion) {
                $concurso = DB::table('T_GENM_CONCURSO')
                    ->select('id_concurso', 'fecha_inicio')
                    ->where('flg_estado', '=', true)
                    ->first();
                $postulacion->id_concurso = $concurso->id_concurso;
                $postulacion->id_modalidad = $this->modalidad;
                do {
                    $codigo = 'MC-' . rand(pow(10, 6), pow(10, 7)) . '-' . Carbon::parse($concurso->fecha_inicio)->format('Y');
                    $count = DB::table('T_GENM_POSTULACION')
                        ->select('codigo')
                        ->where('codigo', '=', $codigo)
                        ->count();
                } while ($count > 0);
                $postulacion->codigo = $codigo;
                $postulacion->flg_estado = true;
                $postulacion->save();
                $gobierno_local_postulacion = new GobiernoLocalPostulacion();
                $gobierno_local_postulacion->id_postulacion = $postulacion->id_postulacion;
                $gobierno_local_postulacion->flg_estado = true;
                $gobierno_local_postulacion->save();
                $contacto_gobierno_local = new ContactoGobiernoLocal();
                $contacto_gobierno_local->id_postulacion = $postulacion->id_postulacion;
                $contacto_gobierno_local->flg_estado = true;
                $contacto_gobierno_local->save();
                $contacto_postulacion = new ContactoPostulacion();
                $contacto_postulacion->id_postulacion = $postulacion->id_postulacion;
                $contacto_postulacion->flg_estado = true;
                $contacto_postulacion->save();
                $arr_pregunta = DB::table('T_MAE_PREGUNTA')
                    ->join('T_MAE_DIMENSION', 'T_MAE_DIMENSION.id_dimension', '=', 'T_MAE_PREGUNTA.id_dimension')
                    ->select('T_MAE_PREGUNTA.*')
                    ->where([
                        ['T_MAE_DIMENSION.id_modalidad', '=', $this->modalidad],
                        ['T_MAE_DIMENSION.flg_estado', '=', true],
                        ['T_MAE_PREGUNTA.flg_estado', '=', true]
                    ])
                    ->orderBy('descripcion', 'asc')
                    ->get();
                foreach ($arr_pregunta as $pregunta) {
                    $respuesta = new Respuesta();
                    $respuesta->id_postulacion = $postulacion->id_postulacion;
                    $respuesta->id_dimension = $pregunta->id_dimension;
                    $respuesta->id_pregunta = $pregunta->id_pregunta;
                    $respuesta->flg_estado = true;
                    $respuesta->save();
                }
            });
            return ['success' => true, 'data' => $postulacion];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        try {
            $postulacion = DB::table('T_GENM_POSTULACION')
                ->join('T_GEND_CONTACTO_POSTULACION', 'T_GEND_CONTACTO_POSTULACION.id_postulacion', '=', 'T_GENM_POSTULACION.id_postulacion')
                ->leftJoin('T_GEND_GOBIERNO_LOCAL_POSTULACION', 'T_GEND_GOBIERNO_LOCAL_POSTULACION.id_postulacion', '=', 'T_GENM_POSTULACION.id_postulacion')
                ->leftJoin('T_GEND_CONTACTO_GOBIERNO_LOCAL', 'T_GEND_CONTACTO_GOBIERNO_LOCAL.id_postulacion', '=', 'T_GENM_POSTULACION.id_postulacion')
                ->leftJoin('T_MAE_DRE_GRE', 'T_MAE_DRE_GRE.id_dre_gre', '=', 'T_GENM_POSTULACION.id_dre_gre')
                ->leftJoin('T_MAE_UGEL', 'T_MAE_UGEL.id_ugel', '=', 'T_GENM_POSTULACION.id_ugel')
                ->leftJoin('T_MAE_CATEGORIA', 'T_MAE_CATEGORIA.id_categoria', '=', 'T_GENM_POSTULACION.id_categoria')
                ->leftJoin('T_MAE_TEMA', 'T_MAE_TEMA.id_tema', '=', 'T_GENM_POSTULACION.id_tema')
                ->leftJoin('T_MAE_GOBIERNO_LOCAL', 'T_MAE_GOBIERNO_LOCAL.id_gobierno_local', '=', 'T_GEND_GOBIERNO_LOCAL_POSTULACION.id_gobierno_local')
                ->select([
                    'T_GENM_POSTULACION.*',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.id_gobierno_local_postulacion',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.id_gobierno_local as m_id_gobierno_local',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.nombre_alcalde as m_nombre_alcalde',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.telefono as m_telefono',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.email as m_email',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.nro_resolucion_pdlc as m_nro_resolucion_pdlc',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.nro_resolucion_pei as m_nro_resolucion_pei',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.nro_resolucion_pel as m_nro_resolucion_pel',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.gerencia_oficina_area as m_gerencia_oficina_area',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.funcion_mof as m_funcion_mof',
                    'T_GEND_GOBIERNO_LOCAL_POSTULACION.espacios_coordinacion_ig_is as m_espacios_coordinacion_ig_is',
                    'T_GEND_CONTACTO_GOBIERNO_LOCAL.id_contacto_gobierno_local',
                    'T_GEND_CONTACTO_GOBIERNO_LOCAL.nombres AS g_nombres',
                    'T_GEND_CONTACTO_GOBIERNO_LOCAL.telefono_celular AS g_telefono_celular',
                    'T_GEND_CONTACTO_GOBIERNO_LOCAL.email AS g_email',
                    'T_GEND_CONTACTO_POSTULACION.id_contacto_postulacion',
                    'T_GEND_CONTACTO_POSTULACION.nro_dni AS c_nro_dni',
                    'T_GEND_CONTACTO_POSTULACION.nombres AS c_nombres',
                    'T_GEND_CONTACTO_POSTULACION.apellido_paterno AS c_apellido_paterno',
                    'T_GEND_CONTACTO_POSTULACION.apellido_materno AS c_apellido_materno',
                    'T_GEND_CONTACTO_POSTULACION.telefono_fijo AS c_telefono_fijo',
                    'T_GEND_CONTACTO_POSTULACION.telefono_celular AS c_telefono_celular',
                    'T_GEND_CONTACTO_POSTULACION.email AS c_email',
                    'T_MAE_DRE_GRE.descripcion AS dre_gre',
                    'T_MAE_UGEL.descripcion AS ugel',
                    'T_MAE_CATEGORIA.descripcion AS categoria',
                    'T_MAE_TEMA.descripcion AS tema',
                    'T_MAE_GOBIERNO_LOCAL.descripcion AS gobierno_local'
                ])
                ->where([
                    ['T_GENM_POSTULACION.flg_estado', '=', true],
                    ['T_GENM_POSTULACION.id_postulacion', '=', $id]
                ])
                ->first();
            $postulacion->arr_respuesta = DB::table('T_GEND_RESPUESTA')
                ->join('T_MAE_PREGUNTA', 'T_MAE_PREGUNTA.id_pregunta', '=', 'T_GEND_RESPUESTA.id_pregunta')
                ->select([
                    'T_GEND_RESPUESTA.*',
                    'T_MAE_PREGUNTA.descripcion AS pregunta'
                ])
                ->where([
                    ['T_GEND_RESPUESTA.flg_estado', '=', true],
                    ['T_GEND_RESPUESTA.id_postulacion', '=', $id]
                ])
                ->orderBy('id_dimension', 'asc')
                ->get();
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
            return $postulacion;
        } catch (Exception $e) {
            return null;
        }
    }

    public function editar($id, $data)
    {
        try {
            // PENDIENTE: VALIDAR QUE NO ESTE ENVIADO ANTES FLG_EDITADO FALSE
            $postulacion = PostulacionColectiva::find($id);
            $postulacion->id_tipo_postulacion = $data['id_tipo_postulacion'];
            $postulacion->id_dre_gre = $data['id_dre_gre'];
            $postulacion->id_ugel = $data['id_ugel'];
            $postulacion->buena_practica = $data['buena_practica'];
            $postulacion->id_categoria = $data['id_categoria'];
            $postulacion->id_tema = $data['id_tema'];
            $postulacion->nro_meses = $data['nro_meses'];
            $postulacion->nro_dias = $data['nro_dias'] ?? 0;
            DB::transaction(function () use ($postulacion, $data) {
                if ($postulacion->id_tipo_postulacion == $this->tipo_postulacion_ugl) {
                    $gobierno_local_postulacion = GobiernoLocalPostulacion::find($data['id_gobierno_local_postulacion']);
                    $gobierno_local_postulacion->id_gobierno_local = $data['m_id_gobierno_local'];
                    $gobierno_local_postulacion->nombre_alcalde = Str::upper($data['m_nombre_alcalde']);
                    $gobierno_local_postulacion->telefono = $data['m_telefono'];
                    $gobierno_local_postulacion->email = Str::lower($data['m_email']);
                    $gobierno_local_postulacion->nro_resolucion_pdlc = $data['m_nro_resolucion_pdlc'];
                    $gobierno_local_postulacion->nro_resolucion_pei = $data['m_nro_resolucion_pei'];
                    $gobierno_local_postulacion->nro_resolucion_pel = $data['m_nro_resolucion_pel'];
                    $gobierno_local_postulacion->gerencia_oficina_area = $data['m_gerencia_oficina_area'];
                    $gobierno_local_postulacion->funcion_mof = $data['m_funcion_mof'];
                    $gobierno_local_postulacion->espacios_coordinacion_ig_is = $data['m_espacios_coordinacion_ig_is'];
                    $gobierno_local_postulacion->save();
                    $contacto_gobierno_local = ContactoGobiernoLocal::find($data['id_contacto_gobierno_local']);
                    $contacto_gobierno_local->nombres = Str::upper($data['g_nombres']);
                    $contacto_gobierno_local->telefono_celular = $data['g_telefono_celular'];
                    $contacto_gobierno_local->email = Str::lower($data['g_email']);
                    $contacto_gobierno_local->save();
                
                } else {
                    GobiernoLocalPostulacion::where('id_gobierno_local_postulacion', '=', $data['id_gobierno_local_postulacion'])->delete();
                    ContactoGobiernoLocal::where('id_contacto_gobierno_local', '=', $data['id_contacto_gobierno_local'])->delete();
                }
                $contacto_postulacion = ContactoPostulacion::find($data['id_contacto_postulacion']);
                $contacto_postulacion->nro_dni = $data['c_nro_dni'];
                $contacto_postulacion->nombres = Str::upper($data['c_nombres']);
                $contacto_postulacion->apellido_paterno = Str::upper($data['c_apellido_paterno']);
                $contacto_postulacion->apellido_materno = Str::upper($data['c_apellido_materno']);
                $contacto_postulacion->telefono_fijo = $data['c_telefono_fijo'];
                $contacto_postulacion->telefono_celular = $data['c_telefono_celular'];
                $contacto_postulacion->email = Str::lower($data['c_email']);
                $contacto_postulacion->flg_reniec = $data['flg_reniec'];
                $contacto_postulacion->save();
                $postulacion->fecha_envio = Carbon::now();
                $postulacion->flg_editado = true;
                $postulacion->save();
            });
            return ['success' => true, 'data' => $postulacion];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            dd($e);
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function autosave($id, $data)
    {
        try {
            $postulacion = PostulacionColectiva::find($id);
            $postulacion->id_tipo_postulacion = $data['id_tipo_postulacion'];
            $postulacion->id_dre_gre = $data['id_dre_gre'];
            $postulacion->id_ugel = $data['id_ugel'];
            $postulacion->buena_practica = $data['buena_practica'];
            $postulacion->id_categoria = $data['id_categoria'];
            $postulacion->id_tema = $data['id_tema'];
            $postulacion->nro_meses = $data['nro_meses'] ?? 0;
            $postulacion->nro_dias = $data['nro_dias'] ?? 0;
            DB::transaction(function () use ($postulacion, $data) {
                $gobierno_local_postulacion = GobiernoLocalPostulacion::find($data['id_gobierno_local_postulacion']);
                $gobierno_local_postulacion->id_gobierno_local = $data['m_id_gobierno_local'];
                $gobierno_local_postulacion->nombre_alcalde = Str::upper($data['m_nombre_alcalde']);
                $gobierno_local_postulacion->telefono = $data['m_telefono'];
                $gobierno_local_postulacion->email = Str::lower($data['m_email']);
                $gobierno_local_postulacion->nro_resolucion_pdlc = $data['m_nro_resolucion_pdlc'];
                $gobierno_local_postulacion->nro_resolucion_pei = $data['m_nro_resolucion_pei'];
                $gobierno_local_postulacion->nro_resolucion_pel = $data['m_nro_resolucion_pel'];
                $gobierno_local_postulacion->gerencia_oficina_area = $data['m_gerencia_oficina_area'];
                $gobierno_local_postulacion->funcion_mof = $data['m_funcion_mof'];
                $gobierno_local_postulacion->espacios_coordinacion_ig_is = $data['m_espacios_coordinacion_ig_is'];
                $gobierno_local_postulacion->save();
                $contacto_gobierno_local = ContactoGobiernoLocal::find($data['id_contacto_gobierno_local']);
                $contacto_gobierno_local->nombres = Str::upper($data['g_nombres']);
                $contacto_gobierno_local->telefono_celular = $data['g_telefono_celular'];
                $contacto_gobierno_local->email = Str::lower($data['g_email']);
                $contacto_gobierno_local->save();
                $contacto_postulacion = ContactoPostulacion::find($data['id_contacto_postulacion']);
                $contacto_postulacion->nro_dni = $data['c_nro_dni'];
                $contacto_postulacion->nombres = Str::upper($data['c_nombres']);
                $contacto_postulacion->apellido_paterno = Str::upper($data['c_apellido_paterno']);
                $contacto_postulacion->apellido_materno = Str::upper($data['c_apellido_materno']);
                $contacto_postulacion->telefono_fijo = $data['c_telefono_fijo'];
                $contacto_postulacion->telefono_celular = $data['c_telefono_celular'];
                $contacto_postulacion->email = Str::lower($data['c_email']);
                $contacto_postulacion->save();
                $postulacion->save();
            });
            return ['success' => true, 'data' => date("h:i:s A")];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function agregarUgel($id, $data)
    {
        try {
            $vv = PostulacionUgel::where([
                ['id_postulacion', '=', $id],
                ['id_ugel', '=', $data['id_ugel']]
            ])
                ->doesntExist();
            if ($vv) {
                $postulacion_ugel = new PostulacionUgel();
                $postulacion_ugel->id_postulacion = $id;
                $postulacion_ugel->id_ugel = $data['id_ugel'];
                $postulacion_ugel->flg_estado = true;
                $postulacion_ugel->save();
            }
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function agregarProvincia($id, $data)
    {
        try {
            $vv = PostulacionProvincia::where([
                ['id_postulacion', '=', $id],
                ['id_provincia', '=', $data['id_provincia']]
            ])
                ->doesntExist();
            if ($vv) {
                $postulacion_provincia = new PostulacionProvincia();
                $postulacion_provincia->id_postulacion = $id;
                $postulacion_provincia->id_provincia = $data['id_provincia'];
                $postulacion_provincia->flg_estado = true;
                $postulacion_provincia->save();
            }
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function agregarDistrito($id, $data)
    {
        try {
            $vv = PostulacionDistrito::where([
                ['id_postulacion', '=', $id],
                ['id_distrito', '=', $data['id_distrito']]
            ])
                ->doesntExist();
            if ($vv) {
                $postulacion_distrito = new PostulacionDistrito();
                $postulacion_distrito->id_postulacion = $id;
                $postulacion_distrito->id_distrito = $data['id_distrito'];
                $postulacion_distrito->flg_estado = true;
                $postulacion_distrito->save();
            }
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function ugeles($id)
    {
        $lista = DB::table('T_GEND_POSTULACION_UGEL')
            ->join('T_MAE_UGEL', 'T_MAE_UGEL.id_ugel', '=', 'T_GEND_POSTULACION_UGEL.id_ugel')
            ->select([
                'T_GEND_POSTULACION_UGEL.*',
                'T_MAE_UGEL.descripcion AS ugel'
            ])
            ->where([
                ['T_MAE_UGEL.flg_estado', '=', true],
                ['T_GEND_POSTULACION_UGEL.id_postulacion', '=', $id]
            ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function provincias($id)
    {
        $lista = DB::table('T_GEND_POSTULACION_PROVINCIA')
            ->join('T_MAE_PROVINCIA', 'T_MAE_PROVINCIA.id_provincia', '=', 'T_GEND_POSTULACION_PROVINCIA.id_provincia')
            ->select([
                'T_GEND_POSTULACION_PROVINCIA.*',
                'T_MAE_PROVINCIA.descripcion AS provincia'
            ])
            ->where([
                ['T_MAE_PROVINCIA.flg_estado', '=', true],
                ['T_GEND_POSTULACION_PROVINCIA.id_postulacion', '=', $id]
            ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function distritos($id)
    {
        $lista = DB::table('T_GEND_POSTULACION_DISTRITO')
            ->join('T_MAE_DISTRITO', 'T_MAE_DISTRITO.id_distrito', '=', 'T_GEND_POSTULACION_DISTRITO.id_distrito')
            ->select([
                'T_GEND_POSTULACION_DISTRITO.*',
                'T_MAE_DISTRITO.descripcion AS distrito'
            ])
            ->where([
                ['T_MAE_DISTRITO.flg_estado', '=', true],
                ['T_GEND_POSTULACION_DISTRITO.id_postulacion', '=', $id]
            ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function eliminarUgel($id, $data)
    {
        try {
            PostulacionUgel::where([
                'id_postulacion' => $id,
                'id_postulacion_ugel' => $data['id_postulacion_ugel']
            ])
                ->delete();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function eliminarProvincia($id, $data)
    {
        try {
            PostulacionProvincia::where([
                'id_postulacion' => $id,
                'id_postulacion_provincia' => $data['id_postulacion_provincia']
            ])
                ->delete();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function eliminarDistrito($id, $data)
    {
        try {
            PostulacionDistrito::where([
                'id_postulacion' => $id,
                'id_postulacion_distrito' => $data['id_postulacion_distrito']
            ])
                ->delete();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function reiniciarZonaAlcanceUgel($id, $data)
    {
        try {
            DB::transaction(function () use ($id, $data) {
                $postulacion = PostulacionColectiva::find($id);
                $postulacion->id_dre_gre = $data['id_dre_gre'];
                $postulacion->save();
                PostulacionProvincia::where('id_postulacion', '=', $id)
                    ->delete();
                PostulacionDistrito::where('id_postulacion', '=', $id)
                    ->delete();
                PostulacionUgel::where('id_postulacion', '=', $id)
                    ->delete();
                Director::where('id_postulacion', '=', $id)
                    ->delete();
                EquipoPostulacion::where('id_postulacion', '=', $id)
                    ->delete();
            });
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editarRespuesta($id, $data)
    {
        try {
            Respuesta::where([
                'id_postulacion' => $id,
                'id_respuesta' => $data['id_respuesta']
            ])
                ->update([
                    'descripcion' => $data['descripcion'],
                    'fec_modifica' => Carbon::now()
                ]);
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function listarEquipoGobiernoLocal($id)
    {
        $lista = EquipoGobiernoLocal::with('cargo')
            ->where([
                ['id_postulacion', '=', $id],
                ['flg_estado', '=', true]
            ])
            ->orderBy('id_equipo_gobierno_local', 'asc')
            ->get();
        return $lista;
    }

    public function agregarEquipoGobiernoLocal($id, $data)
    {
        try {
            $postulacion = PostulacionColectiva::with('arr_equipo_gobierno_local')
                ->find($id);
            if (count($postulacion->arr_equipo_gobierno_local) > 1) {
                return ['success' => false, 'errors' => ['*' => 'El equipo técnico del gobierno local debe tener max. 2 integrantes.']];
            }
            $equipo_gobierno_local = new EquipoGobiernoLocal();
            $equipo_gobierno_local->id_postulacion = $postulacion->id_postulacion;
            $equipo_gobierno_local->id_cargo = $data['p_id_cargo'];
            $equipo_gobierno_local->nro_dni = $data['p_nro_dni'];
            $equipo_gobierno_local->nombres = Str::upper($data['p_nombres']);
            $equipo_gobierno_local->apellido_paterno = Str::upper($data['p_apellido_paterno']);
            $equipo_gobierno_local->apellido_materno = Str::upper($data['p_apellido_materno']);
            $equipo_gobierno_local->email = Str::lower($data['p_email']);
            $equipo_gobierno_local->telefono = $data['p_telefono'];
            $equipo_gobierno_local->flg_reniec = $data['flg_reniec'];
            $equipo_gobierno_local->flg_estado = true;
            $equipo_gobierno_local->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function eliminarEquipoGobiernoLocal($id, $data)
    {
        try {
            // PENDIENTE: VALIDAR QUE ESTE ENVIADO ANTES FLG_EDITADO FALSE
            EquipoGobiernoLocal::where([
                'id_postulacion' => $id,
                'id_equipo_gobierno_local' => $data['id_equipo_gobierno_local']
            ])
                ->delete();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function listarEquipoPostulacion($id)
    {
        $lista = EquipoPostulacion::where([
            ['id_postulacion', '=', $id],
            ['flg_estado', '=', true]
        ])
            ->orderBy('id_equipo_postulacion', 'asc')
            ->get();
        return $lista;
    }

    public function agregarEquipoPostulacion($id, $data)
    {
        try {
            $director = Director::where([
                'id_director' => $data['p_id_director'],
                'id_postulacion' => $id
            ])
                ->first();
            $arr_equipo_postulacion = EquipoPostulacion::where([
                'id_dre_gre' => $director->id_dre_gre,
                'id_ugel' => $director->id_ugel,
                'id_postulacion' => $id
            ])
                ->get();
            if (count($arr_equipo_postulacion) > 3) {
                return ['success' => false, 'errors' => ['*' => 'El equipo técnico debe tener max. 4 integrantes.']];
            }
            $equipo_postulacion = new EquipoPostulacion();
            $equipo_postulacion->id_postulacion = $director->id_postulacion;
            $equipo_postulacion->id_dre_gre = $director->id_dre_gre;
            $equipo_postulacion->id_ugel = $director->id_ugel;
            $equipo_postulacion->id_cargo = $data['p_id_cargo'];
            $equipo_postulacion->nro_dni = $data['p_nro_dni'];
            $equipo_postulacion->nombres = Str::upper($data['p_nombres']);
            $equipo_postulacion->apellido_paterno = Str::upper($data['p_apellido_paterno']);
            $equipo_postulacion->apellido_materno = Str::upper($data['p_apellido_materno']);
            $equipo_postulacion->email = Str::lower($data['p_email']);
            $equipo_postulacion->telefono = $data['p_telefono'];
            $equipo_postulacion->flg_reniec = $data['flg_reniec'];
            $equipo_postulacion->flg_estado = true;
            $equipo_postulacion->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function eliminarEquipoPostulacion($id, $data)
    {
        try {
            // PENDIENTE: VALIDAR QUE ESTE ENVIADO ANTES FLG_EDITADO FALSE
            EquipoPostulacion::where([
                'id_postulacion' => $id,
                'id_equipo_postulacion' => $data['id_equipo_postulacion']
            ])
                ->delete();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function listarDirector($id)
    {
        $lista = DB::table('T_GEND_DIRECTOR')
            ->join('T_MAE_DRE_GRE', 'T_MAE_DRE_GRE.id_dre_gre', '=', 'T_GEND_DIRECTOR.id_dre_gre')
            ->leftJoin('T_MAE_UGEL', 'T_MAE_UGEL.id_ugel', '=', 'T_GEND_DIRECTOR.id_ugel')
            ->select([
                'T_GEND_DIRECTOR.*',
                'T_MAE_DRE_GRE.descripcion AS dre_gre',
                'T_MAE_UGEL.descripcion AS ugel'
            ])
            ->where([
                ['T_GEND_DIRECTOR.flg_estado', '=', true],
                ['T_GEND_DIRECTOR.id_postulacion', '=', $id]
            ])
            ->orderBy('id_director', 'asc')
            ->get();
        return $lista;
    }

    public function agregarDirector($id, $data)
    {
        try {
            $postulacion = PostulacionColectiva::with([
                'arr_postulacion_ugel',
                'arr_director'
            ])
                ->find($id);
            $max = count($postulacion->arr_postulacion_ugel);
            if (count($postulacion->arr_director) >= $max) {
                return ['success' => false, 'errors' => ['*' => 'La postulación debe tener max. ' . $max . ' director(es).']];
            }
            $director = new Director();
            $director->id_postulacion = $postulacion->id_postulacion;
            $director->id_dre_gre = $data['d_id_dre_gre'];
            $director->id_ugel = $data['d_id_ugel'];
            $director->nro_dni = $data['d_nro_dni'];
            $director->nombres = Str::upper($data['d_nombres']);
            $director->apellido_paterno = Str::upper($data['d_apellido_paterno']);
            $director->apellido_materno = Str::upper($data['d_apellido_materno']);
            $director->telefono_fijo = $data['d_telefono_fijo'];
            $director->telefono_celular = $data['d_telefono_celular'];
            $director->email = Str::lower($data['d_email']);
            $director->flg_reniec = $data['flg_reniec'];
            $director->flg_estado = true;
            $director->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function eliminarDirector($id, $data)
    {
        try {
            // PENDIENTE: VALIDAR QUE ESTE ENVIADO ANTES FLG_EDITADO FALSE
            DB::transaction(function () use ($id, $data) {
                $director = Director::where([
                    'id_postulacion' => $id,
                    'id_director' => $data['id_director']
                ])
                    ->first();
                if (isset($director)) {
                    EquipoPostulacion::where([
                        'id_postulacion' => $director->id_postulacion,
                        'id_dre_gre' => $director->id_dre_gre,
                        'id_ugel' => $director->id_ugel
                    ])
                        ->delete();
                    $director->delete();
                }
            });
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function listarDreGre($id)
    {
        $lista = DB::table('T_MAE_DRE_GRE')
            ->join('T_GENM_POSTULACION', 'T_GENM_POSTULACION.id_dre_gre', '=', 'T_MAE_DRE_GRE.id_dre_gre')
            ->select([
                'T_MAE_DRE_GRE.*'
            ])
            ->where([
                ['T_MAE_DRE_GRE.flg_estado', '=', true],
                ['T_GENM_POSTULACION.id_postulacion', '=', $id]
            ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function enviar($id, $data)
    {
        try {
            // PENDIENTE: VALIDAR QUE ESTE ENVIADO ANTES FLG_EDITADO TRUE
            $postulacion = PostulacionColectiva::find($id);
            $postulacion->url_declaracion_representante = empty($data['url_declaracion_representante'])
                ? NULL : $data['url_declaracion_representante']->store('uploads');
            $postulacion->url_declaracion_equipo = empty($data['url_declaracion_equipo'])
                ? NULL : $data['url_declaracion_equipo']->store('uploads');
            $postulacion->url_acta_modalidad_colectiva = empty($data['url_acta_modalidad_colectiva'])
                ? NULL : $data['url_acta_modalidad_colectiva']->store('uploads');
            $postulacion->url_documento_imagen = $data['url_documento_imagen'];
            $postulacion->url_video = $data['url_video'];
            $postulacion->fecha_envio = Carbon::now();
            $postulacion->flg_enviado = true;
            $postulacion->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function codigo($codigo)
    {
        $postulacion = PostulacionColectiva::where([
            ['codigo', '=', $codigo],
            ['id_modalidad', '=', $this->modalidad],
            ['flg_estado', '=', true]
        ])
            ->first();
        return $postulacion;
    }
}
