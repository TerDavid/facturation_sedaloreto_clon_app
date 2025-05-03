<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Ciudad;
use Carbon\Carbon;

class ConsultaFacturaController extends Controller
{
    /**
     * Mostrar welcome.blade.php con la lista de ciudades.
     */
    public function index()
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('welcome', compact('ciudades'));
    }

    /**
     * Procesar el POST desde welcome.blade.php.
     */
    public function consultar(Request $request)
    {
        $data = $request->validate([
            'codigo' => ['required','string','exists:clientes,codigo_suministro'],
            'ciudad' => ['required','integer','exists:ciudades,id'],
        ]);

        $factura = Factura::with('cliente.ciudad')
            ->whereHas('cliente', function($q) use($data) {
                $q->where('codigo_suministro', $data['codigo'])
                  ->where('ciudad_id', $data['ciudad']);
            })
            ->whereMonth('fecha_emision', Carbon::now()->month)
            ->whereYear('fecha_emision',  Carbon::now()->year)
            ->first();

        // Siempre recargamos la lista de ciudades para la vista
        $ciudades = Ciudad::orderBy('nombre')->get();

        if (! $factura) {
            return back()
                ->withInput()
                ->with('error', 'No se encontró factura emitida para el mes actual.')
                ->with(compact('ciudades'));
        }

        return view('welcome', compact('factura','ciudades'));
    }
}
