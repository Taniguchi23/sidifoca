<?php

namespace App\Rules;

use App\BancoContrasena;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckFechaNacimiento implements Rule
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
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $value);
        $now = Carbon::now();
        if ($fecha_nacimiento->greaterThan($now)) {
            return false;
        }
        return ($fecha_nacimiento->age >= 18);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La fecha de nacimiento es invalida.';
    }
}
