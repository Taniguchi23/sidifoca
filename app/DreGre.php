<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DreGre extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_DRE_GRE';
    protected $primaryKey = 'id_dre_gre';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function arr_ugel()
    {
        return $this->hasMany('App\Ugel', 'id_dre_gre');
    }
}
