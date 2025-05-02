<?php

namespace App\Http\Controllers;

use App\Models\Manzana;
use App\Models\Sector;
use App\Http\Requests\StoreManzanaRequest;
use App\Http\Requests\UpdateManzanaRequest;
use Illuminate\Http\Request;

class ManzanaController extends Controller
{
    public function index(Request $request)
{
    $query = Manzana::with('sector');

    if ($request->has('sector_id')) {
        $query->where('id_sector', $request->sector_id);
    }

    $manzanas = $query->get();

    return view('sedes.manzana.index', compact('manzanas'));
}

public function create(Request $request)
{
    $sectores = collect();

    if ($request->filled('sector_id')) {
        // 1) traigo el sector “base” con toda la cadena hasta ciudad
        $baseSector = Sector::with('reservorio.bomba.ciudad')
                            ->findOrFail($request->sector_id);

        $ciudadId = $baseSector
                      ->reservorio
                      ->bomba
                      ->ciudad
                      ->id;

        // 2) filtro los sectores cuyas bombas pertenezcan a esa ciudad
        $sectores = Sector::whereHas('reservorio.bomba.ciudad', function($q) use($ciudadId) {
            $q->where('ciudades.id', $ciudadId);
        })->get();
    }

    return view('sedes.manzana.create', compact('sectores'));
}

    public function store(StoreManzanaRequest $request)
    {
        Manzana::create($request->validated());
        return redirect()->route('manzana.index')
                         ->with('success', 'Manzana creada correctamente.');
    }

    public function show(Manzana $manzana)
    {
        return view('sedes.manzana.show', compact('manzana'));
    }

    public function edit(Request $request, Manzana $manzana)
    {
        // ciudad de la bomba del sector actual
        $ciudadId = $manzana->sector
                            ->reservorio
                            ->bomba
                            ->ciudad
                            ->id;

        $sectores = Sector::whereHas('reservorio.bomba.ciudad', function($q) use($ciudadId) {
            $q->where('ciudades.id', $ciudadId);
        })->get();

        return view('sedes.manzana.edit', compact('manzana', 'sectores'));
    }

    public function update(UpdateManzanaRequest $request, Manzana $manzana)
    {
        $manzana->update($request->validated());
        return redirect()->route('manzana.index')
                         ->with('success', 'Manzana actualizada correctamente.');
    }

    public function destroy(Manzana $manzana)
    {
        $manzana->delete();
        return redirect()->route('manzana.index')
                         ->with('success', 'Manzana eliminada correctamente.');
    }
}
