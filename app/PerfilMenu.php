<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilMenu extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_PERFIL_MENU';
    protected $primaryKey = 'id_perfil_menu';

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

    public function menu()
    {
        return $this->belongsTo('App\Menu', 'id_menu');
    }
}
