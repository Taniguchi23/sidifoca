<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_CRITERIO';
    protected $primaryKey = 'id_criterio';

    protected $fillable = [
        'descripcion',
        'detalles',
        'puntaje_maximo',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function modalidad()
    {
        return $this->belongsTo('App\Modalidad', 'id_modalidad');
    }
}
