<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;

class SectorRelationController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::all();
        return view('sedes.cities.index', compact('ciudades'));
    }
}
