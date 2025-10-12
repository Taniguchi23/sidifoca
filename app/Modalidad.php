<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_MODALIDAD';
    protected $primaryKey = 'id_modalidad';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function arr_tipo_postulacion()
    {
        return $this->hasMany('App\TipoPostulacion', 'id_modalidad');
    }

    public function arr_dimension()
    {
        return $this->hasMany('App\Dimension', 'id_modalidad');
    }

    public function arr_criterio()
    {
        return $this->hasMany('App\Criterio', 'id_modalidad');
    }
}
