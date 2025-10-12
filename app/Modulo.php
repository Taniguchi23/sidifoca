<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_MODULO';
    protected $primaryKey = 'id_modulo';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function arr_permiso()
    {
        return $this->hasMany('App\Permiso', 'id_modulo');
    }
}
