<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPostulacion extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_TIPO_POSTULACION';
    protected $primaryKey = 'id_tipo_postulacion';

    protected $fillable = [
        'descripcion',
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
