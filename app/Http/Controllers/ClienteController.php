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
        $mode = 'default';
        return view('clientes.index', compact('ciudades', 'mode'));
    }
    public function indexSelectCity()
    {
        $ciudades = Ciudad::all();
        $mode = 'direct';
        return view('clientes.index', compact('ciudades', 'mode'));
    }

    // Dashboard de una ciudad
    public function show(Ciudad $ciudad)
    {
        return view('clientes.show', compact('ciudad'));
    }
}
