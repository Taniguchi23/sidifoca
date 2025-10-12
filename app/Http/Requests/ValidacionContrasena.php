<?php

namespace App\Http\Requests;

use App\Rules\CheckContrasenaActual;
use App\Rules\CheckOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionContrasena extends FormRequest
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
            'current_password' => ['required', 'min:8', 'max:16', new CheckContrasenaActual()],
            'password' => ['required', 'min:8', 'max:16', 'regex:/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/', 'confirmed', new CheckOldPassword()],
            'password_confirmation' => ['required', 'min:8', 'max:16']
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
            'password' => 'contraseña',
            'password_confirmation' => 'repetir contraseña',
            'current_password' => 'contraseña actual'
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
            'password.regex' => 'La contraseña debe tener al menos un dígito, al menos una minúscula, al menos una mayúscula y sin caracteres especiales.'
        ];
    }
}
