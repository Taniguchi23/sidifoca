<?php

namespace App\Repositories;

use App\BancoContrasena;
use App\ResetContrasena;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ResetContrasenaRepository
{
    public function insertar($data)
    {
        try {
            $reset_contrasena = new ResetContrasena();
            $reset_contrasena->email = $data['email'];
            $reset_contrasena->flg_estado = true;
            DB::transaction(function () use ($reset_contrasena, $data) {
                ResetContrasena::where('email', '=', $data['email'])
                    ->update([
                        'flg_estado' => false,
                        'id_usu_modifica' => auth()->id()
                    ]);
                $usuario = User::select('apellido_paterno', 'apellido_materno', 'nombres')
                    ->where('email', '=', $data['email'])
                    ->first();
                $nombre_completo = Str::upper($usuario->nombres . ' ' . $usuario->apellido_paterno . ' ' . ($usuario->apellido_materno ?? ''));
                $reset_contrasena->usuario = Str::of($nombre_completo)->rtrim();
                $reset_contrasena->id_usu_ingresa = auth()->id();
                $reset_contrasena->save();
            });
            return ['success' => true, 'data' => $reset_contrasena];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errors' => ['*' => 'Se ha producido un error.']];
        }
    }

    public function editar($id, $data)
    {
        try {
            $reset_contrasena = ResetContrasena::where([
                ['flg_estado', '=', true],
                ['id_reset_contrasena', '=', $id]
            ])
                ->first();
            DB::transaction(function () use ($reset_contrasena, $data) {
                $usuario = User::where('email', '=', $reset_contrasena->email)
                    ->first();
                $usuario->email = $reset_contrasena->email;
                $usuario->password =  bcrypt($data['password']);
                $usuario->id_usu_modifica = auth()->id();
                $usuario->save();
                $reset_contrasena->flg_estado = false;
                $reset_contrasena->id_usu_modifica = auth()->id();
                $reset_contrasena->save();

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

    public function obtener($id)
    {
        $reset_contrasena = ResetContrasena::where([
            ['flg_estado', '=', true],
            ['id_reset_contrasena', '=', $id]
        ])
            ->first();
        return $reset_contrasena;
    }
}
