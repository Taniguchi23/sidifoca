<?php

namespace App\Http\Requests;

use App\Rules\CheckCorreoActivo;
use App\Rules\CheckResetContrasena;
use App\Rules\CheckUserResetContrasena;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionResetContrasena extends FormRequest
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
                'password' => ['required', 'min:8', 'max:16', 'regex:/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/', 'confirmed', new CheckResetContrasena($this->route('id'))],
                'password_confirmation' => ['required', 'min:8', 'max:16'],
                'captcha' => ['required', 'max:255', 'captcha']
            ];
        } else {
            return [
                'email' => ['required', 'email:rfc,dns', 'max:255', Rule::exists('T_GENM_USUARIO'), new CheckUserResetContrasena()],
                'captcha' => ['required', 'max:255', 'captcha']
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
            'email' => 'correo electrónico'
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
            'captcha.captcha' => 'Captcha inválido',
            'password.regex' => 'La contraseña debe tener al menos un dígito, al menos una minúscula, al menos una mayúscula y sin caracteres especiales.'
        ];
    }
}
