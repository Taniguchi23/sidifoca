<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_DISTRITO';
    protected $primaryKey = 'id_distrito';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function provincia()
    {
        return $this->belongsTo('App\Provincia', 'id_provincia');
    }
}
