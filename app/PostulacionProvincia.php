<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostulacionProvincia extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_POSTULACION_PROVINCIA';
    protected $primaryKey = 'id_postulacion_provincia';

    protected $fillable = [
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

    public function provincia()
    {
        return $this->belongsTo('App\Provincia', 'id_provincia');
    }
}
