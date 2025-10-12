<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use GoldSpecDigital\LaravelEloquentUUID\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const CREATED_AT = 'fec_ingreso';
    const UPDATED_AT = 'fec_modifica';

    protected $table = 'T_GENM_USUARIO';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'username',
        'email',
        'password',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'nro_documento',
        'fecha_nacimiento',
        'telefono_fijo',
        'telefono_celular',
        'direccion',
        'url_fotografia',
        'url_carnet_conadis',
        'flg_discapacidad',
        'flg_usu_admin',
        'flg_estado',
        'flg_reniec'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'id_usu_ingresa',
        'id_usu_modifica'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tipo_documento()
    {
        return $this->belongsTo('App\TipoDocumento', 'id_tipo_documento');
    }

    public function genero()
    {
        return $this->belongsTo('App\Genero', 'id_genero');
    }

    public function arr_contrato()
    {
        return $this->hasMany('App\Contrato', 'id_usuario');
    }

    public function arr_usuario_perfil()
    {
        return $this->hasMany('App\UsuarioPerfil', 'id_usuario');
    }

    public function setFechaNacimientoAttribute($value)
    {
        return $this->attributes['fecha_nacimiento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getFechaNacimientoAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
