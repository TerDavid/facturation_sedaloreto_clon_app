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
    /**
     * Muestra la lista de clientes junto con los datos necesarios
     * para la cascada Ciudad → Sector → Manzana y el JS.
     */
    public function index(Request $request)
    {
        $ciudades    = Ciudad::orderBy('nombre')->get();
        $allSectores = Sector::with('reservorio.bomba')->get();
        $allManzanas = Manzana::all();
        $clientes    = Cliente::all();
        $tarifas     = Tarifa::orderBy('categoria')->orderBy('rango_min')->get();
        $consumos    = ConsumoSinMedidor::orderBy('categoria')->get();

        return view('clientes.gestion_clientes.index', compact(
            'clientes',
            'ciudades',
            'allSectores',
            'allManzanas',
            'tarifas',
            'consumos'
        ));
    }

    /**
     * Guarda un nuevo cliente (y opcionalmente su medidor).
     */
    public function store(StoreClienteRequest $req)
    {
        $v = $req->validated();

        $categoria = $req->boolean('crear_medidor')
            ? Tarifa::find($v['tarifa_id'])->categoria
            : ConsumoSinMedidor::find($v['consumo_sin_medidor_id'])->categoria;

        $cliente = Cliente::create([
            'code_suministro'        => $v['code_suministro'],
            'nombre'                 => $v['nombre'],
            'apellido'               => $v['apellido'],
            'dni'                    => $v['dni'],
            'direccion'              => $v['direccion'] ?? null,
            'telefono'               => $v['telefono']  ?? null,
            'email'                  => $v['email']     ?? null,
            'id_manzana'             => $v['manzana_id'],
            'categoria'              => $categoria,
            'tarifa_id'              => $req->boolean('crear_medidor') ? $v['tarifa_id'] : null,
            'id_consumo_sin_medidor' => $req->boolean('crear_medidor') ? null : $v['consumo_sin_medidor_id'],
        ]);

        if ($req->boolean('crear_medidor')) {
            $cliente->medidor()->create([
                'codigo'              => $v['medidor_codigo'],
                'fecha_instalacion'   => $v['medidor_fecha_instalacion'] ?? null,
                'ubicacion_detallada' => $v['ubicacion_detallada'] ?? null,
            ]);
        }

        return redirect()
    ->route('gestion.clientes.index')
    ->with('success','Cliente registrado correctamente.');
    }

    /**
     * Actualiza un cliente existente (y su medidor si aplica).
     */
    public function update(UpdateClienteRequest $req, Cliente $cliente)
    {
        $v = $req->validated();

        $categoria = $req->boolean('crear_medidor')
            ? Tarifa::find($v['tarifa_id'])->categoria
            : ConsumoSinMedidor::find($v['consumo_sin_medidor_id'])->categoria;

        $cliente->update([
            'code_suministro'        => $v['code_suministro'],
            'nombre'                 => $v['nombre'],
            'apellido'               => $v['apellido'],
            'dni'                    => $v['dni'],
            'direccion'              => $v['direccion'] ?? null,
            'telefono'               => $v['telefono']  ?? null,
            'email'                  => $v['email']     ?? null,
            'id_manzana'             => $v['manzana_id'],
            'categoria'              => $categoria,
            'tarifa_id'              => $req->boolean('crear_medidor') ? $v['tarifa_id'] : null,
            'id_consumo_sin_medidor' => $req->boolean('crear_medidor') ? null : $v['consumo_sin_medidor_id'],
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
        ->route('gestion.clientes.index')
        ->with('success','Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente y su medidor (si existe).
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return back()->with('success', 'Cliente eliminado.');
    }
}
