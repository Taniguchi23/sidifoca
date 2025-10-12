<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoGobiernoLocal extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_EQUIPO_GOBIERNO_LOCAL';
    protected $primaryKey = 'id_equipo_gobierno_local';

    protected $fillable = [
        'nro_dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'telefono',
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

    public function cargo()
    {
        return $this->belongsTo('App\Cargo', 'id_cargo');
    }
}
