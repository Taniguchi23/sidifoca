<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPerfil extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_USUARIO_PERFIL';
    protected $primaryKey = 'id_usuario_perfil';

    protected $fillable = [
        'descripcion',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }

    public function perfil()
    {
        return $this->belongsTo('App\Perfil', 'id_perfil');
    }
}
