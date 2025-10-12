<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionProfesion extends FormRequest
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
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_MAE_PROFESION')->where(function ($query) {
                    return $query->where('id_profesion', '<>', $this->route('id'));
                })],
                'flg_estado' => ['required', 'boolean']
            ];
        } else {
            return [
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_MAE_PROFESION')]
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
            'descripcion' => 'descripción',
            'flg_estado' => 'estado'
        ];
    }
}
