<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckCantDirector implements Rule
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
        $count = DB::table('T_GEND_DIRECTOR')
            ->where([
                ['id_postulacion', '=', $this->id_postulacion],
                ['flg_estado', '=', true]
            ])
            ->count();
        $check = DB::table('T_GEND_POSTULACION_UGEL')
            ->where([
                ['id_postulacion', '=', $this->id_postulacion],
                ['flg_estado', '=', true]
            ])
            ->count();
        return $count == $check;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Se debe agregar 1 director por UGEL.';
    }
}
