<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionEnvioPostulacionColectiva extends FormRequest
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
            'url_declaracion_representante' => ['required', 'file', 'mimes:pdf,zip,rar', 'max:2048'],
            'url_declaracion_equipo' => ['required', 'file', 'mimes:pdf,zip,rar', 'max:2048'],
            'url_acta_modalidad_colectiva' => ['required', 'file', 'mimes:pdf,zip,rar', 'max:2048'],
            'url_documento_imagen' => ['required', 'url', 'max:255'],
            'url_video' => ['required', 'url', 'max:255'],
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
            'url_declaracion_representante' => 'declaración del representante',
            'url_declaracion_equipo' => 'declaración del equipo',
            'url_documento_imagen' => 'documentos y/o imagenes',
            'url_video' => 'URL del video'
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
