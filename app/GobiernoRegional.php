<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GobiernoRegional extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_GOBIERNO_REGIONAL';
    protected $primaryKey = 'id_gobierno_regional';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];
}
