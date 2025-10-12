<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GENM_PERFIL';
    protected $primaryKey = 'id_perfil';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function arr_perfil_permiso()
    {
        return $this->hasMany('App\PerfilPermiso', 'id_perfil');
    }

    public function arr_perfil_menu()
    {
        return $this->hasMany('App\PerfilMenu', 'id_perfil');
    }

    public function arr_usuario_perfil()
    {
        return $this->hasMany('App\UsuarioPerfil', 'id_perfil');
    }
}
