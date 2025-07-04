<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
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
        $clienteId = $this->route('cliente')->id;
        $medidorId = $this->route('cliente')->medidor->id ?? null;

        return [
            'code_suministro'           => [
                                            'required','string',
                                            Rule::unique('clientes','code_suministro')->ignore($clienteId)
                                          ],
            'nombre'                    => 'required|string|max:100',
            'apellido'                  => 'required|string|max:100',
            'dni'                       => [
                                            'required','string','max:20',
                                            Rule::unique('clientes','dni')->ignore($clienteId)
                                          ],
            'direccion'                 => 'nullable|string|max:255',
            'telefono'                  => 'nullable|string|max:20',
            'email'                     => [
                                            'nullable','email','max:150',
                                            Rule::unique('clientes','email')->ignore($clienteId)
                                          ],
            'manzana_id'                => 'required|exists:manzana,id',
            'crear_medidor'             => 'boolean',

            // todos opcionales:
            'medidor_codigo'            => [
                                            'nullable',
                                            'string',
                                            Rule::unique('medidores','codigo')->ignore($medidorId),
                                          ],
            'tarifa_id'                 => ['nullable','exists:tarifas,id'],
            'consumo_sin_medidor_id'    => ['nullable','exists:consumos_sin_medidor,id'],

            'medidor_fecha_instalacion' => 'nullable|date',
            'ubicacion_detallada'       => 'nullable|string|max:255',
        ];
    }
}
