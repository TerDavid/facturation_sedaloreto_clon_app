<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMedidorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo_medidor'  => [
                'required','string',
                Rule::unique('medidor','codigo_medidor')->ignore($this->route('medidor'))
            ],
            'id_sector'       => 'required|exists:sector,id',
            'id_manzana'      => 'required|exists:manzana,id',
            'ciudad_id'       => 'required|exists:ciudades,id',
            'estado_medidor'  => 'required|in:0,1,2',
        ];
    }
}
