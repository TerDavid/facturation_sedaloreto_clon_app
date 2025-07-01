<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Consumo;
use App\Models\ConsumoSinMedidor;
use App\Models\Manzana;
use App\Models\Sector;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsumosExport;
use App\Imports\ConsumosImport;
use App\Http\Requests\StoreConsumoRequest;
use App\Http\Requests\UpdateConsumoRequest;
use App\Models\Catalogs\DocumentType;
use App\Models\Company;
use App\Models\Establishment;

class FacturacionEmitir extends Controller
{
    public function index()
    {
        $stablecimiento = Establishment::first();
        $company = Company::active();
        $documents_type = DocumentType::where('active', 1)->get();
        // $document_types_invoice = Docu
        return view('facturation.emitir.index', compact('company', 'stablecimiento', 'documents_type'));
    }

   
}
