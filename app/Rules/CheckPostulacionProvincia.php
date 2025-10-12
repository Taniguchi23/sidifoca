<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckPostulacionProvincia implements Rule
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
        $check = DB::table('T_GEND_POSTULACION_PROVINCIA')
            ->join('T_GENM_POSTULACION', 'T_GENM_POSTULACION.id_postulacion', '=', 'T_GEND_POSTULACION_PROVINCIA.id_postulacion')
            ->where([
                ['T_GENM_POSTULACION.id_postulacion', '=', $this->id_postulacion],
                ['T_GEND_POSTULACION_PROVINCIA.flg_estado', '=', true]
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
