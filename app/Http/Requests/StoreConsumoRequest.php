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
            // Nuevos campos
            'fecha_emision'         => 'nullable|date',
            'fecha_vencimiento'     => 'nullable|date|after_or_equal:fecha_emision',
            'valor'                 => 'nullable|numeric|min:0',
        ];
    }
}
