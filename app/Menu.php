<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_MAE_MENU';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'p_id_menu',
        'descripcion',
        'ruta',
        'posicion',
        'icono',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function children()
    {
        return $this->hasMany('App\Menu', 'p_id_menu', 'id_menu');
    }

    public function parent()
    {
        return $this->hasOne('App\Menu', 'id_menu', 'p_id_menu');
    }

    public function arr_perfil_menu()
    {
        return $this->hasMany('App\PerfilMenu', 'id_menu');
    }
}
