<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GobiernoLocalPostulacion extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GEND_GOBIERNO_LOCAL_POSTULACION';
    protected $primaryKey = 'id_gobierno_local_postulacion';

    protected $fillable = [
        'nombre_alcalde',
        'email',
        'telefono',
        'nro_resolucion_pdlc',
        'nro_resolucion_pei',
        'nro_resolucion_pel',
        'gerencia_oficina_area',
        'funcion_mof',
        'espacios_coordinacion_ig_is',
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

    public function gobierno_local()
    {
        return $this->belongsTo('App\GobiernoLocal', 'id_gobierno_local');
    }
}
