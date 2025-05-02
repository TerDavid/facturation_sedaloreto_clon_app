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
            // 1) obtengo la ciudad para mostrar su nombre, si quieres
            $ciudad = Ciudad::findOrFail($request->ciudad_id);

            // 2) filtro sectores cuya bomba pertenezca a esa ciudad
            $query->whereHas('reservorio.bomba', function($q) use($request) {
                $q->where('id_ciudades', $request->ciudad_id);
            });

            // 3) pagino y devuelvo la vista de "view_sede"
            $sectores = $query->paginate(10)->withQueryString();
            return view('sedes.view_sede.index', compact('sectores', 'ciudad'));
        }

        // sin filtro: vista normal de sectores
        $sectores = $query->paginate(10);
        return view('sedes.view_sede.index', compact('sectores'));
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
