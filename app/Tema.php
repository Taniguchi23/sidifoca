<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_TEMA';
    protected $primaryKey = 'id_tema';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Categoria', 'id_categoria');
    }
}
