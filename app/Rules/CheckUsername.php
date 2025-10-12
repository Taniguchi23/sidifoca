<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckUsername implements Rule
{
    protected $error;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->error = 'El estado de cuenta es inactivo.';
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
        $login_type = filter_var($value, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';
        $user = DB::table('T_GENM_USUARIO')
            ->where($login_type, '=', $value)
            ->first();
        if (empty($user)) {
            $this->error = "El usuario ingresado no existe";
            return false;
        }
        return $user->flg_estado;
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
