<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GobiernoLocal extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_GOBIERNO_LOCAL';
    protected $primaryKey = 'id_gobierno_local';

    protected $fillable = [
        'descripcion',
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
