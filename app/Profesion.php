<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_PROFESION';
    protected $primaryKey = 'id_profesion';

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
