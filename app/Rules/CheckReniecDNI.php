<?php

namespace App\Rules;

use App\Repositories\ReniecRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckReniecDNI implements Rule
{
    protected $error;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $reniec = new ReniecRepository();
        $user = $reniec->consultar3($value);
        if (empty($user)) {
            return true;
        }
        if ($user->codigo_restriccion == 'A') {
            $this->error = 'El n° de documento pertenece a una persona fallecida.';
            return false;
        } 
        if ($user->fecha_nacimiento->age < 18) {
            $this->error = 'El n° de documento pertenece a una persona menor de edad.';
            return false;
        }
        return true;
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
