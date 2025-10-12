<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckCantEquipoTecnico implements Rule
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
        $check = DB::table('T_GEND_EQUIPO_POSTULACION')
            ->select(DB::raw('count(1) as cant, id_ugel'))
            ->where([
                ['id_postulacion', '=', $this->id_postulacion],
                ['flg_estado', '=', true]
            ])
            ->groupBy('id_ugel')
            ->having('cant', '>', 4)
            ->get()
            ->count();
        $min = DB::table('T_GEND_EQUIPO_POSTULACION')
            ->select('id_ugel')
            ->where([
                ['id_postulacion', '=', $this->id_postulacion],
                ['flg_estado', '=', true]
            ])
            ->distinct()
            ->get()
            ->count();
        $cant_ugel = DB::table('T_GEND_POSTULACION_UGEL')
            ->where([
                ['id_postulacion', '=', $this->id_postulacion],
                ['flg_estado', '=', true]
            ])
            ->count();
        return ($min == $cant_ugel) && ($check == 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Se debe agregar min. 1 integrante y max. 4 integrantes por cada equipo técnico.';
    }
}
