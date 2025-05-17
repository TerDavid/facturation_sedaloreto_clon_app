<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize() { return true; }

    protected function prepareForValidation()
    {
        if (! $this->has('crear_medidor')) {
            $this->merge(['crear_medidor' => false]);
        }
        $this->merge([
            'crear_medidor' => filter_var(
                $this->input('crear_medidor'),
                FILTER_VALIDATE_BOOLEAN
            ),
        ]);
    }

    public function rules(): array
    {
        return [
            'code_suministro'           => 'required|string|unique:clientes,code_suministro',
            'nombre'                    => 'required|string|max:100',
            'apellido'                  => 'required|string|max:100',
            'dni'                       => 'required|string|max:20|unique:clientes,dni',
            'direccion'                 => 'nullable|string|max:255',
            'telefono'                  => 'nullable|string|max:20',
            'email'                     => 'nullable|email|max:150|unique:clientes,email',
            'manzana_id'                => 'required|exists:manzana,id',
            'crear_medidor'             => 'boolean',

            // Ahora todos estos campos son opcionales:
            'medidor_codigo'            => 'nullable|string|unique:medidores,codigo',
            'tarifa_id'                 => 'nullable|exists:tarifas,id',
            'consumo_sin_medidor_id'    => 'nullable|exists:consumos_sin_medidor,id',

            // Siempre opcionales:
            'medidor_fecha_instalacion' => 'nullable|date',
            'ubicacion_detallada'       => 'nullable|string|max:255',
        ];
    }
}
