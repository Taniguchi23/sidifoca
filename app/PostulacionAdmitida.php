<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostulacionAdmitida extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GENM_POSTULACION_ADMITIDA';
    protected $primaryKey = 'id_postulacion_admitida';

    protected $fillable = [
        'puntaje_total',
        'comentario',
        'flg_finalista',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function postulacion()
    {
        return $this->belongsTo('App\Postulacion', 'id_postulacion');
    }

    public function arr_calificacion()
    {
        return $this->hasMany('App\Calificacion', 'id_postulacion_admitida');
    }
}
