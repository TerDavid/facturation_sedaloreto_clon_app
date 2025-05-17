<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumo;
use App\Models\Ciudad;
use Carbon\Carbon;
// Importa la fachada de DOMPDF directamente
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
            'codigo' => ['required','string','exists:clientes,code_suministro'],
            'ciudad' => ['required','integer','exists:ciudades,id'],
        ]);

        $now = Carbon::now();

        $consumo = Consumo::with('cliente.manzana.ciudad')
            ->whereNotNull('fecha_emision')
            ->whereYear('fecha_emision', $now->year)
            ->whereMonth('fecha_emision', $now->month)
            ->whereHas('cliente', function($q) use($data) {
                $q->where('code_suministro', $data['codigo'])
                  ->whereHas('manzana', fn($q2) =>
                      $q2->where('id_ciudad', $data['ciudad'])
                  );
            })
            ->first();

        $ciudades = Ciudad::orderBy('nombre')->get();

        if (! $consumo) {
            return back()
                ->withInput()
                ->with('error','No se encontró ningún recibo emitido para el mes actual.')
                ->with(compact('ciudades'));
        }

        return view('welcome', compact('consumo','ciudades'));
    }

    public function descargar(string $codigo)
    {
        $now = Carbon::now();

        $consumo = Consumo::with('cliente.manzana.ciudad')
            ->whereNotNull('fecha_emision')
            ->whereYear('fecha_emision', $now->year)
            ->whereMonth('fecha_emision', $now->month)
            ->whereHas('cliente', fn($q) =>
                $q->where('code_suministro', $codigo)
            )
            ->firstOrFail();

        $pdf = PDF::loadView('pdf.recibo', compact('consumo'));

        return $pdf->download("recibo_{$codigo}.pdf");
    }
}
