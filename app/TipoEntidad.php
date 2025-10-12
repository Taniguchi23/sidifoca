<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEntidad extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_TIPO_ENTIDAD';
    protected $primaryKey = 'id_tipo_entidad';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function arr_cargo()
    {
        return $this->hasMany('App\Cargo', 'id_tipo_entidad');
    }
}
