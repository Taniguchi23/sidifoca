<?php

namespace App\Http\Requests;

use App\Rules\CheckCantDirector;
use App\Rules\CheckCantEquipoTecnico;
use App\Rules\CheckMaxEquipoGobierno;
use App\Rules\CheckMinEquipoGobierno;
use App\Rules\CheckPostulacionDistrito;
use App\Rules\CheckPostulacionProvincia;
use App\Rules\CheckPostulacionUgel;
use App\Rules\CheckReniecDNI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionPostulacionColectiva extends FormRequest
{
    protected $ugeles_gobierno_local;

    public function __construct()
    {
        $this->ugeles_gobierno_local = config('constants.tipo_postulacion.ugeles_gobierno_local');
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
            'id_ugel' => [new CheckPostulacionUgel($this->route('id'))],
            'id_provincia' => [new CheckPostulacionProvincia($this->route('id'))],
            'id_distrito' => [new CheckPostulacionDistrito($this->route('id'))],
            'id_respuesta.*' => ['required', 'max:1000'],
            'buena_practica' => ['required', 'max:255'],
            'id_categoria' => ['required', 'integer'],
            'id_tema' => ['required', 'integer'],
            'nro_meses' => ['required', 'integer'],
            'nro_dias' => ['nullable', 'integer'],
            'id_gobierno_local_postulacion' => ['nullable', 'integer'],
            'm_id_gobierno_local' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'integer'],
            'm_nombre_alcalde' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'alpha_spaces', 'max:255'],
            'm_telefono' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'max:255'],
            'm_email' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'email:rfc,dns', 'max:255'],
            'm_nro_resolucion_pdlc' => ['nullable', 'max:255'],
            'm_nro_resolucion_pei' => ['nullable', 'max:255'],
            'm_nro_resolucion_pel' => ['nullable', 'max:255'],
            'm_gerencia_oficina_area' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'max:255'],
            'm_funcion_mof' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'max:255'],
            'm_espacios_coordinacion_ig_is' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'max:1000'],
            'id_contacto_gobierno_local' => ['nullable', 'integer'],
            'g_nombres' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'alpha_spaces', 'max:255'],
            'g_telefono_celular' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'max:255'],
            'g_email' => ['nullable', Rule::requiredIf(function () {
                return $this->input('id_tipo_postulacion') == $this->ugeles_gobierno_local;
            }), 'email:rfc,dns', 'max:1000'],
            'id_contacto_postulacion' => ['required', 'integer'],
            'c_nro_dni' => ['required', 'max:255', new CheckReniecDNI()],
            'c_nombres' => ['required', 'max:255'],
            'c_apellido_paterno' => ['required', 'max:255'],
            'c_apellido_materno' => ['nullable', 'max:255'],
            'c_telefono_fijo' => ['nullable', 'max:255'],
            'c_telefono_celular' => ['required', 'max:255'],
            'c_email' => ['required', 'email:rfc,dns', 'max:255'],
            'cant_director' => [new CheckCantDirector($this->route('id'))],
            'cant_equipo' => [new CheckCantEquipoTecnico($this->route('id'))],
            'min_gobierno' => [new CheckMinEquipoGobierno($this->route('id'), $this->input('id_tipo_postulacion') )],
            'max_gobierno' => [new CheckMaxEquipoGobierno($this->route('id'), $this->input('id_tipo_postulacion') )],
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
            'id_tipo_postulacion' => 'tipo de postulación',
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
            'id_gobierno_local_postulacion' => 'gobierno local postulación',
            'm_id_gobierno_local' => 'gobierno local',
            'm_nombre_alcalde' => 'nombre del alcalde',
            'm_telefono' => 'teléfono celular',
            'm_email' => 'correo electrónico',
            'm_nro_resolucion_pdlc' => 'N° de resolución PDLC',
            'm_nro_resolucion_pei' => 'N° de resolución PEI',
            'm_nro_resolucion_pel' => 'N° de resolución PEL',
            'm_gerencia_oficina_area' => 'gerencia/oficina/área',
            'm_funcion_mof' => 'función según MOF',
            'm_espacios_coordinacion_ig_is' => 'mencione los espacios existentes...',
            'id_contacto_gobierno_local' => 'contacto gobierno local',
            'g_nombres' => 'nombre del contacto',
            'g_telefono_celular' => 'teléfono celular',
            'g_email' => 'correo electrónico',
            'id_equipo_postulacion' => 'equipo técnico',
            'c_nro_dni' => 'N.° de DNI',
            'c_nombres' => 'nombres',
            'c_apellido_paterno' => 'apellido paterno',
            'c_apellido_materno' => 'apellido materno',
            'c_telefono_fijo' => 'teléfono fijo',
            'c_telefono_celular' => 'teléfono celular',
            'c_email' => 'correo electrónico',
            'min_gobierno' => 'equipo técnico del gobierno local',
            'max_gobierno' => 'equipo técnico del gobierno local'
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
