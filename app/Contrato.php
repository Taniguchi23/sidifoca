<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GENM_CONTRATO';
    protected $primaryKey = 'id_contrato';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'url_documento',
        'flg_estado',
        'flg_ejerce_cargo'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }

    public function tipo_entidad()
    {
        return $this->belongsTo('App\TipoEntidad', 'id_tipo_entidad');
    }

    public function dre_gre()
    {
        return $this->belongsTo('App\DreGre', 'id_dre_gre');
    }

    public function ugel()
    {
        return $this->belongsTo('App\Ugel', 'id_ugel');
    }

    public function entidad_externa()
    {
        return $this->belongsTo('App\EntidadExterna', 'id_entidad_externa');
    }

    public function nivel_puesto()
    {
        return $this->belongsTo('App\NivelPuesto', 'id_nivel_puesto');
    }

    public function puesto()
    {
        return $this->belongsTo('App\Puesto', 'id_puesto');
    }

    public function regimen_laboral()
    {
        return $this->belongsTo('App\RegimenLaboral', 'id_regimen_laboral');
    }

    public function nivel_educativo()
    {
        return $this->belongsTo('App\NivelEducativo', 'id_nivel_educativo');
    }

    public function profesion()
    {
        return $this->belongsTo('App\Profesion', 'id_profesion');
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'id_area');
    }

    public function setFechaInicioAttribute($value)
    {
        $this->attributes['fecha_inicio'] = is_null($value) ? null : Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function setFechaFinAttribute($value)
    {
        $this->attributes['fecha_fin'] = is_null($value) ? null : Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getFechaInicioAttribute($value)
    {
        return is_null($value) ? null : Carbon::parse($value)->format('d/m/Y');
    }

    public function getFechaFinAttribute($value)
    {
        return is_null($value) ? null : Carbon::parse($value)->format('d/m/Y');
    }
}
