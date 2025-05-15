<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    //
    public function clientes()
    {
        $clientes = Cliente::select()->get();

        return view('clientes.gestion_clientes.index', compact('clientes'));
    }
}
