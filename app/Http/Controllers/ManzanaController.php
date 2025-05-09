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
        $query = Manzana::with('sector.reservorio.bomba.ciudad');


        $sector = null;

        if ($request->has('sector_id')) {
            $query->where('id_sector', $request->sector_id);
            $sector = Sector::findOrFail($request->sector_id);
        }

        $manzanas = $query->get();

        return view('sedes.manzana.index', compact('manzanas', 'sector'));
    }


public function create(Request $request)
{
    $sectores = Sector::all();

    $reservorio = null;
    $bomba = null;
    $ciudad = null;

    if ($request->filled('sector_id')) {
        $sector = Sector::with('reservorio.bomba.ciudad')->findOrFail($request->sector_id);
        $reservorio = $sector->reservorio;
        $bomba = $reservorio->bomba;
        $ciudad = $bomba->ciudad;
    }

    return view('sedes.manzana.create', compact('sectores', 'sector', 'reservorio', 'bomba', 'ciudad'));
}



public function store(StoreManzanaRequest $request)
{
    Manzana::create($request->validated());
    return redirect()->route('manzana.index', ['sector_id' => $request->id_sector])
    ->with('success', 'Manzana creada correctamente.');

}

    public function show(Manzana $manzana)
    {
        return view('sedes.manzana.show', compact('manzana'));
    }

    public function edit(Request $request, Manzana $manzana)
    {
        $sector = $manzana->sector;
        $reservorio = $sector->reservorio;
        $bomba = $reservorio->bomba;
        $ciudad = $bomba->ciudad;

        return view('sedes.manzana.edit', compact('manzana', 'sector', 'reservorio', 'bomba', 'ciudad'));
    }



    public function update(UpdateManzanaRequest $request, Manzana $manzana)
{
    $manzana->update($request->validated());
    return redirect()->route('manzana.index', ['sector_id' => $request->id_sector])
    ->with('success', 'Manzana actualizada correctamente.');

}

    public function destroy(Manzana $manzana)
    {
        $manzana->delete();
        return redirect()->route('manzana.index')
                         ->with('success', 'Manzana eliminada correctamente.');
    }
}
