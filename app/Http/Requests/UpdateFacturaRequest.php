<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFacturaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $facturaId = $this->route('factura')->id;

        return [
            'cliente_id'              => 'required|exists:clientes,id',
            'ciudad_id'               => 'nullable|exists:ciudades,id',
            'sector_id'               => 'nullable|exists:sectors,id',
            'manzana_id'              => 'nullable|exists:manzanas,id',
            'medidor_id'              => 'nullable|exists:medidors,id',
            'tarifa_id'               => 'nullable|exists:tarifas,id',
            'consumo_sin_medidor_id'  => 'nullable|exists:consumos_sin_medidor,id',
            'fecha_emision'           => 'required|date',
            'fecha_vencimiento'       => 'required|date|after_or_equal:fecha_emision',
            'valor_pago'              => 'nullable|numeric|min:0',
            'numero_recibo'           => [
                                            'required',
                                            'string',
                                            Rule::unique('facturas','numero_recibo')->ignore($facturaId)
                                        ],
            'mes_factura'             => 'required|string|max:20',
        ];
    }
}
