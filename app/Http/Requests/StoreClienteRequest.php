<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'nombre'               => 'required|string|max:100',
            'apellido'             => 'required|string|max:100',
            'dni'                  => 'required|string|unique:clientes,dni',
            'celular'              => 'nullable|string|max:20',
            'correo'               => 'nullable|email|max:150',
            'direccion'            => 'nullable|string|max:255',
            'estado'               => 'required|in:0,1,2',
            'codigo_suministro'    => 'nullable|string|unique:clientes,codigo_suministro',
            'ciudad_id'            => 'nullable|exists:ciudades,id',
            'sector_id'             => 'nullable|exists:sector,id',         // ←
            'manzana_id'            => 'nullable|exists:manzana,id',       // ←
            'medidor_id'           => 'nullable|exists:medidor,id',
            'tarifa_id'            => 'nullable|exists:tarifas,id',
            'consumo_sin_medidor_id'=> 'nullable|exists:consumos_sin_medidor,id',
        ];
    }
}
