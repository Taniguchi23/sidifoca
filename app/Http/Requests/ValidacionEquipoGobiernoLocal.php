<?php

namespace App\Http\Requests;

use App\Rules\CheckReniecDNI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionEquipoGobiernoLocal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'p_nro_dni' => ['required', 'max:255', Rule::unique('T_GEND_EQUIPO_GOBIERNO_LOCAL', 'nro_dni')->where(function ($query) {
                return $query->where('id_postulacion', '=', $this->route('id'));
            }), new CheckReniecDNI()],
            'p_nombres' => ['required', 'max:255'],
            'p_apellido_paterno' => ['required', 'max:255'],
            'p_apellido_materno' => ['nullable', 'max:255'],
            'p_telefono' => ['required', 'max:255'],
            'p_email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('T_GEND_EQUIPO_GOBIERNO_LOCAL', 'email')->where(function ($query) {
                return $query->where('id_postulacion', '=', $this->route('id'));
            })],
            'p_id_cargo' => ['required', 'integer']
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'p_nro_dni' => 'N.° de DNI',
            'p_nombres' => 'nombres',
            'p_apellido_paterno' => 'apellido paterno',
            'p_apellido_materno' => 'apellido materno',
            'p_telefono' => 'teléfono',
            'p_email' => 'correo electrónico',
            'p_id_cargo' => 'cargo',
            'flg_estado' => 'estado'
        ];
    }
}
