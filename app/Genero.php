<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_GENERO';
    protected $primaryKey = 'id_genero';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function arr_usuario()
    {
        return $this->hasMany('App\User', 'id_usuario');
    }
}
