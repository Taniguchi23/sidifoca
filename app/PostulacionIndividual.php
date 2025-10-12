<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class PostulacionIndividual extends Model
{
    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GENM_POSTULACION';
    protected $primaryKey = 'id_postulacion';

    protected $fillable = [
        'codigo',
        'buena_practica',
        'nro_meses',
        'nro_dias',
        'url_declaracion_representante',
        'url_declaracion_equipo',
        'url_acta_modalidad_colectiva',
        'url_documento_imagen',
        'url_video',
        'fecha_envio',
        'observacion',
        'flg_editado',
        'flg_enviado',
        'flg_aprobado',
        'flg_calificado',
        'flg_ganador',
        'flg_terminado',
        'flg_estado'
    ];

    protected $hidden = [
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    protected $casts = [
        'fecha_envio' => 'datetime'
    ];

    public function concurso()
    {
        return $this->belongsTo('App\Concurso', 'id_concurso');
    }

    public function modalidad()
    {
        return $this->belongsTo('App\Modalidad', 'id_modalidad');
    }

    public function tipo_postulacion()
    {
        return $this->belongsTo('App\TipoPostulacion', 'id_tipo_postulacion');
    }

    public function dre_gre()
    {
        return $this->belongsTo('App\DreGre', 'id_dre_gre');
    }

    public function ugel()
    {
        return $this->belongsTo('App\Ugel', 'id_ugel');
    }

    public function gobierno_regional()
    {
        return $this->belongsTo('App\GobiernoRegional', 'id_gobierno_regional');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Categoria', 'id_categoria');
    }

    public function tema()
    {
        return $this->belongsTo('App\Tema', 'id_tema');
    }

    public function director()
    {
        return $this->hasOne('App\Director', 'id_director');
    }

    public function contacto_postulacion()
    {
        return $this->hasOne('App\ContactoPostulacion', 'id_contacto_postulacion');
    }

    public function arr_respuesta()
    {
        return $this->hasMany('App\Respuesta', 'id_postulacion');
    }

    public function arr_equipo_postulacion()
    {
        return $this->hasMany('App\EquipoPostulacion', 'id_postulacion');
    }
}
