<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Consumo;
use App\Models\ConsumoSinMedidor;
use App\Models\Manzana;
use App\Models\Sector;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsumosExport;
use App\Imports\ConsumosImport;
use App\Http\Requests\StoreConsumoRequest;
use App\Http\Requests\UpdateConsumoRequest;

class ConsumoController extends Controller
{
    public function index()
    {
        $consumos = Consumo::with([
                'cliente.manzana.ciudad',
                'cliente.manzana.sector',
            ])
            ->orderByDesc('hora_registro_consumo')
            ->get();

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
        $consumo = Consumo::create($request->validated());

        if ($consumo->m3_consumidos !== null) {
            [$total, $conceptos] = $this->calcularValorYConceptos($consumo);
            $consumo->update([
                'valor'     => $total,
                'conceptos' => json_encode($conceptos),
            ]);
        }

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

        if ($consumo->m3_consumidos !== null) {
            [$total, $conceptos] = $this->calcularValorYConceptos($consumo);
            $consumo->update([
                'valor'     => $total,
                'conceptos' => json_encode($conceptos),
            ]);
        } else {
            $consumo->update([
                'valor'     => null,
                'conceptos' => null,
            ]);
        }

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
            'ciudad_id'        => 'nullable|exists:ciudades,id',
            'sector_id'        => 'nullable|exists:sector,id',
            'manzana_id'       => 'nullable|exists:manzana,id',
            'fecha_emision'    => 'required|date',
            'fecha_vencimiento'=> 'required|date|after_or_equal:fecha_emision',
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
                'fecha_emision'         => $data['fecha_emision'],
                'fecha_vencimiento'     => $data['fecha_vencimiento'],
                'valor'                 => null,
                'conceptos'             => null,
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

        $data['month'] = $data['month'] ?? now()->format('Y-m');
        $filename      = "consumos_{$data['month']}.xlsx";

        return Excel::download(new ConsumosExport($data), $filename);
    }

    public function importar(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        // 1) Importar los consumos
        Excel::import(new ConsumosImport, $request->file('file'));

        // 2) Tras la importación, recalcular valor y conceptos
        Consumo::whereNotNull('m3_consumidos')
            ->whereNull('valor')
            ->get()
            ->each(function(Consumo $consumo) {
                [$total, $conceptos] = $this->calcularValorYConceptos($consumo);
                $consumo->update([
                    'valor'     => $total,
                    'conceptos' => json_encode($conceptos),
                ]);
            });

        return redirect()
            ->route('facturation.consumo.index')
            ->with('success', 'Consumos importados y valores calculados correctamente.');
    }

    /**
     * Calcula el valor total y el detalle de conceptos
     * únicamente cuando hay un consumo medido.
     *
     * @return array [$total, $conceptos]
     */
    protected function calcularValorYConceptos(Consumo $consumo): array
    {
        $cliente   = $consumo->cliente;
        $categoria = $cliente->categoria;

        // 1) Determinar si el cliente tiene medidor
        $tieneMedidor = $cliente->medidor()->exists();

        if (! $tieneMedidor) {
            // --- SIN MEDIDOR: bloque fijo, usar id_consumo_sin_medidor ---
            $cs = $cliente->consumoSinMedidor;
            if (! $cs) {
                // defensivo: si no hay referencia, no cobramos nada
                return [0, []];
            }
            $m3 = $cs->asignado_m3;

            // La tarifa sin medidor ya está tabulada en tu primer pantallazo:
            // puedes definir un array con totales fijos, o bien volver a calcular
            // usando la tabla tarifas, pero con $m3 fijo.

            // Vamos a calcularlo para no duplicar valores:
            $t = Tarifa::where('categoria', $categoria)
                       ->where('rango_min','<=',$m3)
                       ->where(fn($q) =>
                           $q->whereNull('rango_max')
                             ->orWhere('rango_max','>=',$m3)
                       )
                       ->first();

            if (! $t) {
                return [0, []];
            }

            $aguaMonto = round($m3 * $t->tarifa_agua,       2);
            $alcMonto  = round($m3 * $t->tarifa_alcantarillado, 2);
            $fijoMonto = round($t->cargo_fijo,              2);
            $total     = round($aguaMonto + $alcMonto + $fijoMonto, 2);

            $conceptos = [
                ['concepto' => "Consumo sin medidor ({$m3} m³)", 'monto' => round($aguaMonto + $alcMonto, 2)],
                ['concepto' => 'Cargo fijo mensual',             'monto' => $fijoMonto],
            ];

            return [$total, $conceptos];
        }

        // --- CON MEDIDOR: cobro por lectura real ---
        $m3 = $consumo->m3_consumidos ?? 0;

        $t = Tarifa::where('categoria', $categoria)
                   ->where('rango_min','<=',$m3)
                   ->where(fn($q) =>
                       $q->whereNull('rango_max')
                         ->orWhere('rango_max','>=',$m3)
                   )
                   ->first();

        if (! $t) {
            return [0, []];
        }

        $aguaMonto = round($m3 * $t->tarifa_agua,       2);
        $alcMonto  = round($m3 * $t->tarifa_alcantarillado, 2);
        $fijoMonto = round($t->cargo_fijo,              2);
        $total     = round($aguaMonto + $alcMonto + $fijoMonto, 2);

        $conceptos = [
            ['concepto' => "Agua ({$m3} m³)",        'monto' => $aguaMonto],
            ['concepto' => 'Alcantarillado',         'monto' => $alcMonto],
            ['concepto' => 'Cargo fijo mensual',     'monto' => $fijoMonto],
        ];

        return [$total, $conceptos];
    }
    


}
