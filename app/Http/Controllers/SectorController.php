<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Reservorio;
use App\Http\Requests\StoreSectorRequest;
use App\Http\Requests\UpdateSectorRequest;

class SectorController extends Controller
{
    public function index()
    {
        $sectores = Sector::with('reservorio')->paginate(10);
        return view('sedes.sector.index', compact('sectores'));
    }

    public function create()
    {
        $reservorios = Reservorio::all();
        return view('sedes.sector.create', compact('reservorios'));
    }

    public function store(StoreSectorRequest $request)
    {
        Sector::create($request->validated());
        return redirect()
            ->route('sector.index')
            ->with('success', 'Sector creado correctamente.');
    }

    public function show(Sector $sector)
    {
        return view('sedes.sector.show', compact('sector'));
    }

    public function edit(Sector $sector)
    {
        $reservorios = Reservorio::all();
        return view('sedes.sector.edit', compact('sector','reservorios'));
    }

    public function update(UpdateSectorRequest $request, Sector $sector)
    {
        $sector->update($request->validated());
        return redirect()
            ->route('sector.index')
            ->with('success', 'Sector actualizado correctamente.');
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();
        return redirect()
            ->route('sector.index')
            ->with('success', 'Sector eliminado correctamente.');
    }
}
