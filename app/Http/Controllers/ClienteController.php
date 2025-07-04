<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Cliente;
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

    public function searchCliente(Request $request)
    {
        $clientes = Cliente::where('nombre', 'like', '%' . $request->search . '%')
            ->orWhere('nit', 'like', '%' . $request->search . '%')
            ->orWhere('direccion', 'like', '%' . $request->search . '%')
            ->orWhere('telefono', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%')
            ->get();
        return response()->json($clientes);
    }
}
