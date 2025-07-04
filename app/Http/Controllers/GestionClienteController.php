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
            ->with('success', 'Cliente registrado correctamente.');
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
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente y su medidor (si existe).
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return back()->with('success', 'Cliente eliminado.');
    }

    // app/Http/Controllers/AroResourceController.php



    public function datatableOld(Request $request)
    {
        // Inicializamos la query base
        $query = Cliente::select();


        // Copia para conteo total sin filtros
        $totalQuery = clone $query;

        // Aplicamos filtros
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            if (!empty($filter['buscar'])) {
                $search = '%' . $filter['buscar'] . '%';
                // $query->where(function ($q) use ($search) {
                //     $q->where('aro_resources.rec_txt_name', 'like', $search)
                //       ->orWhere('aro_resources.rec_txt_description', 'like', $search);
                // });
            }
        }

        // Conteo total y filtrado
        $recordsTotal = $totalQuery->count();
        $recordsFiltered = $query->count();

        // Ordenamiento
        if ($request->has('order')) {
            foreach ($request->input('order') as $order) {
                $colIndex = $order['column'];
                $colData = $request->input("columns.{$colIndex}.data");

                switch ($colData) {
                    case 'index':
                        continue 2; // omitimos index
                    default:
                        $direction = $order['dir'] === 'asc' ? 'asc' : 'desc';
                        $query->orderBy($colData, $direction);
                }
            }
        }

        // Paginación
        $start = $request->input('start');
        $length = $request->input('length');

        $rows = $query->offset($start)->limit($length)->get();

        // Agregar índice manual
        $index = $start + 1;
        $dataRows = $rows->map(function ($item) use (&$index) {
            $item->index = $index++;
            return $item;
        });

        return response()->json([
            'draw' => (int)$request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $dataRows,
        ]);
    }
    public function datatable(Request $request)
    {
        $query = Cliente::select([
            'clientes.id',
            'clientes.code_suministro',
            'clientes.nombre',
            'clientes.apellido',
            'clientes.dni',
            'clientes.direccion',
            'clientes.telefono',
            'clientes.email',
            'clientes.categoria',
            'clientes.tarifa_id',
            'clientes.id_consumo_sin_medidor',
            'manzana.id as manzana_id',
            'sector.id as sector_id',
            'ciudades.id as ciudad_id',
            'medidores.codigo as medidor_codigo',
            'medidores.fecha_instalacion as medidor_fecha_instalacion',
            'medidores.ubicacion_detallada',
            'manzana.manzana as manzana_nombre',
            'sector.sector as sector_nombre',
            'ciudades.nombre as ciudad_nombre'
        ])
            ->leftJoin('manzana', 'manzana.id', '=', 'clientes.id_manzana')
            ->leftJoin('sector', 'sector.id', '=', 'manzana.id_sector')
            ->leftJoin('ciudades', 'ciudades.id', '=', 'manzana.id_ciudad')
            ->leftJoin('medidores', 'medidores.cliente_id', '=', 'clientes.id');

        $totalQuery = clone $query;
        $recordsTotal = $totalQuery->count();

        // Aplicar filtros si existen
        if ($request->has('search')) {
            $filter = $request->input('search');

            if (!empty($filter['value'])) {
                $search = '%' . $filter['value'] . '%';
                $query->where(function ($q) use ($search) {
                    $q->where('clientes.nombre', 'like', $search)
                        ->orWhere('clientes.apellido', 'like', $search)
                        ->orWhere('clientes.dni', 'like', $search)
                        ->orWhere('clientes.code_suministro', 'like', $search);
                });
            }

            if (!empty($filter['categoria'])) {
                $query->where('clientes.categoria', $filter['categoria']);
            }

            if (!empty($filter['ciudad'])) {
                $query->where('ciudades.id', $filter['ciudad']);
            }

            if (!empty($filter['sector'])) {
                $query->where('sectores.id', $filter['sector']);
            }

            if (!empty($filter['manzana'])) {
                $query->where('manzanas.id', $filter['manzana']);
            }
        }

        // Ordenamiento
        if ($request->has('order')) {
            foreach ($request->input('order') as $order) {
                $colIndex = $order['column'];
                $colData = $request->input("columns.{$colIndex}.data");

                switch ($colData) {
                    case 'index':
                        continue 2;
                    case 'ciudad':
                        $query->orderBy('ciudades.nombre', $order['dir']);
                        break;
                    case 'sector_nombre':
                        $query->orderBy('sectores.sector', $order['dir']);
                        break;
                    case 'manzana_nombre':
                        $query->orderBy('manzanas.manzana', $order['dir']);
                        break;
                    default:
                        $query->orderBy($colData, $order['dir']);
                }
            }
        }

        // Paginación
        $start = $request->input('start');
        $length = $request->input('length');

        $rows = $query->offset($start)->limit($length)->get();

        // Agregar índice manual
        $index = $start + 1;
        $dataRows = $rows->map(function ($item) use (&$index) {
            return [
                'index' => $index++,
                'ciudad' => $item->ciudad_nombre,
                'sector' => $item->sector_nombre,
                'manzana' => $item->manzana_nombre,
                'id' => $item->id,
                'ciudad_id' => $item->ciudad_id,
                'sector_id' => $item->sector_id,
                'manzana_id' => $item->manzana_id,
                'nombre' => $item->nombre,
                'apellido' => $item->apellido,
                'dni' => $item->dni,
                'direccion' => $item->direccion,
                'telefono' => $item->telefono,
                'email' => $item->email,
                'crear_medidor' => $item->tarifa_id ? true : false,
                'medidor_codigo' => $item->medidor_codigo ?? '',
                'medidor_fecha_instalacion' => $item->medidor_fecha_instalacion ?? '',
                'ubicacion_detallada' => $item->ubicacion_detallada ?? '',
                'tarifa_id' => $item->tarifa_id ?? null,
                'consumo_sin_medidor_id' => $item->id_consumo_sin_medidor ?? null,
                'categoria' => $item->categoria,
                'code_suministro' => $item->code_suministro,
            ];
        });

        return response()->json([
            'draw' => (int)$request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $query->count(),
            'data' => $dataRows,
        ]);
    }
}
