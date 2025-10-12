<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BancoContrasena extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_BANCO_CONTRASENA';
    protected $primaryKey = 'id_banco_contrasena';

    protected $fillable = [
        'password'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }
}
