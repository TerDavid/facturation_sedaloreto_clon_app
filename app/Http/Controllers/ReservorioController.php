<?php

namespace App\Http\Controllers;

use App\Models\Reservorio;
use App\Models\BombaAgua;
use App\Models\Ciudad;
use App\Http\Requests\StoreReservorioRequest;
use App\Http\Requests\UpdateReservorioRequest;

class ReservorioController extends Controller
{
    public function index()
    {
        $ciudadId = request('ciudad_id');
        $reservorios = Reservorio::with('bomba.ciudad', 'ciudad')
            ->when($ciudadId, fn($q) => $q->where('id_ciudad', $ciudadId))
            ->paginate(10);

        return view('sedes.reservorio.index', compact('reservorios'));
    }

    public function create()
{
    $ciudadId = request('ciudad_id');
    $bombas = BombaAgua::with('ciudad')->where('id_ciudades', $ciudadId)->get();
    $ciudades = Ciudad::all();

    return view('sedes.reservorio.create', compact('bombas', 'ciudades', 'ciudadId'));
}

    public function store(StoreReservorioRequest $request)
    {
        Reservorio::create($request->validated());

        return redirect()
            ->route('sector.index', ['ciudad_id' => $request->id_ciudad]) // redirige manteniendo ciudad
            ->with('success', 'Reservorio creado correctamente.');
    }

    public function show(Reservorio $reservorio)
    {
        return view('sedes.reservorio.show', compact('reservorio'));
    }

    public function edit(Reservorio $reservorio)
    {
        $bombas = BombaAgua::with('ciudad')->get();
        $ciudades = Ciudad::all();

        return view('sedes.reservorio.edit', compact('reservorio', 'bombas', 'ciudades'));
    }

    public function update(UpdateReservorioRequest $request, Reservorio $reservorio)
    {
        $reservorio->update($request->validated());

        return redirect()
            ->route('sector.index', ['ciudad_id' => $request->id_ciudad]) // igual en update
            ->with('success', 'Reservorio actualizado correctamente.');
    }

    public function destroy(Reservorio $reservorio)
    {
        $reservorio->delete();
        return redirect()
            ->route('reservorio.index')
            ->with('success', 'Reservorio eliminado correctamente.');
    }
}
