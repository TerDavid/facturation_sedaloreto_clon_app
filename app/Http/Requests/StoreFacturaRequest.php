<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacturaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 1) Múltiples clientes a facturar
            'cliente_ids'     => 'required|array|min:1',
            'cliente_ids.*'   => 'required|exists:clientes,id',

            // 2) Fechas y mes
            'fecha_emision'       => 'required|date',
            'fecha_vencimiento'   => 'required|date|after_or_equal:fecha_emision',
            // Usamos input type="month" en la vista
            'mes_factura'         => 'required|date_format:Y-m',

            // 3) Ya no recibimos numero_recibo: lo generamos en el controlador
            // 'numero_recibo'     => 'required|string|max:50',

            // No validamos valor_pago aquí: se calcula en el controlador
        ];
    }

    public function messages()
    {
        return [
            'cliente_ids.required'            => 'Debes seleccionar al menos un cliente.',
            'cliente_ids.array'               => 'Formato de selección de clientes inválido.',
            'cliente_ids.*.exists'            => 'Uno de los clientes seleccionados no existe.',
            'fecha_emision.required'          => 'La fecha de emisión es obligatoria.',
            'fecha_emision.date'              => 'Formato de fecha de emisión inválido.',
            'fecha_vencimiento.required'      => 'La fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.date'          => 'Formato de fecha de vencimiento inválido.',
            'fecha_vencimiento.after_or_equal'=> 'La fecha de vencimiento debe ser igual o posterior a la emisión.',
            'mes_factura.required'            => 'El mes de la factura es obligatorio.',
            'mes_factura.date_format'         => 'El mes de la factura debe tener el formato YYYY-MM.',
        ];
    }
}
