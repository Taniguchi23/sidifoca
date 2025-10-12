<?php

namespace App\Http\Requests;

use App\Rules\CheckUsername;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionIngresar extends FormRequest
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
            'username' => ['required', 'max:255', new CheckUsername()],
            'password' => ['required', 'min:8', 'max:16'],
            'captcha' => ['required', 'captcha']
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
            'username' => 'usuario',
            'password' => 'contraseña'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'captcha.captcha' => 'Captcha inválido'
        ];
    }
}
