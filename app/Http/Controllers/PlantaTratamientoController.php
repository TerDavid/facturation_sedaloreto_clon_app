<?php

namespace App\Http\Controllers;

use App\Models\PlantaTratamiento;
use App\Models\Ciudad;
use App\Http\Requests\StorePlantaTratamientoRequest;
use Illuminate\Http\Request;

class PlantaTratamientoController extends Controller
{
    public function create()
    {
        $ciudades = Ciudad::all();
        return view('sedes.create', compact('ciudades'));
    }

    public function store(StorePlantaTratamientoRequest $request)
    {
        PlantaTratamiento::create($request->validated());
        return redirect()
            ->route('sedes.create')
            ->with('success', 'Planta de tratamiento creada correctamente.');
    }

    public function index()
    {
        $plantas = PlantaTratamiento::with('ciudad')->get();
        return view('sedes.create', compact('plantas'));
    }
}
