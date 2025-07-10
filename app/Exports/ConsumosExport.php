<?php

namespace App\Exports;

use App\Models\Consumo;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConsumosExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        [$year, $month] = explode('-', $this->filters['month']);

        $q = Consumo::with(['cliente.manzana.ciudad', 'cliente.manzana.sector'])
            // filtramos por fecha de emisión
            ->whereYear('fecha_emision', $year)
            ->whereMonth('fecha_emision', $month);

        if ($this->filters['ciudad_id']) {
            $q->whereHas('cliente.manzana.ciudad', fn($q2) =>
                $q2->where('id', $this->filters['ciudad_id'])
            );
        }
        if ($this->filters['sector_id']) {
            $q->whereHas('cliente.manzana.sector', fn($q2) =>
                $q2->where('id', $this->filters['sector_id'])
            );
        }
        if ($this->filters['manzana_id']) {
            $q->whereHas('cliente.manzana', fn($q2) =>
                $q2->where('id', $this->filters['manzana_id'])
            );
        }

        return $q->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código Suministro',
            'Ciudad',
            'Sector',
            'Manzana',
            'Cliente',
            'Dirección',
            'm³ Consumidos',
            'Fecha Emisión',
        ];
    }

    public function map($c): array
    {
        // $c->fecha_emision puede ser string o Carbon, así que lo parseamos siempre:
        $fecha = $c->fecha_emision instanceof Carbon
               ? $c->fecha_emision->format('Y-m-d')
               : Carbon::parse($c->fecha_emision)->format('Y-m-d');

        return [
            $c->id,
            $c->cliente->code_suministro,
            $c->cliente->manzana->ciudad->nombre,
            $c->cliente->manzana->sector->sector,
            $c->cliente->manzana->manzana,
            "{$c->cliente->nombre} {$c->cliente->apellido}",
            $c->cliente->direccion,
            null,       // se deja en blanco para llenar después
            $fecha,
        ];
    }
}
