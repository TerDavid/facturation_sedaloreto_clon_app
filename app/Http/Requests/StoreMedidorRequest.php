<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedidorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo_medidor'  => 'required|string|unique:medidor,codigo_medidor',
            'id_sector'       => 'required|exists:sector,id',
            'id_manzana'      => 'required|exists:manzana,id',
            'ciudad_id'       => 'required|exists:ciudades,id',
            'estado_medidor'  => 'required|in:0,1,2',
        ];
    }
}
