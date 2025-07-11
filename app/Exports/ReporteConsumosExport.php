<?php
// app/Exports/ReporteConsumosExport.php
namespace App\Exports;

use App\Models\Consumo;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{FromArray, ShouldAutoSize};

class ReporteConsumosExport implements FromArray, ShouldAutoSize
{
    protected $ciudadId, $sectorId, $manzanaId, $month, $year;

    public function __construct(array $filters = [])
    {
        $this->ciudadId  = $filters['ciudad_id']  ?? null;
        $this->sectorId  = $filters['sector_id']  ?? null;
        $this->manzanaId = $filters['manzana_id'] ?? null;
        $this->month     = $filters['month']      ?? null;
        $this->year      = $filters['year']       ?? null;
    }

   public function array(): array
{
    // 1) Cabecera
    $rows = [[
        'ID','Código suministro','Ciudad','Sector','Manzana',
        'Cliente','Dirección','m³ Consumidos',
        'Fecha emisión','Fecha vencimiento','Valor S/'
    ]];

    // 2) Base query con filtros de ubicación
    $q = Consumo::with(['cliente.manzana.ciudad','cliente.manzana.sector']);
    if ($this->ciudadId)  $q->whereHas('cliente.manzana.ciudad', fn($q2)=> $q2->where('id',$this->ciudadId));
    if ($this->sectorId)  $q->whereHas('cliente.manzana.sector', fn($q2)=> $q2->where('id',$this->sectorId));
    if ($this->manzanaId) $q->where('id_manzana',$this->manzanaId);

    // 3) **SIEMPRE** filtramos mes o año si vienen **por separado**
    if ($this->month) {
        $q->whereMonth('fecha_emision',$this->month);
    }
    if ($this->year) {
        $q->whereYear('fecha_emision',$this->year);
    }

    $all = $q->orderByDesc('fecha_emision')->get();

    if ($all->isEmpty()) {
        return $rows;
    }

    // 4) Si hay **cualquier** filtro, salida plana
    if ($this->ciudadId || $this->sectorId || $this->manzanaId || $this->month || $this->year) {
        foreach ($all as $c) {
            $rows[] = [
                $c->id,
                $c->cliente->code_suministro,
                $c->cliente->manzana->ciudad->nombre,
                $c->cliente->manzana->sector->sector,
                $c->cliente->manzana->manzana,
                "{$c->cliente->nombre} {$c->cliente->apellido}",
                $c->cliente->direccion,
                $c->m3_consumidos,
                Carbon::parse($c->fecha_emision)->format('Y-m-d'),
                Carbon::parse($c->fecha_vencimiento)->format('Y-m-d'),
                number_format($c->valor,2),
            ];
        }
        return $rows;
    }

    // 5) Sin filtros → agrupado por mes con subtotales (igual que antes)
    $grouped = $all->groupBy(fn($c)=> Carbon::parse($c->fecha_emision)->format('Y-m'));
    $grandTotal = 0;
    foreach ($grouped as $period => $group) {
        $dt = Carbon::createFromFormat('Y-m',$period)->locale('es');
        $rows[] = ["MES: ".$dt->isoFormat('MMMM YYYY')];
        $sub = 0;
        foreach ($group as $c) {
            $val = round($c->valor,2);
            $rows[] = [
                $c->id, $c->cliente->code_suministro,
                $c->cliente->manzana->ciudad->nombre,
                $c->cliente->manzana->sector->sector,
                $c->cliente->manzana->manzana,
                "{$c->cliente->nombre} {$c->cliente->apellido}",
                $c->cliente->direccion,
                $c->m3_consumidos,
                Carbon::parse($c->fecha_emision)->format('Y-m-d'),
                Carbon::parse($c->fecha_vencimiento)->format('Y-m-d'),
                number_format($val,2),
            ];
            $sub += $val;
        }
        $rows[] = array_merge(array_fill(0, 9, ''), ['Subtotal:', number_format($sub,2)]);
        $grandTotal += $sub;
    }
    $rows[] = array_merge(array_fill(0, 9, ''), ['TOTAL GENERAL:', number_format($grandTotal,2)]);

    return $rows;
}

}
