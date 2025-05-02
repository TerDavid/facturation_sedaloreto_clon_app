<?php

namespace App\Http\Controllers;

use App\Models\Medidor;
use App\Models\Manzana;
use App\Models\Sector;
use App\Http\Requests\StoreMedidorRequest;
use App\Http\Requests\UpdateMedidorRequest;
use App\Models\Ciudad;

class MedidorController extends Controller
{
    // 1) Mostrar sectores de la ciudad
    public function sectores(Ciudad $ciudad)
    {
        $sectores = Sector::whereHas('reservorio.bomba', function($q) use ($ciudad) {
            $q->where('id_ciudades', $ciudad->id);
        })->get();

        return view('clientes.medidores.sectores', compact('ciudad','sectores'));
    }



    // 2) Listar medidores de un sector en esa ciudad
    public function index(Ciudad $ciudad, Sector $sector)
    {
        $medidores = Medidor::with(['sector','manzana','ciudad'])
            ->where('ciudad_id', $ciudad->id)
            ->where('id_sector', $sector->id)
            ->get();

        return view('clientes.medidores.index', compact('ciudad','sector','medidores'));
    }

    public function create(Ciudad $ciudad, Sector $sector)
    {
        $manzanas = Manzana::where('id_sector', $sector->id)->get();
        return view('clientes.medidores.create', compact('ciudad','sector','manzanas'));
    }

    public function store(StoreMedidorRequest $request, Ciudad $ciudad, Sector $sector)
    {
        Medidor::create(
            $request->validated() +
            ['ciudad_id' => $ciudad->id, 'id_sector' => $sector->id]
        );
        return redirect()
            ->route('medidores.index', [$ciudad, $sector])
            ->with('success','Medidor creado');
    }

    public function edit(Ciudad $ciudad, Sector $sector, Medidor $medidor)
    {
        $manzanas = Manzana::where('id_sector', $sector->id)->get();
        return view('clientes.medidores.edit', compact('ciudad','sector','medidor','manzanas'));
    }

    public function update(UpdateMedidorRequest $request, Ciudad $ciudad, Sector $sector, Medidor $medidor)
    {
        $medidor->update($request->validated());
        return redirect()
            ->route('medidores.index', [$ciudad, $sector])
            ->with('success','Medidor actualizado');
    }

    public function destroy(Ciudad $ciudad, Sector $sector, Medidor $medidor)
    {
        $medidor->delete();
        return back()->with('success','Medidor eliminado');
    }
}
