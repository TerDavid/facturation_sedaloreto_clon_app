<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $clienteId = $this->route('cliente')->id;

        return [
            'nombre'               => 'required|string|max:100',
            'apellido'             => 'required|string|max:100',
            'dni'                  => [
                                        'required','string',
                                        Rule::unique('clientes','dni')->ignore($clienteId)
                                       ],
            'celular'              => 'nullable|string|max:20',
            'correo'               => 'nullable|email|max:150',
            'direccion'            => 'nullable|string|max:255',
            'estado'               => 'required|in:0,1,2',
            'codigo_suministro'    => [
                                        'nullable','string',
                                        Rule::unique('clientes','codigo_suministro')->ignore($clienteId)
                                       ],
            'ciudad_id'            => 'required|exists:ciudades,id',
            'medidor_id'           => 'nullable|exists:medidor,id',
            'tarifa_id'            => 'nullable|exists:tarifas,id',
            'consumo_sin_medidor_id'=> 'nullable|exists:consumos_sin_medidor,id',
            'sector_id'             => 'nullable|exists:sector,id',      // ← añadido
            'manzana_id'            => 'nullable|exists:manzana,id',    // ← añadido
        ];
    }
}
