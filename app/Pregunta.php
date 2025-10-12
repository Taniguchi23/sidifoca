<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_PREGUNTA';
    protected $primaryKey = 'id_pregunta';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function dimension()
    {
        return $this->belongsTo('App\Dimension', 'id_dimension');
    }
}
