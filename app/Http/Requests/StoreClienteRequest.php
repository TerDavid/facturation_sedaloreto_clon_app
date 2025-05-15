<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StoreClienteRequest extends FormRequest
{
    public function authorize() { return true; }
    public function prepareForValidation()
{
    // Si 'crear_medidor' no está presente, establecerlo como false
    if (!$this->has('crear_medidor')) {
        $this->merge([
            'crear_medidor' => false,
        ]);
    }

    // Opcional: Convertir valores string como "true"/"false" a booleanos
    $crearMedidor = filter_var($this->input('crear_medidor'), FILTER_VALIDATE_BOOLEAN);

    $this->merge([
        'crear_medidor' => $crearMedidor,
    ]);
}
    public function rules()
    {
        // dd($this);
        Log::info("Datos recibidos:", $this->all());
        Log::info("Valor consumo_sin_medidor_id:", ['id' => $this->input('consumo_sin_medidor_id')]);

        return [
            'code_suministro'           => 'required|string|unique:clientes,code_suministro',
            'nombre'                    => 'required|string|max:100',
            'direccion'                 => 'nullable|string|max:255',
            'telefono'                  => 'nullable|string|max:20',
            'email'                     => 'nullable|email|max:150|unique:clientes,email',
            'manzana_id'                => 'required|exists:manzana,id',
            'crear_medidor'             => 'boolean',
            'medidor_codigo'            => 'required_if:crear_medidor,true|string|nullable|unique:medidores,codigo',
            'medidor_fecha_instalacion' => 'nullable|date',
            'ubicacion_detallada'       => 'nullable|string|max:255',
            'tarifa_id'                 => 'required_if:crear_medidor,true|nullable|exists:tarifas,id',
            'consumo_sin_medidor_id'    => 'required_if:crear_medidor,false|exists:consumos_sin_medidor,id',
        ];
    }
}
