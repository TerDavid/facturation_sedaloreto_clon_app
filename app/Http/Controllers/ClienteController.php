<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Listado de ciudades
    public function index()
    {
        $ciudades = Ciudad::all();
        return view('clientes.index', compact('ciudades'));
    }

    // Dashboard de una ciudad
    public function show(Ciudad $ciudad)
    {
        return view('clientes.show', compact('ciudad'));
    }
}
