<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilPermiso extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_PERFIL_PERMISO';
    protected $primaryKey = 'id_perfil_permiso';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function perfil()
    {
        return $this->belongsTo('App\Perfil', 'id_perfil');
    }

    public function permiso()
    {
        return $this->belongsTo('App\Permiso', 'id_permiso');
    }
}
