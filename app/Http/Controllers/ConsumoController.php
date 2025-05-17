<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\Sector;
use App\Models\Manzana;
use Illuminate\Http\Request;
use App\Http\Requests\StoreConsumoRequest;
use App\Http\Requests\UpdateConsumoRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsumosExport;

class ConsumoController extends Controller
{
    public function index()
    {
        // Eager-load de cliente→manzana→(ciudad,sector)
        $consumos = Consumo::with([
            'cliente.manzana.ciudad',
            'cliente.manzana.sector',
        ])
        ->orderByDesc('hora_registro_consumo')
        ->get();

        // Datos para el pop-up
        $ciudades    = Ciudad::orderBy('nombre')->get(['id','nombre']);
        $allSectores = Sector::orderBy('sector')->get(['id','id_ciudad','sector']);
        $allManzanas = Manzana::orderBy('manzana')->get(['id','id_sector','manzana']);

        return view('facturation.consumo.index', compact(
            'consumos','ciudades','allSectores','allManzanas'
        ));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('code_suministro')->get();
        return view('facturation.consumo.create', compact('clientes'));
    }

    public function store(StoreConsumoRequest $request)
    {
        Consumo::create($request->validated());
        return redirect()
            ->route('facturation.consumo.index')
            ->with('success', 'Consumo registrado correctamente.');
    }

    public function edit(Consumo $consumo)
    {
        $clientes = Cliente::orderBy('code_suministro')->get();
        return view('facturation.consumo.edit', compact('consumo','clientes'));
    }

    public function update(UpdateConsumoRequest $request, Consumo $consumo)
    {
        $consumo->update($request->validated());
        return redirect()
            ->route('facturation.consumo.index')
            ->with('success', 'Consumo actualizado correctamente.');
    }

    public function destroy(Consumo $consumo)
    {
        $consumo->delete();
        return redirect()
            ->route('facturation.consumo.index')
            ->with('success', 'Consumo eliminado correctamente.');
    }

    public function emitir(Request $request)
    {
        $data = $request->validate([
            'ciudad_id'  => 'nullable|exists:ciudades,id',
            // Tu tabla se llama "sector" (singular), no "sectores"
            'sector_id'  => 'nullable|exists:sector,id',
            // Tu tabla se llama "manzana" (singular)
            'manzana_id' => 'nullable|exists:manzana,id',
        ]);

        $year  = now()->year;
        $month = now()->month;

        $q = Cliente::query()
            ->whereDoesntHave('consumos', function($q2) use ($year, $month) {
                $q2->whereYear('hora_registro_consumo', $year)
                   ->whereMonth('hora_registro_consumo', $month);
            });

        if ($data['ciudad_id']) {
            $q->whereHas('manzana.ciudad', fn($q2) =>
                $q2->where('id', $data['ciudad_id'])
            );
        }
        if ($data['sector_id']) {
            $q->whereHas('manzana.sector', fn($q2) =>
                $q2->where('id', $data['sector_id'])
            );
        }
        if ($data['manzana_id']) {
            $q->where('id_manzana', $data['manzana_id']);
        }

        $clientes = $q->get();

        foreach ($clientes as $cli) {
            Consumo::create([
                'cliente_id'            => $cli->id,
                'm3_consumidos'         => null,
                'hora_registro_consumo' => now(),
            ]);
        }

        return response()->json([
            'message' => "Se emitieron facturas para {$clientes->count()} clientes este mes."
        ]);
    }

    public function exportar(Request $request)
    {
        $data = $request->validate([
            'ciudad_id'  => 'nullable|exists:ciudades,id',
            'sector_id'  => 'nullable|exists:sector,id',
            'manzana_id' => 'nullable|exists:manzana,id',
            'month'      => 'nullable|date_format:Y-m',
        ]);

        // por defecto mes actual si no enviaron
        $data['month'] = $data['month'] ?? now()->format('Y-m');

        $filename = "consumos_{$data['month']}.xlsx";

        return Excel::download(new ConsumosExport($data), $filename);
    }

}
