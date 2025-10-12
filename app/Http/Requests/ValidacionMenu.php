<?php

namespace App\Http\Requests;

use App\Rules\CheckMenuParent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionMenu extends FormRequest
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
                'p_id_menu' => ['nullable', 'integer', new CheckMenuParent($this->route('id'))],
                'descripcion' => ['required', 'description', 'max:255'],
                'ruta' => ['required', 'description', 'max:255'],
                'posicion' => ['required', 'integer'],
                'icono' => ['nullable', 'max:255'],
                'flg_estado' => ['required', 'boolean']
            ];
        } else {
            return [
                'p_id_menu' => ['nullable', 'integer'],
                'descripcion' => ['required', 'description', 'max:255'],
                'ruta' => ['required', 'description', 'max:255'],
                'posicion' => ['required', 'integer'],
                'icono' => ['nullable', 'max:255']
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
            'p_id_menu' => 'padre',
            'descripcion' => 'descripción',
            'ruta' => 'ruta',
            'posicion' => 'posición',
            'icono' => 'icono',
            'flg_estado' => 'estado'
        ];
    }
}
