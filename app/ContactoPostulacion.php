<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactoPostulacion extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_CONTACTO_POSTULACION';
    protected $primaryKey = 'id_contacto_postulacion';

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
}
