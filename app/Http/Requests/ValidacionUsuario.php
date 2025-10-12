<?php

namespace App\Http\Requests;

use App\Rules\CheckFechaNacimiento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionUsuario extends FormRequest
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
                'id_tipo_documento' => ['required', 'integer'],
                'id_genero' => ['required', 'integer'],
                'email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('T_GENM_USUARIO')->where(function ($query) {
                    return $query->where('id_usuario', '<>', $this->route('id'));
                })],
                'apellido_paterno' => ['required', 'alpha_spaces', 'max:255'],
                'apellido_materno' => ['nullable', 'alpha_spaces', 'max:255'],
                'nombres' => ['required', 'alpha_spaces', 'max:255'],
                'nro_documento' => ['required', 'max:255', Rule::unique('T_GENM_USUARIO')->where(function ($query) {
                    return $query->where('id_usuario', '<>', $this->route('id'));
                })],
                'fecha_nacimiento' => ['required', 'date_format:d/m/Y', new CheckFechaNacimiento()],
                'telefono_fijo' => ['nullable', 'max:255'],
                'telefono_celular' => ['nullable', 'max:255'],
                'direccion' => ['nullable', 'description', 'max:255'],
                'url_fotografia' => ['nullable', 'image', 'mimes:jpeg,bmp,png', 'max:2048'],
                'url_carnet_conadis' => ['nullable', Rule::requiredIf(function () {
                    return $this->input('flg_discapacidad') && !$this->input('flg_carnet_conadis');
                }), 'file', 'mimes:pdf,jpeg,bmp,png', 'max:2048'],
                'flg_estado' => ['required', 'boolean'],
                'flg_discapacidad' => ['required', 'boolean']
            ];
        } else {
            return [
                'id_tipo_documento' => ['required', 'integer'],
                'id_genero' => ['required', 'integer'],
                'email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('T_GENM_USUARIO')],
                'apellido_paterno' => ['required', 'alpha_spaces', 'max:255'],
                'apellido_materno' => ['nullable', 'alpha_spaces', 'max:255'],
                'nombres' => ['required', 'alpha_spaces', 'max:255'],
                'nro_documento' => ['required', 'max:255', Rule::unique('T_GENM_USUARIO')],
                'fecha_nacimiento' => ['required', 'date_format:d/m/Y', new CheckFechaNacimiento()],
                'telefono_fijo' => ['nullable', 'max:255'],
                'telefono_celular' => ['nullable', 'max:255'],
                'direccion' => ['nullable', 'description', 'max:255'],
                'url_fotografia' => ['nullable', 'image', 'mimes:jpeg,bmp,png', 'max:2048'],
                'url_carnet_conadis' => ['nullable', Rule::requiredIf(function () {
                    return $this->input('flg_discapacidad');
                }), 'file', 'mimes:pdf,jpeg,bmp,png', 'max:2048'],
                'flg_discapacidad' => ['required', 'boolean']
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
            'id_tipo_documento' => 'tipo de documento',
            'id_genero' => 'género',
            'email' => 'correo electrónico',
            'apellido_paterno' => 'apellido paterno',
            'apellido_materno' => 'apellido materno',
            'nombres' => 'nombres',
            'nro_documento' => 'número de documento',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'telefono_fijo' => 'teléfono fijo',
            'telefono_celular' => 'teléfono celular',
            'direccion' => 'dirección',
            'url_fotografia' => 'fotografia',
            'url_carnet_conadis' => 'carnet de conadis',
            'flg_discapacidad' => 'persona con discapacidad',
            'flg_estado' => 'estado'
        ];
    }
}
