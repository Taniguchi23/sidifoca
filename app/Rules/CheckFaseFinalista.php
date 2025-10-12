<?php

namespace App\Rules;

use App\Postulacion;
use Illuminate\Contracts\Validation\Rule;

class CheckFaseFinalista implements Rule
{
    protected $id_postulacion;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id_postulacion)
    {
        $this->id_postulacion = $id_postulacion;
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
        $check = Postulacion::with('postulacion_admitida')
            ->where([
                ['flg_estado', '=', true],
                ['flg_enviado', '=', true],
                ['flg_aprobado', '=', true],
                ['flg_calificado', '=', true],
                ['flg_terminado', '=', false],
                ['id_postulacion', '=', $this->id_postulacion]
            ])
            ->whereHas('postulacion_admitida', function ($query) {
                $query->where('flg_finalista', '=', true);
            })
            ->exists();
        return $check;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La postulación ya fue corregida.';
    }
}
