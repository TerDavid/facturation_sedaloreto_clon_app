<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $id = $this->route('cliente')->id;

        return [
            'code_suministro'           => ['required','string',
                                           Rule::unique('clientes','code_suministro')->ignore($id)],
            'nombre'                    => 'required|string|max:100',
            'direccion'                 => 'nullable|string|max:255',
            'telefono'                  => 'nullable|string|max:20',
            'email'                     => ['nullable','email','max:150',
                                           Rule::unique('clientes','email')->ignore($id)],
            'manzana_id'                => 'required|exists:manzana,id',
            'crear_medidor'             => 'boolean',
            'medidor_codigo'            => ['required_if:crear_medidor,true','string',
                                           Rule::unique('medidores','codigo')
                                                ->ignore($this->route('cliente')->medidor->id ?? 0)],
            'medidor_fecha_instalacion' => 'nullable|date',
            'ubicacion_detallada'       => 'nullable|string|max:255',
            'tarifa_id'                 => 'required_if:crear_medidor,true|exists:tarifas,id',
            'consumo_sin_medidor_id'    => 'required_if:crear_medidor,false|exists:consumos_sin_medidor,id',
        ];
    }
}
