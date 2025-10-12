<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckPostulacionUgel implements Rule
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
        $check = DB::table('T_GEND_POSTULACION_UGEL')
            ->join('T_GENM_POSTULACION', 'T_GENM_POSTULACION.id_postulacion', '=', 'T_GEND_POSTULACION_UGEL.id_postulacion')
            ->where([
                ['T_GENM_POSTULACION.id_postulacion', '=', $this->id_postulacion],
                ['T_GEND_POSTULACION_UGEL.flg_estado', '=', true]
            ])
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
        return 'El campo :attribute es obligatorio.';
    }
}
