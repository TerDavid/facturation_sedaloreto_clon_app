<?php

namespace App\Http\Controllers;

use App\Models\Reservorio;
use App\Models\BombaAgua;
use App\Http\Requests\StoreReservorioRequest;
use App\Http\Requests\UpdateReservorioRequest;

class ReservorioController extends Controller
{
    public function index()
    {
        $reservorios = Reservorio::with('bomba.ciudad')->paginate(10);
        return view('sedes.reservorio.index', compact('reservorios'));
    }

    public function create()
    {
        $bombas = BombaAgua::with('ciudad')->get();

        return view('sedes.reservorio.create', compact('bombas'));
    }

    public function store(StoreReservorioRequest $request)
    {
        Reservorio::create($request->validated());
        return redirect()
            ->route('reservorio.index')
            ->with('success', 'Reservorio creado correctamente.');
    }

    public function show(Reservorio $reservorio)
    {
        return view('sedes.reservorio.show', compact('reservorio'));
    }

    public function edit(Reservorio $reservorio)
    {
        $bombas = BombaAgua::all();
        return view('sedes.reservorio.edit', compact('reservorio','bombas'));
    }

    public function update(UpdateReservorioRequest $request, Reservorio $reservorio)
    {
        $reservorio->update($request->validated());
        return redirect()
            ->route('reservorio.index')
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
