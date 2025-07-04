<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1) Leer rango de fecha
        $start = $request->query('start_date');
        $end   = $request->query('end_date');

        // Helper para filtrar por fecha_emision en consumos
        $applyDateFilter = function($query, $field) use($start, $end) {
            if ($start) {
                $query->whereDate($field, '>=', $start);
            }
            if ($end) {
                $query->whereDate($field, '<=', $end);
            }
        };

        // 1) Volumen total m³ por ciudad (solo clientes con medidor)
        $volQuery = Consumo::join('clientes','consumos.cliente_id','clientes.id')
            ->join('medidores','clientes.id','medidores.cliente_id')
            ->join('manzana','clientes.id_manzana','manzana.id')
            ->join('ciudades','manzana.id_ciudad','ciudades.id')
            ->select('ciudades.nombre', DB::raw('SUM(consumos.m3_consumidos) as total_m3'))
            ->whereNotNull('consumos.m3_consumidos');
        $applyDateFilter($volQuery, 'consumos.fecha_emision');
        $volumenPorCiudad = $volQuery
            ->groupBy('ciudades.nombre')
            ->orderBy('ciudades.nombre')
            ->get();

        // 2) Evolución mensual de valor por ciudad
        $rawQuery = Consumo::join('clientes','consumos.cliente_id','clientes.id')
            ->join('manzana','clientes.id_manzana','manzana.id')
            ->join('ciudades','manzana.id_ciudad','ciudades.id')
            ->select([
                DB::raw("DATE_FORMAT(consumos.fecha_emision,'%Y-%m') as mes"),
                'ciudades.nombre as ciudad',
                DB::raw('SUM(consumos.valor) as total_valor')
            ])
            ->whereNotNull('consumos.valor');
        $applyDateFilter($rawQuery, 'consumos.fecha_emision');
        $raw = $rawQuery
            ->groupBy('mes','ciudades.nombre')
            ->orderBy('mes')
            ->get();

        $meses    = $raw->pluck('mes')->unique()->values();
        $ciudades = $raw->pluck('ciudad')->unique()->values();
        $serieValorPorCiudad = $ciudades->mapWithKeys(function($ciudad) use($meses, $raw) {
            $valores = $meses->map(function($m) use($ciudad, $raw) {
                $row = $raw->first(fn($r)=> $r->ciudad === $ciudad && $r->mes === $m);
                return $row?->total_valor ?? 0;
            });
            return [$ciudad => $valores];
        });

        // 3) Número de clientes con consumo en rango, por ciudad
        $cliQuery = Consumo::join('clientes','consumos.cliente_id','clientes.id')
            ->join('manzana','clientes.id_manzana','manzana.id')
            ->join('ciudades','manzana.id_ciudad','ciudades.id')
            ->select(
                'ciudades.nombre as ciudad',
                DB::raw('COUNT(DISTINCT clientes.id) as total_clientes')
            );
        $applyDateFilter($cliQuery, 'consumos.fecha_emision');
        $clientesPorCiudad = $cliQuery
            ->groupBy('ciudades.nombre')
            ->orderBy('ciudades.nombre')
            ->get();

        return view('dashboard', compact(
            'volumenPorCiudad',
            'meses',
            'ciudades',
            'serieValorPorCiudad',
            'clientesPorCiudad',
            'start',
            'end'
        ));
    }
}
