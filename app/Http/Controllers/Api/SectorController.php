<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function manzanas(Sector $sector)
    {
        return response()->json($sector->manzanas);
    }
}
