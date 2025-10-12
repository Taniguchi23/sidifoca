<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostulacionUgel extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_POSTULACION_UGEL';
    protected $primaryKey = 'id_postulacion_ugel';

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

    public function ugel()
    {
        return $this->belongsTo('App\Ugel', 'id_ugel');
    }
}
