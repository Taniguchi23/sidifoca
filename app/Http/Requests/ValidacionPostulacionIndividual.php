<?php

namespace App\Http\Requests;

use App\Rules\CheckMaxEquipoTecnico;
use App\Rules\CheckMinEquipoTecnico;
use App\Rules\CheckPostulacionDistrito;
use App\Rules\CheckPostulacionProvincia;
use App\Rules\CheckReniecDNI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionPostulacionIndividual extends FormRequest
{
    protected $tipo_postulacion;

    public function __construct()
    {
        $this->tipo_postulacion = [
            'ugel' => config('constants.tipo_postulacion.ugel')
        ];
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
            'id_tipo_postulacion' => ['required', 'integer'],
            'id_dre_gre' => ['required', 'integer'],
            'id_ugel' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->tipo_postulacion['ugel'];
            })],
            'id_provincia' => [new CheckPostulacionProvincia($this->route('id'))],
            'id_distrito' => [new CheckPostulacionDistrito($this->route('id'))],
            'id_respuesta.*' => ['required', 'max:1000'],
            'buena_practica' => ['required', 'max:255'],
            'id_categoria' => ['required', 'integer'],
            'id_tema' => ['required', 'integer'],
            'nro_meses' => ['required', 'integer'],
            'nro_dias' => ['nullable', 'integer'],
            'id_director' => ['required', 'integer'],
            'd_nro_dni' => ['required', 'max:255', new CheckReniecDNI()],
            'd_nombres' => ['required', 'max:255'],
            'd_apellido_paterno' => ['required', 'max:255'],
            'd_apellido_materno' => ['nullable', 'max:255'],
            'd_telefono_fijo' => ['nullable', 'max:255'],
            'd_telefono_celular' => ['required', 'max:255'],
            'd_email' => ['required', 'email:rfc,dns', 'max:255'],
            'id_contacto_postulacion' => ['required', 'integer'],
            'c_nro_dni' => ['required', 'max:255', new CheckReniecDNI()],
            'c_nombres' => ['required', 'max:255'],
            'c_apellido_paterno' => ['required', 'max:255'],
            'c_apellido_materno' => ['nullable', 'max:255'],
            'c_telefono_fijo' => ['nullable', 'max:255'],
            'c_telefono_celular' => ['required', 'max:255'],
            'c_email' => ['required', 'email:rfc,dns', 'max:255'],
            'min_equipo' => [new CheckMinEquipoTecnico($this->route('id'))],
            'max_equipo' => [new CheckMaxEquipoTecnico($this->route('id'))],
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
            'id_tipo_postulacion' => 'tipo de entidad',
            'id_dre_gre' => 'DRE / GRE',
            'id_ugel' => 'UGEL',
            'id_provincia' => 'provincia',
            'id_distrito' => 'distrito',
            'id_respuesta.*' => 'respuesta',
            'buena_practica' => 'buena práctica',
            'id_categoria' => 'categoría',
            'id_tema' => 'tema',
            'nro_meses' => 'meses',
            'nro_dias' => 'días',
            'id_director' => 'director',
            'd_nro_dni' => 'N.° de DNI',
            'd_nombres' => 'nombres',
            'd_apellido_paterno' => 'apellido paterno',
            'd_apellido_materno' => 'apellido materno',
            'd_telefono_fijo' => 'teléfono fijo',
            'd_telefono_celular' => 'teléfono celular',
            'd_email' => 'correo electrónico',
            'id_equipo_postulacion' => 'equipo técnico',
            'c_nro_dni' => 'N.° de DNI',
            'c_nombres' => 'nombres',
            'c_apellido_paterno' => 'apellido paterno',
            'c_apellido_materno' => 'apellido materno',
            'c_telefono_fijo' => 'teléfono fijo',
            'c_telefono_celular' => 'teléfono celular',
            'c_email' => 'correo electrónico',
            'min_equipo' => 'equipo técnico',
            'max_equipo' => 'equipo técnico'
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
