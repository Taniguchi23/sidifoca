<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoPostulacion extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_EQUIPO_POSTULACION';
    protected $primaryKey = 'id_equipo_postulacion';

    protected $fillable = [
        'nro_dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono_fijo',
        'telefono_celular',
        'email',
        'flg_estado',
        'flg_reniec'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    public function postulacion()
    {
        return $this->belongsTo('App\Postulacion', 'id_postulacion');
    }

    public function dre_gre()
    {
        return $this->belongsTo('App\DreGre', 'id_dre_gre');
    }

    public function ugel()
    {
        return $this->belongsTo('App\Ugel', 'id_ugel');
    }

    public function cargo()
    {
        return $this->belongsTo('App\Cargo', 'id_cargo');
    }
}
