<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckMaxEquipoTecnico implements Rule
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
        $count = DB::table('T_GEND_EQUIPO_POSTULACION')
            ->where([
                ['id_postulacion', '=', $this->id_postulacion],
                ['flg_estado', '=', true]
            ])
            ->count();
        return $count < 5;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El equipo técnico debe tener max. 4 integrantes.';
    }
}
