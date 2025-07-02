<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\DocumentType;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Establishment;
use App\Models\Series;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function searchCliente(Request $request)
    {
        $clientes = Cliente::where('nombre', 'like', '%' . $request->search . '%')
            ->orWhere('dni', 'like', '%' . $request->search . '%')
            ->orWhere('nombre', 'like', '%' . $request->search . '%')
            ->orWhere('apellido', 'like', '%' . $request->search . '%')
            ->get();
        return response()->json($clientes);
    }
}
