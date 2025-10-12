<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostulacionFinalista extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GENM_POSTULACION_FINALISTA';
    protected $primaryKey = 'id_postulacion_finalista';

    protected $fillable = [
        'comentario',
        'flg_ganador',
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
}
