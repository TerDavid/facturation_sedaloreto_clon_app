<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manzana;
use Illuminate\Http\Request;

class ManzanaController extends Controller
{
    public function sectores(Manzana $manzana, $secntor_id)
    {
        $sectores = $manzana->where('id_sector', $secntor_id)->get();

        return response()->json($sectores);
    }
}
