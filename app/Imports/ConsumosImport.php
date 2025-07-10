<?php

namespace App\Imports;

use App\Models\Consumo;
use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\{
    ToModel,
    WithHeadingRow
};

class ConsumosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1) Busca el cliente por su código de suministro
        $cliente = Cliente::where('code_suministro', $row['codigo_suministro'])->first();
        if (! $cliente) {
            return null;
        }

        // 2) Convierte el valor de consumo
        $valor = $row['m³_consumidos'] ?? $row['m3_consumidos'] ?? null;
        if (is_null($valor)) {
            return null;
        }

        // 3) Actualiza (o crea) solo m3_consumidos + deja el resto en null
        $consumo = Consumo::firstOrNew([
            'cliente_id' => $cliente->id,
            // podrías usar también 'fecha_emision'/'mes_factura' para identificar mes
        ]);
        $consumo->m3_consumidos = $valor;
        $consumo->save();

        return null;
    }
}
