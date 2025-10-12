<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_RESPUESTA';
    protected $primaryKey = 'id_respuesta';

    protected $fillable = [
        'descripcion',
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

    public function dimension()
    {
        return $this->belongsTo('App\Dimension', 'id_dimension');
    }

    public function pregunta()
    {
        return $this->belongsTo('App\Pregunta', 'id_pregunta');
    }
}
