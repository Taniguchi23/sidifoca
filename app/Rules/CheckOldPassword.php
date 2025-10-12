<?php

namespace App\Rules;

use App\BancoContrasena;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckOldPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if (auth()->id()) {
            $arr_banco = BancoContrasena::select('password')
                ->where('id_usuario', '=', auth()->id())
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
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La contraseña ha sido usada anteriormente.';
    }
}
