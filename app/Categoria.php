<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_CATEGORIA';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function arr_tema()
    {
        return $this->hasMany('App\Tema', 'id_Categoria');
    }
}
