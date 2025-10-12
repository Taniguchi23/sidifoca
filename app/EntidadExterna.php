<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntidadExterna extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_ENTIDAD_EXTERNA';
    protected $primaryKey = 'id_entidad_externa';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];
}
