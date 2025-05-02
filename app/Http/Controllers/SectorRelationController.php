<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Ciudad;

class SectorRelationController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::all();
        return view('sedes.cities.index', compact('ciudades'));
    }

    /**
     * Muestra *todas* las sedes (sectores) sin filtrar
     */
    public function sectores()
    {
        $sectores = Sector::with('reservorio.bomba.ciudad')
                          ->paginate(10);
        return view('sedes.view_sede.index', compact('sectores'));
    }
}
