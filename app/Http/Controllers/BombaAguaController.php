<?php

namespace App\Http\Controllers;

use App\Models\BombaAgua;
use App\Models\Ciudad;
use App\Http\Requests\StoreBombaAguaRequest;
use App\Http\Requests\UpdateBombaAguaRequest;

class BombaAguaController extends Controller
{
    public function index()
    {
        $bombas = BombaAgua::with('ciudad')->paginate(10);
        return view('sedes.index_bomba_agua', compact('bombas'));
    }

    public function create()
    {
        $ciudades = Ciudad::all();
        return view('sedes.create_bomba_agua', compact('ciudades'));
    }

    public function store(StoreBombaAguaRequest $request)
    {
        BombaAgua::create($request->validated());
        return redirect()
            ->route('bomba-agua.index')
            ->with('success', 'Bomba registrada correctamente.');
    }

    public function show(BombaAgua $bombaAgua)
    {
        return view('sedes.show_bomba_agua', compact('bombaAgua'));
    }

    public function edit(BombaAgua $bombaAgua)
    {
        $ciudades = Ciudad::all();
        return view('sedes.edit_bomba_agua', compact('bombaAgua','ciudades'));
    }

    public function update(UpdateBombaAguaRequest $request, BombaAgua $bombaAgua)
    {
        $bombaAgua->update($request->validated());
        return redirect()
            ->route('bomba-agua.index')
            ->with('success', 'Bomba actualizada correctamente.');
    }

    public function destroy(BombaAgua $bombaAgua)
    {
        $bombaAgua->delete();
        return redirect()
            ->route('bomba-agua.index')
            ->with('success', 'Bomba eliminada correctamente.');
    }
}
