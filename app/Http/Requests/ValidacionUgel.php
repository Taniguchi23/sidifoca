<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionUgel extends FormRequest
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
                'id_dre_gre' => ['required', 'integer'],
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_MAE_UGEL')->where(function ($query) {
                    return $query->where([
                        ['id_dre_gre', '=', $this->input('id_dre_gre')],
                        ['id_ugel', '<>', $this->route('id')]
                    ]);
                })],
                'flg_grupo_especial' => ['required', 'boolean'],
                'flg_estado' => ['required', 'boolean']
            ];
        } else {
            return [
                'id_dre_gre' => ['required', 'integer'],
                'descripcion' => ['required', 'description', 'max:255', Rule::unique('T_MAE_UGEL')->where(function ($query) {
                    return $query->where([
                        ['id_dre_gre', '=', $this->input('id_dre_gre')]
                    ]);
                })],
                'flg_grupo_especial' => ['required', 'boolean']
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
            'id_dre_gre' => 'DRE / GRE',
            'descripcion' => 'descripción',
            'flg_grupo_especial' => ' grupo especial',
            'flg_estado' => 'estado'
        ];
    }
}
