<?php

namespace App\Http\Requests;

use App\Rules\CheckFaseAdmision;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionAdmision extends FormRequest
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
            'estado' => ['required', 'integer', new CheckFaseAdmision($this->route('id'))],
            'observacion' => ['required', 'max:1000']
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
            'estado' => 'ficha de admisión',
            'observacion' => 'comentarios'
        ];
    }
}
