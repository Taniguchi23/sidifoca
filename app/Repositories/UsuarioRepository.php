<?php

namespace App\Repositories;

use App\BancoContrasena;
use App\Contrato;
use App\Exceptions\SoapException;
use App\User;
use App\UsuarioPerfil;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UsuarioRepository
{
    protected $url;
    protected $security_key;

    public function __construct()
    {
        $this->url = config('soap.url');
        $this->security_key = config('soap.security_key');
    }

    public function insertar($data, $random)
    {
        try {
            $usuario = new User();
            $usuario->id_tipo_documento = $data['id_tipo_documento'];
            $usuario->id_genero = $data['id_genero'];
            $usuario->email = $data['email'];
            $usuario->apellido_paterno = Str::upper($data['apellido_paterno']);
            $usuario->apellido_materno = Str::upper($data['apellido_materno']);
            $usuario->nombres = Str::upper($data['nombres']);
            $usuario->nro_documento = $data['nro_documento'];
            $usuario->fecha_nacimiento = $data['fecha_nacimiento'];
            $usuario->telefono_fijo = $data['telefono_fijo'];
            $usuario->telefono_celular = $data['telefono_celular'];
            $usuario->direccion = $data['direccion'];
            if (isset($data['url_fotografia']))
                $usuario->url_fotografia = $data['url_fotografia']->store('uploads');
            if (isset($data['url_carnet_conadis']))
                $usuario->url_carnet_conadis = $data['url_carnet_conadis']->store('uploads');
            $usuario->flg_discapacidad = $data['flg_discapacidad'];
            $usuario->flg_estado = true;
            DB::transaction(function () use ($usuario, $data, $random) {
                $count = 0;
                
                $u_nombres = str_replace(['ñ', 'Ñ'], 'n', $data['nombres']);
                $u_apellido_paterno = str_replace(['ñ', 'Ñ'], 'n', $data['apellido_paterno']);

                $username = Str::upper($u_nombres[0] . $u_apellido_paterno);
                while (DB::table('T_GENM_USUARIO')->where('username', '=',  $username)->count() > 0) {
                    $count++;
                    $username = Str::upper($u_nombres[0] . $u_apellido_paterno) . $count;
                }
                $usuario->username = $username;
                $usuario->password = bcrypt($random);
                $usuario->id_usu_ingresa = auth()->id();
                $usuario->flg_reniec = $data['flg_reniec'];
                $usuario->save();

                $banco = new BancoContrasena();
                $banco->id_usuario = $usuario->id_usuario;
                $banco->password = $usuario->password;
                $banco->flg_estado = true;
                $banco->id_usu_ingresa = auth()->id();
                $banco->save();

                $chamilo_user = $this->wsCreateUser($usuario);
                if (empty($chamilo_user)) {
                    throw new SoapException('El servicio http://aula.edutalentos.pe/ esta inoperativo.', 5);
                }
            });
            return ['success' => true, 'data' => $usuario];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $usuario = User::find($id);
            $usuario->id_tipo_documento = $data['id_tipo_documento'];
            $usuario->id_genero = $data['id_genero'];
            $usuario->email = $data['email'];
            $usuario->apellido_paterno = Str::upper($data['apellido_paterno']);
            $usuario->apellido_materno = Str::upper($data['apellido_materno']);
            $usuario->nombres = Str::upper($data['nombres']);
            $usuario->nro_documento = $data['nro_documento'];
            $usuario->fecha_nacimiento = $data['fecha_nacimiento'];
            $usuario->telefono_fijo = $data['telefono_fijo'];
            $usuario->telefono_celular = $data['telefono_celular'];
            $usuario->direccion = $data['direccion'];
            if (isset($data['url_fotografia']))
                $usuario->url_fotografia = $data['url_fotografia']->store('uploads');
            if (isset($data['url_carnet_conadis']))
                $usuario->url_carnet_conadis = $data['url_carnet_conadis']->store('uploads');
            $usuario->flg_discapacidad = $data['flg_discapacidad'];
            $usuario->flg_estado = $data['flg_estado'];
            $usuario->flg_reniec = $data['flg_reniec'];
            $usuario->id_usu_modifica = auth()->id();
            $usuario->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function obtener($id)
    {
        $usuario = User::with([
            'tipo_documento',
            'genero',
            'arr_contrato',
            'arr_usuario_perfil'
        ])
            ->where([
                ['flg_usu_admin', '=', false],
                ['id_usuario', '=', $id]
            ])
            ->first();
        return $usuario;
    }

    public function listar()
    {
        $lista = User::where([
            ['flg_estado', '=', true],
            ['flg_usu_admin', '=', false]
        ])
            ->orderBy('descripcion', 'asc')
            ->get();
        return $lista;
    }

    public function paginar($limit, $data)
    {
        $rpta = User::with([
            'tipo_documento',
            'genero'
        ])
            ->where([
                [DB::raw('CONCAT(nombres," ", apellido_paterno," ",apellido_materno)'), 'like', '%' . $data['nombre_completo'] . '%'],
                ['flg_estado', '=', $data['flg_estado']],
                ['flg_usu_admin', '=', false]
            ])
            ->when($data['id_tipo_documento'], function ($query) use ($data) {
                return $query->where('id_tipo_documento', '=', $data['id_tipo_documento']);
            })
            ->when($data['nro_documento'], function ($query) use ($data) {
                return $query->where('nro_documento', '=', $data['nro_documento']);
            })
            ->orderBy('nombres', 'asc')
            ->orderBy('apellido_paterno', 'asc')
            ->orderBy('apellido_materno', 'asc')
            ->paginate($limit);
            /**
             * Encriptacion
             */
            $rpta->getCollection()->transform(function ($user) {
                $pem = config('site_vars.pem');
                if (!$publicKey = openssl_pkey_get_public($pem)) {
                    Log::error('Loading Public Key failed');
                    die('Loading Public Key failed');
                }
                $encrypted_id_tipo_documento = "";
                $encrypted_nro_documento = "";
                $encrypted_apellido_paterno = "";
                $encrypted_apellido_materno = "";
                $encrypted_nombres = "";
                $encrypted_direccion = "";
                $encrypted_id_genero = "";
                $encrypted_email = "";
                $encrypted_telefono_fijo = "";
                $encrypted_telefono_celular = "";
                $encrypted_username = "";
                try {
                    openssl_public_encrypt($user->id_tipo_documento, $encrypted_id_tipo_documento, $publicKey);
                    openssl_public_encrypt($user->nro_documento, $encrypted_nro_documento, $publicKey);
                    openssl_public_encrypt($user->apellido_paterno, $encrypted_apellido_paterno, $publicKey);
                    openssl_public_encrypt($user->apellido_materno ?? "", $encrypted_apellido_materno, $publicKey);
                    openssl_public_encrypt($user->nombres, $encrypted_nombres, $publicKey);
                    openssl_public_encrypt($user->direccion, $encrypted_direccion, $publicKey);
                    openssl_public_encrypt($user->id_genero, $encrypted_id_genero, $publicKey);
                    openssl_public_encrypt($user->email, $encrypted_email, $publicKey);
                    openssl_public_encrypt($user->telefono_fijo, $encrypted_telefono_fijo, $publicKey);
                    openssl_public_encrypt($user->telefono_celular, $encrypted_telefono_celular, $publicKey);
                    openssl_public_encrypt($user->username, $encrypted_username, $publicKey);    
                } catch (Exception $e) {
                    Log::error('Failed to encryp data' . $e);
                    die('Failed to encryp data');
                }
                $user->id_tipo_documento = base64_encode($encrypted_id_tipo_documento);
                $user->nro_documento = base64_encode($encrypted_nro_documento);
                $user->apellido_paterno = base64_encode($encrypted_apellido_paterno);
                $user->apellido_materno = base64_encode($encrypted_apellido_materno);
                $user->nombres = base64_encode($encrypted_nombres);
                $user->direccion = base64_encode($encrypted_direccion);
                $user->id_genero = base64_encode($encrypted_id_genero);
                $user->email = base64_encode($encrypted_email);
                $user->telefono_fijo = base64_encode($encrypted_telefono_fijo);
                $user->telefono_celular = base64_encode($encrypted_telefono_celular);
                $user->username = base64_encode($encrypted_username);
                $user->fecha_nacimiento = "01/01/0001";
                return $user;
            });
        return $rpta;
    }

    public function registrar($data)
    {
        try {
            $usuario = new User();
            $usuario->id_tipo_documento = $data['id_tipo_documento'];
            $usuario->id_genero = $data['id_genero'];
            $usuario->email = $data['email'];
            $usuario->apellido_paterno = Str::upper($data['apellido_paterno']);
            $usuario->apellido_materno = Str::upper($data['apellido_materno']);
            $usuario->nombres = Str::upper($data['nombres']);
            $usuario->nro_documento = $data['nro_documento'];
            $usuario->fecha_nacimiento = $data['fecha_nacimiento'];
            $usuario->telefono_celular = $data['telefono_celular'];
            $usuario->telefono_fijo = $data['telefono_fijo'];
            $usuario->direccion = $data['direccion'];
            $usuario->flg_reniec = $data['flg_reniec'];
            $usuario->flg_discapacidad = false;
            $usuario->flg_estado = true;
            DB::transaction(function () use ($usuario, $data) {
                $count = 0;
                
                $u_nombres = str_replace(['ñ', 'Ñ'], 'n', $data['nombres']);
                $u_apellido_paterno = str_replace(['ñ', 'Ñ'], 'n', $data['apellido_paterno']);
                
                $username = Str::upper($u_nombres[0] . $u_apellido_paterno);
                while (DB::table('T_GENM_USUARIO')->where('username', '=',  $username)->count() > 0) {
                    $count++;
                    $username = Str::upper($u_nombres[0] . $u_apellido_paterno) . $count;
                }
                $usuario->username = $username;
                $usuario->password = bcrypt($data['password']);
                $usuario->save();
                $contrato = new Contrato();
                $contrato->id_usuario = $usuario->id_usuario;
                $contrato->id_tipo_entidad = $data['id_tipo_entidad'];
                $contrato->id_dre_gre = $data['id_dre_gre'];
                $contrato->id_ugel = $data['id_ugel'];
                $contrato->id_entidad_externa = $data['id_entidad_externa'];
                $contrato->id_area = $data['id_area'];
                $contrato->id_nivel_puesto = $data['id_nivel_puesto'];
                $contrato->id_puesto = $data['id_puesto'];
                $contrato->id_regimen_laboral = $data['id_regimen_laboral'];
                $contrato->flg_ejerce_cargo = $data['flg_ejerce_cargo'] ?? false;
                if (isset($data['url_documento']))
                    $contrato->url_documento = $data['url_documento']->store('uploads');
                $contrato->flg_estado = true;
                $contrato->save();

                $banco = new BancoContrasena();
                $banco->id_usuario = $usuario->id_usuario;
                $banco->password = $usuario->password;
                $banco->flg_estado = true;
                $banco->id_usu_ingresa = auth()->id();
                $banco->save();

                $chamilo_user = $this->wsCreateUser($usuario);
                if (empty($chamilo_user)) {
                    throw new SoapException('El servicio http://aula.edutalentos.pe/ esta inoperativo.', 5);
                }
            });
            return ['success' => true, 'data' => $usuario];
        } catch (SoapException $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => $e->getMessage()]];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function fotografia($id)
    {
        $rpta = DB::table('T_GENM_USUARIO')
            ->select('url_fotografia')
            ->where('id_usuario', '=', $id)
            ->first();
        return empty($rpta) ? null : $rpta->url_fotografia;
    }

    public function carnetConadis($id)
    {
        $rpta = DB::table('T_GENM_USUARIO')
            ->select('url_carnet_conadis')
            ->where('id_usuario', '=', $id)
            ->first();
        return empty($rpta) ? null : $rpta->url_carnet_conadis;
    }

    public function perfiles($id)
    {
        $lista = UsuarioPerfil::where([
            ['flg_estado', '=', true],
            ['id_usuario', '=', $id]
        ])
            ->get();
        return $lista;
    }

    public function editarUsuarioPerfil($id_usuario, $id_perfil, $data)
    {
        try {
            $usuario_perfil = new UsuarioPerfil();
            $usuario_perfil->id_usuario = $id_usuario;
            $usuario_perfil->id_perfil = $id_perfil;
            DB::transaction(function () use ($usuario_perfil, $data) {
                UsuarioPerfil::where([
                    ['id_usuario', '=', $usuario_perfil->id_usuario],
                    ['id_perfil', '=', $usuario_perfil->id_perfil]
                ])
                    ->update([
                        'flg_estado' => false,
                        'id_usu_modifica' => auth()->id()
                    ]);
                if ($data['flg_estado']) {
                    $usuario_perfil->flg_estado = true;
                    $usuario_perfil->id_usu_ingresa = auth()->id();
                    $usuario_perfil->save();
                }
            });
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function auth()
    {
        $usuario = User::with([
            'tipo_documento',
            'genero',
        ])
            ->where('id_usuario', '=', auth()->id())
            ->first();
        return $usuario;
    }

    public function misPerfiles()
    {
        $lista = UsuarioPerfil::with([
            'perfil'
        ])
            ->where([
                ['flg_estado', '=', true],
                ['id_usuario', '=', auth()->id()]
            ])
            ->get();
        return $lista;
    }

    public function passwd($data)
    {
        try {
            DB::transaction(function () use ($data) {
                $usuario = User::find(auth()->id());
                $usuario->password = bcrypt($data['password']);
                $usuario->id_usu_modifica = auth()->id();
                $usuario->save();

                $banco = new BancoContrasena();
                $banco->id_usuario = $usuario->id_usuario;
                $banco->password = $usuario->password;
                $banco->flg_estado = true;
                $banco->id_usu_ingresa = auth()->id();
                $banco->save();

                /**
                 * Chamilo 
                 */
                DB::Connection('chamilo')
                    ->table('user')
                    ->where('email', $usuario->email)
                    ->update(['password' => $usuario->password]);
            });
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function dataSesion()
    {
        $arr_permiso = DB::table('T_MAE_PERMISO')
            ->join('T_GEND_PERFIL_PERMISO', 'T_GEND_PERFIL_PERMISO.id_permiso', '=', 'T_MAE_PERMISO.id_permiso')
            ->join('T_GENM_PERFIL', 'T_GENM_PERFIL.id_perfil', '=', 'T_GEND_PERFIL_PERMISO.id_perfil')
            ->join('T_GEND_USUARIO_PERFIL', 'T_GEND_USUARIO_PERFIL.id_perfil', '=', 'T_GENM_PERFIL.id_perfil')
            ->join('T_GENM_USUARIO', 'T_GENM_USUARIO.id_usuario', '=', 'T_GEND_USUARIO_PERFIL.id_usuario')
            ->select('T_MAE_PERMISO.descripcion')
            ->where([
                ['T_MAE_PERMISO.flg_estado', '=', true],
                ['T_GENM_USUARIO.flg_estado', '=', true],
                ['T_GENM_USUARIO.id_usuario', '=', auth()->id()],
                ['T_GEND_USUARIO_PERFIL.flg_estado', '=', true],
                ['T_GEND_PERFIL_PERMISO.flg_estado', '=', true]
            ])
            ->distinct()
            ->get();
        $arr_menu = DB::table('T_MAE_MENU')
            ->join('T_GEND_PERFIL_MENU', 'T_GEND_PERFIL_MENU.id_menu', '=', 'T_MAE_MENU.id_menu')
            ->join('T_GENM_PERFIL', 'T_GENM_PERFIL.id_perfil', '=', 'T_GEND_PERFIL_MENU.id_perfil')
            ->join('T_GEND_USUARIO_PERFIL', 'T_GEND_USUARIO_PERFIL.id_perfil', '=', 'T_GENM_PERFIL.id_perfil')
            ->join('T_GENM_USUARIO', 'T_GENM_USUARIO.id_usuario', '=', 'T_GEND_USUARIO_PERFIL.id_usuario')
            ->select('T_MAE_MENU.*')
            ->where([
                ['T_MAE_MENU.flg_estado', '=', true],
                ['T_GENM_USUARIO.flg_estado', '=', true],
                ['T_GENM_USUARIO.id_usuario', '=', auth()->id()],
                ['T_GEND_USUARIO_PERFIL.flg_estado', '=', true],
                ['T_GEND_PERFIL_MENU.flg_estado', '=', true]
            ])
            ->whereNull('p_id_menu')
            ->distinct()
            ->orderBy('posicion', 'asc')
            ->get();
        foreach ($arr_menu as $parent) {
            $parent->children = DB::table('T_MAE_MENU')
                ->join('T_GEND_PERFIL_MENU', 'T_GEND_PERFIL_MENU.id_menu', '=', 'T_MAE_MENU.id_menu')
                ->join('T_GENM_PERFIL', 'T_GENM_PERFIL.id_perfil', '=', 'T_GEND_PERFIL_MENU.id_perfil')
                ->join('T_GEND_USUARIO_PERFIL', 'T_GEND_USUARIO_PERFIL.id_perfil', '=', 'T_GENM_PERFIL.id_perfil')
                ->join('T_GENM_USUARIO', 'T_GENM_USUARIO.id_usuario', '=', 'T_GEND_USUARIO_PERFIL.id_usuario')
                ->select('T_MAE_MENU.*')
                ->where([
                    ['T_MAE_MENU.flg_estado', '=', true],
                    ['T_GENM_USUARIO.flg_estado', '=', true],
                    ['T_GENM_USUARIO.id_usuario', '=', auth()->id()],
                    ['T_GEND_USUARIO_PERFIL.flg_estado', '=', true],
                    ['T_GEND_PERFIL_MENU.flg_estado', '=', true],
                    ['T_MAE_MENU.p_id_menu', '=', $parent->id_menu]
                ])
                ->distinct()
                ->orderBy('posicion', 'asc')
                ->get();
        }
        return [
            'success' => true,
            'arr_permiso' => $arr_permiso,
            'arr_menu' => $arr_menu
        ];
    }

    public function update($data)
    {
        try {
            $usuario = User::find(auth()->id());
            $usuario->id_tipo_documento = $data['id_tipo_documento'];
            $usuario->id_genero = $data['id_genero'];
            $usuario->email = $data['email'];
            $usuario->apellido_paterno = Str::upper($data['apellido_paterno']);
            $usuario->apellido_materno = Str::upper($data['apellido_materno']);
            $usuario->nombres = Str::upper($data['nombres']);
            $usuario->nro_documento = $data['nro_documento'];
            $usuario->fecha_nacimiento = $data['fecha_nacimiento'];
            $usuario->telefono_fijo = $data['telefono_fijo'];
            $usuario->telefono_celular = $data['telefono_celular'];
            $usuario->direccion = $data['direccion'];
            if (isset($data['url_fotografia']))
                $usuario->url_fotografia = $data['url_fotografia']->store('uploads');
            if (isset($data['url_carnet_conadis']))
                $usuario->url_carnet_conadis = $data['url_carnet_conadis']->store('uploads');
            $usuario->flg_discapacidad = $data['flg_discapacidad'];
            $usuario->id_usu_modifica = auth()->id();
            $usuario->save();
            return ['success' => true, 'data' => null];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function consultar($nro_documento)
    {
        $usuario = DB::table('T_GENM_USUARIO')
            ->select([
                'id_tipo_documento',
                'nro_documento AS nro_dni',
                'nro_documento',
                'apellido_paterno',
                'apellido_materno',
                'nombres',
                'telefono_fijo',
                'telefono_celular',
                'telefono_celular AS telefono',
                'email',
                'fecha_nacimiento',
                'direccion',
                'id_genero'
            ])
            ->where('nro_documento', '=', $nro_documento)
            ->first();
        return $usuario;
    }

    public function wsCreateUser($user)
    {
        $email = DB::Connection('chamilo')
            ->table('user')
            ->where('email', $user->email)
            ->first('email');
        if ($email) {
            throw new SoapException('Ya esta registrado en el Aula virtual.', 5);
        }
        $soap = new \SoapClient($this->url . 'registration.soap.php?wsdl');
        $myIp = file_get_contents($this->url . 'testip.php');
        $finalKey = sha1($myIp . $this->security_key);
        $params = array(
            'secret_key' => $finalKey,
            'firstname' => $user->nombres,
            'lastname' => trim($user->apellido_paterno . ' ' . ($user->apellido_materno ?? '')),
            'status' => 5,
            'loginname' => $user->email,
            'password' => $user->password,
            'encrypt_method' => 'bcrypt',
            'email' => $user->email,
            'language' => 'spanish',
            'phone' => $user->telefono_fijo,
            'expiration_date' => Carbon::now()->addYears(10)->toDateString(),
            'original_user_id_name' => 'id_usuario',
            'original_user_id_value' => $user->id_usuario,
            'official_code' => $user->nro_documento,
            'extra' => array()
        );
        $chamilo_user = $soap->WSCreateUserPasswordCrypted($params);
        return $chamilo_user;
    }
}
