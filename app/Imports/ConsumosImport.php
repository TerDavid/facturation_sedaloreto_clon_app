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
            // Si no existe el cliente, la ignoramos
            return null;
        }

        // 2) Averigua el año/mes actual (o podrías parsear alguna columna con la fecha del Excel)
        $year  = now()->year;
        $month = now()->month;

        // 3) Comprueba si ya hay un consumo para este cliente en el mismo mes
        $existente = Consumo::where('cliente_id', $cliente->id)
            ->whereYear('hora_registro_consumo', $year)
            ->whereMonth('hora_registro_consumo', $month)
            ->first();

        // 4a) Si existe, actualízalo
        $valor = $row['m³_consumidos'] ?? $row['m3_consumidos'] ?? null;
        if ($existente) {
            $existente->m3_consumidos = $valor;
            $existente->save();
            // devolvemos null porque ya guardamos manualmente
            return null;
        }

        // 4b) Si no existe, creamos uno nuevo
        return new Consumo([
            'cliente_id'            => $cliente->id,
            'm3_consumidos'         => $valor,
            'hora_registro_consumo' => now(),
        ]);
    }
}
