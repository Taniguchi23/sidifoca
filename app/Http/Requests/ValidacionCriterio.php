<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionCriterio extends FormRequest
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
                'id_modalidad' => ['required', 'integer'],
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_MAE_CRITERIO')->where(function ($query) {
                    return $query->where([
                        ['id_modalidad', '=', $this->input('id_modalidad')],
                        ['id_criterio', '<>', $this->route('id')]
                    ]);
                })],
                'detalles' => ['required', 'description', 'max:1000'],
                'puntaje_maximo' => ['required', 'integer'],
                'flg_estado' => ['required', 'boolean']
            ];
        } else {
            return [
                'id_modalidad' => ['required', 'integer'],
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_MAE_CRITERIO')->where(function ($query) {
                    return $query->where([
                        ['id_modalidad', '=', $this->input('id_modalidad')]
                    ]);
                })],
                'detalles' => ['required', 'description', 'max:1000'],
                'puntaje_maximo' => ['required', 'integer']
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
            'id_modalidad' => 'modalidad',
            'descripcion' => 'descripción',
            'detalles' => 'detalles',
            'puntaje_maximo' => 'puntaje máximo',
            'flg_estado' => 'estado'
        ];
    }
}
