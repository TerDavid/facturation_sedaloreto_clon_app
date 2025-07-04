<?php

namespace App\Exports;

use App\Models\Consumo;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithMapping,
    WithHeadings,
    ShouldAutoSize
};

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
            ->whereYear('hora_registro_consumo', $year)
            ->whereMonth('hora_registro_consumo', $month);

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
            'Código Suministro',
            'Ciudad',
            'Sector',
            'Manzana',
            'Cliente',
            'Dirección',
            'm³ Consumidos',
            'Fecha / Hora',
        ];
    }

    public function map($c): array
    {
        return [
            $c->cliente->code_suministro,
            $c->cliente->manzana->ciudad->nombre,
            $c->cliente->manzana->sector->sector,
            $c->cliente->manzana->manzana,
            "{$c->cliente->nombre} {$c->cliente->apellido}",
            $c->cliente->direccion,
            $c->m3_consumidos,
            $c->hora_registro_consumo,
        ];
    }
}
