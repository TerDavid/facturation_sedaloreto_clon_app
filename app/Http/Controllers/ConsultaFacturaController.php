<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumo;
use App\Models\Ciudad;
use App\Models\Cliente;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ConsultaFacturaController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('welcome', compact('ciudades'));
    }

    public function consultar(Request $request)
    {
        $data = $request->validate([
            'codigo'     => ['required','string','exists:clientes,code_suministro'],
            'ciudad'     => ['required','integer','exists:ciudades,id'],
            'recibo_id'  => ['nullable','integer','exists:consumos,id'],
        ]);

        // 1) Cliente
        $cliente = Cliente::where('code_suministro', $data['codigo'])
            ->whereHas('manzana', fn($q) => $q->where('id_ciudad', $data['ciudad']))
            ->firstOrFail();

        // 2) Todos los recibos
        $recibos = Consumo::with('cliente.manzana.ciudad')
            ->where('cliente_id', $cliente->id)
            ->whereNotNull('fecha_emision')
            ->orderByDesc('fecha_emision')
            ->get();

        // 3) ¿Cuál mostrar?
        if (! empty($data['recibo_id'])) {
            // si vino de hacer click en un mes concreto
            $consumo = $recibos->firstWhere('id', $data['recibo_id']);
        } else {
            // por defecto intentamos el mes actual
            $hoy = Carbon::now();
            $consumo = $recibos->firstWhere(fn($r) =>
                Carbon::parse($r->fecha_emision)->year  == $hoy->year &&
                Carbon::parse($r->fecha_emision)->month == $hoy->month
            );
            // si no hay, el más reciente
            $consumo = $consumo ?? $recibos->first();
        }

        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('welcome', compact('ciudades','recibos','consumo','data'));
    }

    public function descargar(Request $request, string $codigo)
    {
        // 1) Tomamos recibo_id de la query string (si existe)
        $reciboId = $request->query('recibo_id');

        // 2) Base del query: filtramos por cliente y solo emitidos
        $query = Consumo::with('cliente.manzana.ciudad')
            ->whereHas('cliente', fn($q) => $q->where('code_suministro', $codigo))
            ->whereNotNull('fecha_emision');

        // 3) Si recibo_id viene, filtramos por él
        if ($reciboId) {
            $query->where('id', $reciboId);
        } else {
            // si no, ordenamos para tomar el más reciente
            $query->orderByDesc('fecha_emision');
        }

        $consumo = $query->firstOrFail();

        // 4) Generamos el PDF
        $pdf = PDF::loadView('pdf.recibo', compact('consumo'));

        // Nombre legible: incorporamos año_mes para diferenciar
        $fecha = Carbon::parse($consumo->fecha_emision)->format('Y_m');
        return $pdf->download("recibo_{$codigo}_{$fecha}.pdf");
    }
}
