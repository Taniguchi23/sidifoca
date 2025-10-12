<?php

namespace App\Http\Requests;

use App\Rules\CheckFechaNacimiento;
use App\Rules\CheckReniecDNI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionRegistroUsuario extends FormRequest
{
    protected $dre_gre;
    protected $ugel;
    protected $minedu;
    protected $externa;

    public function __construct()
    {
        $this->dre_gre = config('constants.tipo_entidad.dre_gre');
        $this->ugel = config('constants.tipo_entidad.ugel');
        $this->minedu = config('constants.tipo_entidad.minedu');
        $this->externa = config('constants.tipo_entidad.externa');
    }

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
            'id_tipo_documento' => ['required', 'integer'],
            'id_genero' => ['required', 'integer'],
            'apellido_paterno' => ['required', 'alpha_spaces', 'max:255'],
            'apellido_materno' => ['nullable', 'alpha_spaces', 'max:255'],
            'nombres' => ['required', 'alpha_spaces', 'max:255'],
            'nro_documento' => ['required', 'max:255', Rule::unique('T_GENM_USUARIO'), new CheckReniecDNI()],
            'fecha_nacimiento' => ['required', 'date_format:d/m/Y', new CheckFechaNacimiento()],
            'telefono_celular' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('T_GENM_USUARIO')],
            'direccion' => ['nullable', 'max:255'],
            'password' => ['required', 'min:8', 'max:16', 'regex:/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/', 'confirmed'],
            'password_confirmation' => ['required', 'min:8', 'max:16'],
            'id_tipo_entidad' => ['required', 'integer'],
            'id_dre_gre' => ['nullable', Rule::requiredIf(function () {
                return in_array($this->input('id_tipo_entidad'), [$this->dre_gre, $this->ugel]);
            }), 'integer'],
            'id_ugel' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_entidad') == $this->ugel;
            }), 'integer'],
            'id_entidad_externa' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_entidad') == $this->externa;
            }), 'integer'],
            'id_area' => ['nullable', 'integer'],
            'id_nivel_puesto' => ['required', 'integer'],
            'id_puesto' => ['required', 'integer'],
            'id_regimen_laboral' => ['required', 'integer'],
            'url_documento' => ['nullable', 'file', 'mimes:pdf,jpeg,bmp,png', 'max:2048'],
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
            'id_tipo_documento' => 'tipo de documento',
            'id_genero' => 'género',
            'apellido_paterno' => 'apellido paterno',
            'apellido_materno' => 'apellido materno',
            'nombres' => 'nombres',
            'nro_documento' => 'número de documento',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'telefono_celular' => 'teléfono celular',
            'email' => 'correo electrónico',
            'direccion' => 'dirección',
            'password' => 'Contraseña',
            'password_confirmation' => 'Repetir Contraseña',
            'id_tipo_entidad' => 'tipo de entidad',
            'id_dre_gre' => 'DRE / GRE',
            'id_ugel' => 'UGEL',
            'id_entidad_externa' => 'entidad externa',
            'id_area' => 'área en la que labora',
            'id_nivel_puesto' => 'nivel del puesto',
            'id_puesto' => 'nombre del puesto',
            'id_regimen_laboral' => 'régimen laboral',
            'url_documento' => 'resolución, oficio o contrato vigente'
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
            'password.regex' => 'La contraseña debe tener al menos un dígito, al menos una minúscula, al menos una mayúscula y sin caracteres especiales.',
            'url_documento.max' => 'El campo :attribute no debe pesar más de 2MB (2048 KB).',
        ];
    }
}
