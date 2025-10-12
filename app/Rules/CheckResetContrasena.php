<?php

namespace App\Rules;

use App\BancoContrasena;
use App\ResetContrasena;
use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckResetContrasena implements Rule
{
    protected $id_reset_contrasena; 
    protected $error; 

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id_reset_contrasena)
    {
        $this->id_reset_contrasena = $id_reset_contrasena;
        $this->error = 'La contraseña ha sido usada anteriormente.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $reset_contrasena = ResetContrasena::where([
            ['flg_estado', '=', true],
            ['id_reset_contrasena', '=', $this->id_reset_contrasena]
        ])
            ->first();
        if (empty($reset_contrasena)) {
            $this->error = 'El codigo de recuperacion no es correcto o esta caduco.';
            return false;
        }
        $usuario = User::where('email', '=', $reset_contrasena->email)
            ->first();
        if (empty($reset_contrasena)) {
            $this->error = 'El correo electrónico no es correcto o ha sido cambiado.';
            return false;
        }
        $arr_banco = BancoContrasena::select('password')
            ->where('id_usuario', '=', $usuario->id_usuario)
            ->get();
        $valido = true;
        foreach ($arr_banco as $banco) {
            if (Hash::check($value, $banco->password)) {
                $valido = false;
                break;
            }
        }
        return $valido;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error;
    }
}
