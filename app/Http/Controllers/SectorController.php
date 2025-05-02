<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Reservorio;
use App\Models\Ciudad;
use App\Http\Requests\StoreSectorRequest;
use App\Http\Requests\UpdateSectorRequest;

class SectorController extends Controller
{
    public function index(Request $request)
    {
        $query = Sector::with('reservorio.bomba.ciudad');

        if ($request->filled('ciudad_id')) {
            // Filtro por ciudad y muestro la vista filtrada
            $ciudad   = Ciudad::findOrFail($request->ciudad_id);
            $query->whereHas('reservorio.bomba', function($q) use($request) {
                $q->where('id_ciudades', $request->ciudad_id);
            });
            $sectores = $query->paginate(10)->withQueryString();
            return view('sedes.view_sede.index', compact('sectores', 'ciudad'));
        }

        // Sin filtro: devuelvo la MISMA vista de sedes (view_sede)
        $sectores = $query->paginate(10);
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
