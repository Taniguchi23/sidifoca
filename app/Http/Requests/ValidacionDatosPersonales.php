<?php

namespace App\Http\Requests;

use App\Rules\CheckFechaNacimiento;
use App\Rules\CheckReniecDNI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionDatosPersonales extends FormRequest
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
            'id_tipo_documento' => ['required', 'integer'],
            'id_genero' => ['required', 'integer'],
            'email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('T_GENM_USUARIO')->where(function ($query) {
                return $query->where('id_usuario', '<>', auth()->id());
            })],
            'apellido_paterno' => ['required', 'max:255'],
            'apellido_materno' => ['nullable', 'max:255'],
            'nombres' => ['required', 'max:255'],
            'nro_documento' => ['required', 'max:255', Rule::unique('T_GENM_USUARIO')->where(function ($query) {
                return $query->where('id_usuario', '<>', auth()->id());
            }), new CheckReniecDNI()],
            'fecha_nacimiento' => ['required', 'date_format:d/m/Y', new CheckFechaNacimiento()],
            'telefono_fijo' => ['nullable', 'max:255'],
            'telefono_celular' => ['nullable', 'max:255'],
            'direccion' => ['nullable', 'max:255'],
            'url_fotografia' => ['nullable', 'image', 'mimes:jpeg,bmp,png', 'max:2048'],
            'url_carnet_conadis' => ['nullable', Rule::requiredIf(function () {
                return $this->input('flg_discapacidad') && !$this->input('flg_carnet_conadis');
            }), 'file', 'mimes:pdf,jpeg,bmp,png', 'max:2048'],
            'flg_discapacidad' => ['required', 'boolean']
        ];
    }

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
            'flg_discapacidad' => 'persona con discapacidad'
        ];
    }
}
