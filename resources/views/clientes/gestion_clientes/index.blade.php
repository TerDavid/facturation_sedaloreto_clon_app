{{-- resources/views/clientes/gestion_clientes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold ">
            Clientes @isset($ciudad)
                en {{ $ciudad->nombre }}
            @endisset
        </h2>
    </x-slot>
    <div class="mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Clientes @isset($ciudad)
                en {{ $ciudad->nombre }}
            @endisset
        </h2>
    </div>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            @isset($ciudad)
                <a href="{{ route('gestion_clientes.create', $ciudad) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    + Nuevo cliente
                </a>
            @else
                <a href="{{ route('clientes.indexSelectCity') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    + Nuevo cliente
                </a>
            @endisset

        </div>
        <div
            class="box relative before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:bg-background/30 before:shadow-[0px_3px_5px_#0000000b] before:z-[-1] before:rounded-xl after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:rounded-xl after:z-[-1] after:backdrop-blur-md p-4">

            @if ($clientes->isEmpty())
                <p class="text-gray-400">No hay clientes registrados.</p>
            @else
                <div class="w-full overflow-x-auto ">

                    <table class="w-full table-auto  rounded mb-6 whitespace-nowrap ">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center">Nombre</th>
                                <th class="px-4 py-2 text-center">Apellido</th>
                                <th class="px-4 py-2 text-center">DNI</th>
                                <th class="px-4 py-2 text-center">Celular</th>
                                <th class="px-4 py-2 text-center">Correo</th>
                                <th class="px-4 py-2 text-center">Dirección</th>
                                <th class="px-4 py-2 text-center">Estado</th>
                                <th class="px-4 py-2 text-center">Código Sum.</th>
                                <th class="px-4 py-2 text-center">Sector</th>
                                <th class="px-4 py-2 text-center">Manzana</th>
                                <th class="px-4 py-2 text-center">Medidor</th>
                                <th class="px-4 py-2 text-center">Tarifa</th>
                                <th class="px-4 py-2 text-center">Consumo S/M</th>
                                <th class="px-4 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $c)
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-2 text-center">{{ $c->nombre }}</td>
                                    <td class="px-4 py-2 text-center">{{ $c->apellido }}</td>
                                    <td class="px-4 py-2 text-center">{{ $c->dni }}</td>
                                    <td class="px-4 py-2 text-center">{{ $c->celular }}</td>
                                    <td class="px-4 py-2 text-center">{{ $c->correo }}</td>
                                    <td class="px-4 py-2 text-center">{{ $c->direccion }}</td>
                                    <td class="px-4 py-2 text-center">
                                        {{ [
                                            0 => 'Inactivo',
                                            1 => 'Sin deuda',
                                            2 => 'Deuda',
                                            3 => 'Corte',
                                        ][$c->estado] ?? $c->estado }}
                                    </td>
                                    <td class="px-4 py-2 text-center">{{ $c->codigo_suministro }}</td>
                                    <td class="px-4 py-2 text-center">{{ optional($c->sector)->sector }}</td>
                                    <td class="px-4 py-2 text-center">{{ optional($c->manzana)->manzana }}</td>
                                    <td class="px-4 py-2 text-center">{{ optional($c->medidor)->codigo_medidor }}</td>
                                    <td class="px-4 py-2 text-center">{{ optional($c->tarifa)->categoria }}</td>
                                    <td class="px-4 py-2 text-center">{{ optional($c->consumoSinMedidor)->categoria }}
                                    </td>
                                    <td class="px-4 py-2 text-center space-x-2">
                                        <a href="{{ route('gestion_clientes.edit', [$c->ciudad_id, $c]) }}"
                                            class="text-blue-400 hover:underline">
                                            Editar
                                        </a>
                                        <form method="POST"
                                            action="{{ route('gestion_clientes.destroy', [$c->ciudad_id, $c]) }}"
                                            class="inline" onsubmit="return confirm('¿Eliminar cliente?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:underline">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
