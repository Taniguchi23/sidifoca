<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactoGobiernoLocal extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_CONTACTO_GOBIERNO_LOCAL';
    protected $primaryKey = 'id_contacto_gobierno_local';

    protected $fillable = [
        'nro_dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono_fijo',
        'telefono_celular',
        'email',
        'flg_estado'
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
