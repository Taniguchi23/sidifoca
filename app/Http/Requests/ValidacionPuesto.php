<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionPuesto extends FormRequest
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
        if ($this->route('id')) {
            return [
                'id_tipo_entidad' => ['required', 'integer'],
                'id_nivel_puesto' => ['required', 'integer'],
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_MAE_PUESTO')->where(function ($query) {
                    return $query->where([
                        ['id_tipo_entidad', '=', $this->input('id_tipo_entidad')],
                        ['id_nivel_puesto', '=', $this->input('id_nivel_puesto')],
                        ['id_puesto', '<>', $this->route('id')]
                    ]);
                })],
                'flg_estado' => ['required', 'boolean']
            ];
        } else {
            return [
                'id_tipo_entidad' => ['required', 'integer'],
                'id_nivel_puesto' => ['required', 'integer'],
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_MAE_PUESTO')->where(function ($query) {
                    return $query->where([
                        ['id_tipo_entidad', '=', $this->input('id_tipo_entidad')],
                        ['id_nivel_puesto', '=', $this->input('id_nivel_puesto')]
                    ]);
                })]
            ];
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'id_tipo_entidad' => 'tipo entidad',
            'id_nivel_puesto' => 'nivel puesto',
            'descripcion' => 'descripción',
            'flg_estado' => 'estado'
        ];
    }
}
