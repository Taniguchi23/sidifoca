<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegimenLaboral extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_REGIMEN_LABORAL';
    protected $primaryKey = 'id_regimen_laboral';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function arr_contrato()
    {
        return $this->hasMany('App\Contrato', 'id_contrato');
    }
}
