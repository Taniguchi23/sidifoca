<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_CARGO';
    protected $primaryKey = 'id_cargo';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function tipo_entidad()
    {
        return $this->belongsTo('App\TipoEntidad', 'id_tipo_entidad');
    }
}
