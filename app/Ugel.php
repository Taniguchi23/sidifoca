<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ugel extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_UGEL';
    protected $primaryKey = 'id_ugel';

    protected $fillable = [
        'descripcion',
        'flg_grupo_especial',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function dre_gre()
    {
        return $this->belongsTo('App\DreGre', 'id_dre_gre');
    }
}
