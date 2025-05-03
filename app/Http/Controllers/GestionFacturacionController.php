<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Sector;
use App\Models\Cliente;
use App\Models\Factura;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFacturaRequest;

class GestionFacturacionController extends Controller
{
    // 1) Listado de sectores
    public function sectores(Ciudad $ciudad)
    {
        $sectores = $ciudad
            ->bombas()
            ->with('reservorios.sectores')
            ->get()
            ->flatMap(fn($b) => $b->reservorios->flatMap->sectores);

        return view('clientes.gestion_facturacion.sectores', compact('ciudad','sectores'));
    }

    // 2) Listado de clientes en un sector
    public function clientes(Ciudad $ciudad, Sector $sector)
    {
        $clientes = Cliente::where('ciudad_id', $ciudad->id)
                          ->where('sector_id', $sector->id)
                          ->get();

        return view('clientes.gestion_facturacion.clientes', compact('ciudad','sector','clientes'));
    }

    // 3) Formulario de emisión masiva
    public function create(Ciudad $ciudad, Sector $sector)
    {
        $clientes = Cliente::where('ciudad_id', $ciudad->id)
                          ->where('sector_id', $sector->id)
                          ->get();

        return view('clientes.gestion_facturacion.create', compact('ciudad','sector','clientes'));
    }

    // 4) Almacenar facturas
    public function store(StoreFacturaRequest $request, Ciudad $ciudad, Sector $sector)
    {
        $data   = $request->validated();
        // Prefijo estándar: REC + mes sin guiones, p.ej. REC-202505
        $prefijo = 'REC-'.str_replace('-', '', $data['mes_factura']);

        foreach ($data['cliente_ids'] as $index => $clienteId) {
            $cliente = Cliente::with(['tarifa','consumoSinMedidor'])
                              ->findOrFail($clienteId);

            // 1) Calcular consumo:
            if ($cliente->medidor_id) {
                $consumo = $this->obtenerConsumoMedido($cliente, $data['mes_factura']);
            } else {
                $consumo = optional($cliente->consumoSinMedidor)->asignado_m3 ?? 0;
            }

            // 2) Calcular valor_pago:
            $tarifa = $cliente->tarifa;
            if ($tarifa) {
                $valorAgua  = $consumo * $tarifa->tarifa_agua;
                $valorAlc   = $consumo * $tarifa->tarifa_alcantarillado;
                $valorPago  = $valorAgua + $valorAlc + $tarifa->cargo_fijo;
            } else {
                $valorPago = 0;
            }

            // 3) Sufijo incremental:
            $count      = Factura::where('numero_recibo','like',"$prefijo-%")->count() + 1;
            $sufijo     = str_pad($count, 3, '0', STR_PAD_LEFT);
            $numRecibo  = "$prefijo-$sufijo";

            // 4) Guardar factura:
            Factura::create([
                'cliente_id'             => $cliente->id,
                'ciudad_id'              => $ciudad->id,
                'sector_id'              => $sector->id,
                'manzana_id'             => $cliente->manzana_id,
                'medidor_id'             => $cliente->medidor_id,
                'tarifa_id'              => $cliente->tarifa_id,
                'consumo_sin_medidor_id' => $cliente->consumo_sin_medidor_id,
                'fecha_emision'          => $data['fecha_emision'],
                'fecha_vencimiento'      => $data['fecha_vencimiento'],
                'mes_factura'            => $data['mes_factura'],
                'numero_recibo'          => $numRecibo,
                'valor_pago'             => round($valorPago, 2),
            ]);
        }

        return redirect()
            ->route('facturacion.clientes', [$ciudad, $sector])
            ->with('success','Facturas emitidas correctamente');
    }

    // 5) Editar factura
    public function edit(Ciudad $ciudad, Sector $sector, Factura $factura)
    {
        return view('clientes.gestion_facturacion.edit', compact('ciudad','sector','factura'));
    }

    // 6) Actualizar factura
    public function update(Request $request, Ciudad $ciudad, Sector $sector, Factura $factura)
    {
        $data = $request->validate([
            'fecha_emision'     => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'valor_pago'        => 'nullable|numeric|min:0',
            'numero_recibo'     => 'required|string|unique:facturas,numero_recibo,'.$factura->id,
            'mes_factura'       => 'required|string',
        ]);

        $factura->update($data);

        return redirect()
            ->route('facturacion.clientes', [$ciudad, $sector])
            ->with('success','Factura actualizada');
    }

    // 7) Eliminar factura
    public function destroy(Ciudad $ciudad, Sector $sector, Factura $factura)
    {
        $factura->delete();

        return back()->with('success','Factura eliminada');
    }

    /**
     * Método stub para obtener el consumo medido.
     * Por ahora devuelve 0: reemplázalo con tu lógica real (lecturas de medidor).
     */
    private function obtenerConsumoMedido(Cliente $cliente, string $mesFactura): float
    {
        // TODO: lee las lecturas correspondientes desde tu tabla de lecturas de medidores
        return 0.0;
    }
}
