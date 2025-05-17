<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id'             => 'required|exists:clientes,id',
            'm3_consumidos'          => 'nullable|integer|min:0',
            'hora_registro_consumo'  => 'nullable|date',
        ];
    }
}
