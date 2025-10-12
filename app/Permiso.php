<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_PERMISO';
    protected $primaryKey = 'id_permiso';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function modulo()
    {
        return $this->belongsTo('App\Modulo', 'id_modulo');
    }

    public function arr_perfil_permiso()
    {
        return $this->hasMany('App\PerfilPermiso', 'id_permiso');
    }
}
  