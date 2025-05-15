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
        $ciudades = Ciudad::orderBy('nombre')->get();

        // 🔁 Eliminamos map() y usamos los objetos completos
        $allSectores = Sector::with('reservorio.bomba')->get();
        $allManzanas = Manzana::all();

        $tarifas  = Tarifa::orderBy('categoria')->orderBy('rango_min')->get();
        $consumos = ConsumoSinMedidor::orderBy('categoria')->get();

        $ciudadId = $request->get('ciudad_id');

        $clientes = Cliente::with(['manzana.ciudad', 'manzana.sector'])
            ->when($ciudadId, fn($q) =>
                $q->whereHas('manzana', fn($qb) =>
                    $qb->where('id_ciudad', $ciudadId)
                )
            )
            ->orderBy('nombre')
            ->paginate(10);

        return view('clientes.gestion_clientes.index', compact(
            'ciudades', 'allSectores', 'allManzanas',
            'tarifas', 'consumos', 'clientes'
        ));
    }

    public function store(StoreClienteRequest $req)
    {
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
    }

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
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return back()->with('success', 'Cliente eliminado.');
    }
}
