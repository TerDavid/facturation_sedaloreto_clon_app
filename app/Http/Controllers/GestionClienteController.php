<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\Sector;
use App\Models\Reservorio;
use App\Models\Manzana;
use App\Models\Tarifa;
use App\Models\ConsumoSinMedidor;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\Request;

class GestionClienteController extends Controller
{
    public function index(Request $request)
    {
        // $clientes = Cliente::where('ciudad_id', $ciudad->id)->get();
        $ciudades = Ciudad::orderBy('nombre')->get();

        // 🔁 Eliminamos map() y usamos los objetos completos
        $allSectores = Sector::with('reservorio.bomba')->get();
        $allManzanas = Manzana::all();
        $clientes = Cliente::all();
        $tarifas    = Tarifa::orderBy('categoria')->orderBy('rango_min')->get();
        $consumos = ConsumoSinMedidor::orderBy('categoria')->get();


        // dd($clientes);
        // dd($clientes[0]->sector);
        return view('clientes.gestion_clientes.index', compact('clientes', 'ciudades', 'allManzanas', 'allSectores', 'tarifas', 'consumos'));
    }
    public function index2()
    {
        $clientes = Cliente::select()->get();
        return view('clientes.gestion_clientes.index', compact('clientes'));
    }

    // 2) Formulario de creación
    public function create()
    {
        // $ciudad = Ciudad::find(1);
        $ciudades = Ciudad::all();
        // Tarifas (lista simple, sin agrupar)
        $tarifas    = Tarifa::orderBy('categoria')->orderBy('rango_min')->get();
        // $ciudad_id = request('ciudad_id');
        // if ($ciudad_id) {
        //     $ciudad = Ciudad::find($ciudad_id);
        // } else {
        //     $ciudad = Ciudad::first();
        // }

        $tarifas  = Tarifa::orderBy('categoria')->orderBy('rango_min')->get();
        $consumos = ConsumoSinMedidor::orderBy('categoria')->get();

        // $ciudadId = $request->get('ciudad_id');
        // Sectores de la ciudad (vía bombas → reservorios → sectores)
        // $bombaIds      = $ciudad->bombas()->pluck('id');
        $reservorioIds = Reservorio::whereIn('id_bomba_agua', $bombaIds)->pluck('id');
        // $sectores      = Sector::whereIn('id_reservorio', $reservorioIds)->get();

        // $clientes = Cliente::with(['manzana.ciudad', 'manzana.sector'])
        //     ->when($ciudadId, fn($q) =>
        //         $q->whereHas('manzana', fn($qb) =>
        //             $qb->where('id_ciudad', $ciudadId)
        //         )
        //     )
        //     ->orderBy('nombre')
        //     ->paginate(10);

        return view('clientes.gestion_clientes.index', compact(
            'ciudades',
            'allSectores',
            'allManzanas',
            'tarifas',
            'consumos',
            'clientes'
        ));
    }

    public function store(StoreClienteRequest $req)
    {
        // dd($req->post());
        // exit;
        $v = $req->validated();

        $categoria = $req->boolean('crear_medidor')
            ? Tarifa::find($v['tarifa_id'])->categoria
            : ConsumoSinMedidor::find($v['consumo_sin_medidor_id'])->categoria;

        $cliente = Cliente::create([
            'code_suministro'        => $v['code_suministro'],
            'nombre'                 => $v['nombre'],
            'direccion'              => $v['direccion'] ?? null,
            'telefono'               => $v['telefono']  ?? null,
            'email'                  => $v['email']     ?? null,
            'id_manzana'             => $v['manzana_id'],
            'categoria'              => $categoria,
            'tarifa_id'              => $req->boolean('crear_medidor')
                ? $v['tarifa_id']
                : null,
            'id_consumo_sin_medidor' => $req->boolean('crear_medidor')
                ? null
                : $v['consumo_sin_medidor_id'],
        ]);

        if ($req->boolean('crear_medidor')) {
            $cliente->medidor()->create([
                'codigo'              => $v['medidor_codigo'],
                'fecha_instalacion'   => $v['medidor_fecha_instalacion'] ?? null,
                'ubicacion_detallada' => $v['ubicacion_detallada'] ?? null,
            ]);
        }

        return redirect()
            ->route('gestion_clientes.index')
            ->with('success', 'Cliente registrado correctamente.');

        // return view('clientes.gestion_clientes.create', compact(
        //     'ciudad',
        //     'tarifas',
        //     'medidores',
        //     // 'sectores',
        //     'ciudades',
        //     'sector_id',
        //     'manzanas'
        // ));
    }

    // 3) Guardar nuevo cliente
    // public function store(StoreClienteRequest $request): RedirectResponse
    // {
    //     // dd($request->post());
    //     Cliente::create($request->validated());
    //     return redirect()
    //         ->route('gestion.clientes.index')
    //         ->with('success', 'Cliente registrado');
    // }

    public function update(UpdateClienteRequest $req, Cliente $cliente)
    {
        $v = $req->validated();

        $categoria = $req->boolean('crear_medidor')
            ? Tarifa::find($v['tarifa_id'])->categoria
            : ConsumoSinMedidor::find($v['consumo_sin_medidor_id'])->categoria;

        $cliente->update([
            'code_suministro'        => $v['code_suministro'],
            'nombre'                 => $v['nombre'],
            'direccion'              => $v['direccion'] ?? null,
            'telefono'               => $v['telefono']  ?? null,
            'email'                  => $v['email']     ?? null,
            'id_manzana'             => $v['manzana_id'],
            'categoria'              => $categoria,
            'tarifa_id'              => $req->boolean('crear_medidor')
                ? $v['tarifa_id']
                : null,
            'id_consumo_sin_medidor' => $req->boolean('crear_medidor')
                ? null
                : $v['consumo_sin_medidor_id'],
        ]);

        if ($req->boolean('crear_medidor')) {
            $attrs = [
                'codigo'              => $v['medidor_codigo'],
                'fecha_instalacion'   => $v['medidor_fecha_instalacion'] ?? null,
                'ubicacion_detallada' => $v['ubicacion_detallada'] ?? null,
            ];
            $cliente->medidor
                ? $cliente->medidor->update($attrs)
                : $cliente->medidor()->create($attrs);
        } else {
            $cliente->medidor?->delete();
        }

        return redirect()
            ->route('gestion_clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');

        // return view('clientes.gestion_clientes.edit', compact(
        //     'ciudad',
        //     'cliente',
        //     'tarifas',
        //     'medidores',
        //     'sectores',
        //     'manzanas',
        //     'sector_id',
        //     'consumosSM'
        // ));
    }




    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return back()->with('success', 'Cliente eliminado.');
    }
}
