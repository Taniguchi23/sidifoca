<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_CALIFICACION';
    protected $primaryKey = 'id_calificacion';

    protected $fillable = [
        'puntaje',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function postulacion_admitida()
    {
        return $this->belongsTo('App\PostulacionAdmitida', 'id_postulacion_admitida');
    }

    public function criterio()
    {
        return $this->belongsTo('App\Criterio', 'id_criterio');
    }
}
