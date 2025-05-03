<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\Tarifa;
use App\Models\Medidor;
use App\Models\Sector;
use App\Models\Reservorio;
use App\Models\Manzana;
use App\Models\ConsumoSinMedidor;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;

class GestionClienteController extends Controller
{
    // 1) Listado de clientes por ciudad
    public function index(Ciudad $ciudad)
    {
        $clientes = Cliente::where('ciudad_id', $ciudad->id)->get();
        return view('clientes.gestion_clientes.index', compact('ciudad','clientes'));
    }

    // 2) Formulario de creación
    public function create(Ciudad $ciudad)
    {
        // Tarifas (lista simple, sin agrupar)
        $tarifas    = Tarifa::orderBy('categoria')->orderBy('rango_min')->get();

        // Medidores de la ciudad
        $medidores = Medidor::where('ciudad_id', $ciudad->id)->get();

        // Sectores de la ciudad (vía bombas → reservorios → sectores)
        $bombaIds      = $ciudad->bombas()->pluck('id');
        $reservorioIds = Reservorio::whereIn('id_bomba_agua', $bombaIds)->pluck('id');
        $sectores      = Sector::whereIn('id_reservorio', $reservorioIds)->get();

        // Si viene sector_id por GET, cargo también sus manzanas
        $sector_id = request('sector_id');
        $manzanas  = $sector_id
            ? Manzana::where('id_sector', $sector_id)->get()
            : collect();

        return view('clientes.gestion_clientes.create', compact(
            'ciudad','tarifas','medidores','sectores','sector_id','manzanas'
        ));
    }

    // 3) Guardar nuevo cliente
    public function store(StoreClienteRequest $request, Ciudad $ciudad)
    {
        Cliente::create($request->validated() + ['ciudad_id' => $ciudad->id]);
        return redirect()
            ->route('gestion_clientes.index', $ciudad)
            ->with('success','Cliente registrado');
    }

    // 4) Formulario de edición
    public function edit(Ciudad $ciudad, Cliente $cliente)
    {
        // 4.1) Sectores
        $bombaIds      = $ciudad->bombas()->pluck('id');
        $reservorioIds = Reservorio::whereIn('id_bomba_agua', $bombaIds)->pluck('id');
        $sectores      = Sector::whereIn('id_reservorio', $reservorioIds)->get();
        // 4.2) Tarifas, medidores y consumos
        $tarifas    = Tarifa::orderBy('categoria')->orderBy('rango_min')->get();
        $medidores  = Medidor::where('ciudad_id', $ciudad->id)->get();
        $consumosSM = ConsumoSinMedidor::all();
        // 4.3) Sector actual o recién cambiado
        $sector_id = request('sector_id', $cliente->sector_id);
        $manzanas  = $sector_id
            ? Manzana::where('id_sector', $sector_id)->get()
            : collect();

        return view('clientes.gestion_clientes.edit', compact(
            'ciudad','cliente','tarifas','medidores','sectores','manzanas','sector_id','consumosSM'
        ));
    }

    // 5) Actualizar cliente
    public function update(UpdateClienteRequest $request, Ciudad $ciudad, Cliente $cliente)
    {
        $cliente->update($request->validated());
        return redirect()
            ->route('gestion_clientes.index', $ciudad)
            ->with('success','Cliente actualizado');
    }
    // 6) Eliminar cliente
    public function destroy(Ciudad $ciudad, Cliente $cliente)
    {
        $cliente->delete();
        return back()->with('success','Cliente eliminado');
    }
}
