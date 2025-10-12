<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_PUESTO';
    protected $primaryKey = 'id_puesto';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function tipo_entidad()
    {
        return $this->belongsTo('App\TipoEntidad', 'id_tipo_entidad');
    }

    public function nivel_puesto()
    {
        return $this->belongsTo('App\NivelPuesto', 'id_nivel_puesto');
    }

    public function arr_contrato()
    {
        return $this->hasMany('App\Contrato', 'id_contrato');
    }
}
