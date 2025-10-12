<?php

namespace App\Repositories;

use App\Contrato;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContratoRepository
{
    protected $dre_gre;
    protected $ugel;
    protected $minedu;
    protected $externa;

    public function __construct()
    {
        $this->dre_gre = config('constants.tipo_entidad.dre_gre');
        $this->ugel = config('constants.tipo_entidad.ugel');
        $this->minedu = config('constants.tipo_entidad.minedu');
        $this->externa = config('constants.tipo_entidad.externa');
    }

    public function insertar($data)
    {
        try {
            $contrato = new Contrato();
            $contrato->id_usuario = $data['id_usuario'];
            $contrato->id_tipo_entidad = $data['id_tipo_entidad'];
            $contrato->id_dre_gre = $data['id_dre_gre'];
            $contrato->id_ugel = $data['id_ugel'];
            $contrato->id_entidad_externa = $data['id_entidad_externa'];
            $contrato->id_nivel_puesto = $data['id_nivel_puesto'];
            $contrato->id_puesto = $data['id_puesto'];
            $contrato->id_area = $data['id_area'];
            $contrato->id_regimen_laboral = $data['id_regimen_laboral'];
            $contrato->id_nivel_educativo = $data['id_nivel_educativo'];
            $contrato->id_profesion = $data['id_profesion'];
            $contrato->fecha_inicio = $data['fecha_inicio'];
            $contrato->fecha_fin = $data['fecha_fin'];
            $contrato->flg_ejerce_cargo = $data['flg_ejerce_cargo'] ?? false;
            if (isset($data['url_documento']))
                $contrato->url_documento = $data['url_documento']->store('uploads');
            $contrato->flg_estado = true;
            DB::transaction(function () use ($contrato, $data) {
                DB::table('T_GENM_CONTRATO')
                    ->where('id_usuario', '=', $data['id_usuario'])
                    ->update([
                        'flg_estado' => false,
                        'id_usu_modifica' => auth()->id()
                    ]);
                $contrato->id_usu_ingresa = auth()->id();
                $contrato->save();
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
            $contrato = Contrato::find($id);
            $contrato->id_tipo_entidad = $data['id_tipo_entidad'];
            $contrato->id_dre_gre = $data['id_dre_gre'];
            $contrato->id_ugel = $data['id_ugel'];
            $contrato->id_entidad_externa = $data['id_entidad_externa'];
            $contrato->id_nivel_puesto = $data['id_nivel_puesto'];
            $contrato->id_puesto = $data['id_puesto'];
            $contrato->id_area = $data['id_area'];
            $contrato->id_regimen_laboral = $data['id_regimen_laboral'];
            $contrato->id_nivel_educativo = $data['id_nivel_educativo'];
            $contrato->id_profesion = $data['id_profesion'];
            $contrato->fecha_inicio = $data['fecha_inicio'];
            $contrato->fecha_fin = $data['fecha_fin'];
            if (isset($data['url_documento']))
                $contrato->url_documento = $data['url_documento']->store('uploads');
            $contrato->flg_ejerce_cargo = $data['flg_ejerce_cargo'] ?? false;
            $contrato->flg_estado = true;
            $contrato->id_usu_modifica = auth()->id();
            switch ($data['id_tipo_entidad']) {
                case $this->dre_gre:
                    $contrato->id_ugel = null;
                    $contrato->id_entidad_externa = null;
                    break;
                case $this->ugel:
                    $contrato->id_entidad_externa = null;
                    break;
                case $this->minedu:
                    $contrato->id_dre_gre = null;
                    $contrato->id_ugel = null;
                    $contrato->id_entidad_externa = null;
                    $contrato->id_area = null;
                    break;
                case $this->externa:
                    $contrato->id_dre_gre = null;
                    $contrato->id_ugel = null;
                    $contrato->id_area = null;
            }
            $contrato->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $contrato = Contrato::with([
            'usuario',
            'tipo_entidad',
            'dre_gre',
            'ugel',
            'area',
            'nivel_puesto',
            'puesto',
            'regimen_laboral',
            'nivel_educativo',
            'profesion'
        ])
            ->find($id);
        return $contrato;
    }

    public function vigente($id_usuario)
    {
        $contrato = Contrato::with([
            'tipo_entidad',
            'dre_gre',
            'ugel',
            'area',
            'nivel_puesto',
            'puesto',
            'regimen_laboral',
            'nivel_educativo',
            'profesion'
        ])
            ->where([
                ['id_usuario', '=', $id_usuario],
                ['flg_estado', '=', true]
            ])
            ->first();
        return $contrato;
    }

    public function documento($id)
    {
        $rpta = DB::table('T_GENM_CONTRATO')
            ->select('url_documento')
            ->where('id_contrato', '=', $id)
            ->first();
        return empty($rpta) ? null : $rpta->url_documento;
    }

    public function update($data)
    {
        try {
            $contrato = $this->vigente(auth()->id());
            $contrato->id_tipo_entidad = $data['id_tipo_entidad'];
            $contrato->id_dre_gre = $data['id_dre_gre'];
            $contrato->id_ugel = $data['id_ugel'];
            $contrato->id_entidad_externa = $data['id_entidad_externa'];
            $contrato->id_nivel_puesto = $data['id_nivel_puesto'];
            $contrato->id_puesto = $data['id_puesto'];
            $contrato->id_area = $data['id_area'];
            $contrato->id_regimen_laboral = $data['id_regimen_laboral'];
            $contrato->id_nivel_educativo = $data['id_nivel_educativo'];
            $contrato->id_profesion = $data['id_profesion'];
            $contrato->fecha_inicio = $data['fecha_inicio'];
            $contrato->fecha_fin = $data['fecha_fin'];
            if (isset($data['url_documento']))
                $contrato->url_documento = $data['url_documento']->store('uploads');
            $contrato->flg_ejerce_cargo = $data['flg_ejerce_cargo'] ?? false;
            $contrato->id_usu_modifica = auth()->id();
            switch ($data['id_tipo_entidad']) {
                case $this->dre_gre:
                    $contrato->id_ugel = null;
                    $contrato->id_entidad_externa = null;
                    break;
                case $this->ugel:
                    $contrato->id_entidad_externa = null;
                    break;
                case $this->minedu:
                    $contrato->id_dre_gre = null;
                    $contrato->id_ugel = null;
                    $contrato->id_entidad_externa = null;
                    $contrato->id_area = null;
                    break;
                case $this->externa:
                    $contrato->id_dre_gre = null;
                    $contrato->id_ugel = null;
                    $contrato->id_area = null;
            }
            $contrato->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }
}
