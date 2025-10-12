<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Concurso extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GENM_CONCURSO';
    protected $primaryKey = 'id_concurso';

    protected $fillable = [
        'descripcion',
        'fecha_inicio',
        'fecha_termino',
        'url_bases_concurso',
        'url_acta_modalidad_colectiva',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_termino' => 'datetime'
    ];

    public function setFechaInicioAttribute($value)
    {
        $this->attributes['fecha_inicio'] = is_null($value) ? null : Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function setFechaTerminoAttribute($value)
    {
        $this->attributes['fecha_termino'] = is_null($value) ? null : Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getFechaInicioAttribute($value)
    {
        return is_null($value) ? null : Carbon::parse($value)->format('d/m/Y');
    }

    public function getFechaTerminoAttribute($value)
    {
        return is_null($value) ? null : Carbon::parse($value)->format('d/m/Y');
    }
}
