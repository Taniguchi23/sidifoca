<?php

namespace App\Http\Requests;

use App\Rules\CheckFaseFinalista;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionFinalista extends FormRequest
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
            'flg_ganador' => ['required', 'boolean', new CheckFaseFinalista($this->route('id'))],
            'comentario' => ['required', 'max:1000']
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
            'flg_ganador' => 'ganador',
            'comentario' => 'comentarios'
        ];
    }
}
