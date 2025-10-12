<?php

namespace App\Http\Requests;

use App\Rules\CheckReniecDNI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionDirector extends FormRequest
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
            'd_id_dre_gre' => ['required', 'integer'],
            'd_id_ugel' => ['required', 'integer', Rule::unique('T_GEND_DIRECTOR', 'id_ugel')->where(function ($query) {
                return $query->where('id_postulacion', '=', $this->route('id'));
            })],
            'd_nro_dni' => ['required', 'max:255', Rule::unique('T_GEND_DIRECTOR', 'nro_dni')->where(function ($query) {
                return $query->where('id_postulacion', '=', $this->route('id'));
            }), new CheckReniecDNI()],
            'd_nombres' => ['required', 'max:255'],
            'd_apellido_paterno' => ['required', 'max:255'],
            'd_apellido_materno' => ['nullable', 'max:255'],
            'd_telefono_fijo' => ['nullable', 'max:255'],
            'd_telefono_celular' => ['required', 'max:255'],
            'd_email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('T_GEND_DIRECTOR', 'email')->where(function ($query) {
                return $query->where('id_postulacion', '=', $this->route('id'));
            })]
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
            'd_id_dre_gre' => 'DRE / GRE',
            'd_id_ugel' => 'UGEL',
            'd_nro_dni' => 'N.° de DNI',
            'd_nombres' => 'nombres',
            'd_apellido_paterno' => 'apellido paterno',
            'd_apellido_materno' => 'apellido materno',
            'd_telefono_fijo' => 'teléfono fijo',
            'd_telefono_celular' => 'teléfono',
            'd_email' => 'correo electrónico'
        ];
    }
}
