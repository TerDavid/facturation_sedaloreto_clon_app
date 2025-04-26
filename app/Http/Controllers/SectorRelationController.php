<?php
// archivo: app/Http/Controllers/RelationController.php

namespace App\Http\Controllers;

use App\Models\Sector;

class SectorRelationController extends Controller
{
    public function index()
    {
        $sectores = Sector::with('reservorio.bomba.ciudad')->get();
        return view('sedes.view_sede.index', compact('sectores'));
    }
}
