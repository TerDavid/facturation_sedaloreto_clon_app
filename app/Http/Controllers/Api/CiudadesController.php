<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ciudad;
use App\Models\Sector;
use Illuminate\Http\Request;

class CiudadesController extends Controller
{
    public function sectores(Ciudad $ciudad)
    {
        $sectores = $ciudad->sectores2;
        return response()->json($sectores);
    }
}
