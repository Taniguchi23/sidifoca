<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionContrato extends FormRequest
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
        if ($this->input('fecha_inicio')) {
            $fechaFinValidacion = ['nullable', 'date_format:d/m/Y', 'after:fecha_inicio'];
        } else {
            $fechaFinValidacion = ['nullable', 'date_format:d/m/Y'];
        }

        if ($this->input('fecha_fin')) {
            $fechaInicioValidacion = ['required', 'date_format:d/m/Y'];
        } else {
            $fechaInicioValidacion = ['nullable', 'date_format:d/m/Y'];
        }

        if ($this->route('id')) {
            return [
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
                'id_nivel_puesto' => ['required', 'integer'],
                'id_area' => ['nullable', Rule::requiredIf(function () {
                    return in_array($this->input('id_tipo_entidad'), [$this->dre_gre, $this->ugel]);
                }), 'integer'],
                'id_puesto' => ['required', 'integer'],
                'id_regimen_laboral' => ['required', 'integer'],
                'id_nivel_educativo' => ['nullable', 'integer'],
                'id_profesion' => ['nullable', 'integer'],
                'fecha_inicio' => $fechaInicioValidacion,
                'fecha_fin' => $fechaFinValidacion,
                'url_documento' => ['nullable', 'file', 'mimes:pdf,jpeg,bmp,png', 'max:2048']
            ];
        } else {
            return [
                'id_usuario' => ['required', 'max:36'],
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
                'id_nivel_puesto' => ['required', 'integer'],
                'id_area' => ['nullable', Rule::requiredIf(function () {
                    return in_array($this->input('id_tipo_entidad'), [$this->dre_gre, $this->ugel]);
                }), 'integer'],
                'id_puesto' => ['required', 'integer'],
                'id_regimen_laboral' => ['required', 'integer'],
                'id_nivel_educativo' => ['nullable', 'integer'],
                'id_profesion' => ['nullable', 'integer'],
                'fecha_inicio' => $fechaInicioValidacion,
                'fecha_fin' => $fechaFinValidacion,
                'url_documento' => ['nullable', 'file', 'mimes:pdf,jpeg,bmp,png', 'max:2048']
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
            'id_usuario' => 'usuario',
            'id_tipo_entidad' => 'tipo de entidad',
            'id_dre_gre' => 'DRE / GRE',
            'id_ugel' => 'UGEL',
            'id_entidad_externa' => 'entidad externa',
            'id_nivel_puesto' => 'nivel del puesto',
            'id_puesto' => 'nombre del puesto',
            'id_area' => 'área en la que labora',
            'id_regimen_laboral' => 'régimen laboral',
            'id_nivel_educativo' => 'nivel educativo',
            'id_profesion' => 'profesión',
            'fecha_inicio' => 'fecha de inicio del contrato',
            'fecha_fin' => 'fecha de fin del contrato',
            'url_documento' => 'contrato/resolución/orden de servicio',
            'flg_estado' => 'estado'
        ];
    }
}
