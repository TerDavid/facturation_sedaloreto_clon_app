<?php

namespace App\Imports;

use App\Models\Consumo;
use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ConsumosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1) Cliente por código de suministro
        $cliente = Cliente::where('code_suministro', $row['codigo_suministro'])->first();
        if (! $cliente) {
            return null;
        }

        // 2) Valor de consumo (m3)
        $valor = $row['m3_consumidos']
               ?? $row['m³_consumidos']
               ?? null;
        if (is_null($valor)) {
            return null;
        }

        // 3) Fecha de emisión (se asume columna 'fecha_emision' en formato YYYY-MM-DD)
        try {
            $fechaEmi = Carbon::parse($row['fecha_emision']);
        } catch (\Exception $e) {
            return null;
        }

        // 4) Buscamos si ya existe un Consumo para este cliente y este mes
        $consumo = Consumo::where('cliente_id', $cliente->id)
            ->whereYear('fecha_emision',  $fechaEmi->year)
            ->whereMonth('fecha_emision', $fechaEmi->month)
            ->first();

        if ($consumo) {
            // 4a) Si existe y aún no tiene lectura, la actualizamos
            if (is_null($consumo->m3_consumidos)) {
                $consumo->update([
                    'm3_consumidos' => $valor,
                ]);
            }
        } else {
            // 4b) Si no existe, creamos uno nuevo
            Consumo::create([
                'cliente_id'            => $cliente->id,
                'm3_consumidos'         => $valor,
                'hora_registro_consumo' => now(),
                'fecha_emision'         => $fechaEmi->format('Y-m-d'),
                // Si tu Excel trae fecha de vencimiento, usa esa columna;
                // si no, por ejemplo le damos +1 mes
                'fecha_vencimiento'     => isset($row['fecha_vencimiento'])
                    ? Carbon::parse($row['fecha_vencimiento'])->format('Y-m-d')
                    : $fechaEmi->copy()->addMonth()->format('Y-m-d'),
                'valor'                 => null,
                'conceptos'             => null,
            ]);
        }

        return null;
    }
}
