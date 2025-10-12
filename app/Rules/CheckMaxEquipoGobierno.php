<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckMaxEquipoGobierno implements Rule
{
    protected $id_postulacion;
    protected $id_tipo_postulacion;
    protected $ugeles_gobierno_local;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id_postulacion, $id_tipo_postulacion)
    {
        $this->id_postulacion = $id_postulacion;
        $this->id_tipo_postulacion = $id_tipo_postulacion;
        $this->ugeles_gobierno_local = config('constants.tipo_postulacion.ugeles_gobierno_local');
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
        if ($this->id_tipo_postulacion == $this->ugeles_gobierno_local) {
            $count = DB::table('T_GEND_EQUIPO_GOBIERNO_LOCAL')
                ->where([
                    ['id_postulacion', '=', $this->id_postulacion],
                    ['flg_estado', '=', true]
                ])
                ->count();
            return $count < 3;
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
        return 'El equipo técnico del gobierno local debe tener max. 2 integrantes.';
    }
}
