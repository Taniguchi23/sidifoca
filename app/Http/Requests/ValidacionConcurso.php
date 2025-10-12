<?php

namespace App\Http\Requests;

use App\Concurso;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionConcurso extends FormRequest
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
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_GENM_CONCURSO')->where(function ($query) {
                    return $query->where([
                        ['id_concurso', '<>', $this->route('id')]
                    ]);
                })],
                'fecha_inicio' => ['required', 'date_format:d/m/Y'],
                'fecha_termino' => ['required', 'date_format:d/m/Y', 'after:fecha_inicio'],
                'url_bases_concurso' => ['nullable', 'file', 'max:2000', 'mimes:pdf,doc,docx,odt'],
                'url_acta_modalidad_colectiva' => ['nullable', 'file', 'max:2000', 'mimes:pdf,doc,docx,odt'],
                'flg_estado' => ['required', 'boolean']
            ];
        } else {
            return [
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_GENM_CONCURSO')],
                'fecha_inicio' => ['required', 'date_format:d/m/Y'],
                'fecha_termino' => ['required', 'date_format:d/m/Y', 'after:fecha_inicio'],
                'url_bases_concurso' => ['nullable', 'file', 'max:2000', 'mimes:pdf,doc,docx,odt'],
                'url_acta_modalidad_colectiva' => ['nullable', 'file', 'max:2000', 'mimes:pdf,doc,docx,odt'],
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
            'descripcion' => 'descripción',
            'fecha_inicio' => 'fecha de inicio',
            'fecha_termino' => 'fecha de termino',
            'url_bases_concurso' => 'bases de concurso',
            'url_acta_modalidad_colectiva' => 'Acta Modalidad Colectiva',
            'flg_estado' => 'estado'
        ];
    }
}
