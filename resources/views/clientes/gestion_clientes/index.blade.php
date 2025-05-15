{{-- resources/views/clientes/gestion_clientes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold ">
            Lista de clientes @isset($ciudad)
                en {{ $ciudad->nombre }}
            @endisset
        </h2>
    </x-slot>
    <div class="mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Lista de clientes @isset($ciudad)
                en {{ $ciudad->nombre }}
            @endisset
        </h2>
    </div>
    <div class="py-6">
        <div class="flex justify-between items-center mb-6">
            @isset($ciudad)
                <a href="{{ route('gestion_clientes.create', $ciudad) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    + Nuevo cliente
                </a>
            @else
                <a href="{{ route('gestion.clientes.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    + Nuevo cliente
                </a>
            @endisset

        </div>
        <x-html.box>
            @if (isset($clientes) && $clientes->isEmpty())
                <p class="text-gray-400">No hay clientes registrados.</p>
            @else
                <div class="w-full overflow-x-auto ">

                    <x-table>
                        <x-table.thead>
                            <x-table.tr>
                                <x-table.th class="px-4 py-2 text-center">Nombre</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Apellido</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">DNI</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Celular</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Correo</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Dirección</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Estado</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Código Sum.</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Sector</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Manzana</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Medidor</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Tarifa</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Consumo S/M</x-table.th>
                                <x-table.th class="px-4 py-2 text-center">Acciones</x-table.th>
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @foreach ($clientes as $c)
                                <x-table.tr class="border-b border-gray-700">
                                    <x-table.td class="px-4 py-2 text-center">{{ $c->nombre }}</x-table.td>
                                    <x-table.td class="px-4 py-2 text-center">{{ $c->apellido }}</x-table.td>
                                    <x-table.td class="px-4 py-2 text-center">{{ $c->dni }}</x-table.td>
                                    <x-table.td class="px-4 py-2 text-center">{{ $c->celular }}</x-table.td>
                                    <x-table.td class="px-4 py-2 text-center">{{ $c->correo }}</x-table.td>
                                    <x-table.td class="px-4 py-2 text-center">{{ $c->direccion }}</x-table.td>
                                    <x-table.td class="px-4 py-2 text-center">
                                        {{ [
                                            0 => 'Inactivo',
                                            1 => 'Sin deuda',
                                            2 => 'Deuda',
                                            3 => 'Corte',
                                        ][$c->estado] ?? $c->estado }}
                                    </x-table.td>
                                    <x-table.td class="px-4 py-2 text-center">{{ $c->codigo_suministro }}</x-table.td>
                                    <x-table.td
                                        class="px-4 py-2 text-center">{{ optional($c->sector)->sector }}</x-table.td>
                                    <x-table.td
                                        class="px-4 py-2 text-center">{{ optional($c->manzana)->manzana }}</x-table.td>
                                    <x-table.td
                                        class="px-4 py-2 text-center">{{ optional($c->medidor)->codigo_medidor }}</x-table.td>
                                    <x-table.td
                                        class="px-4 py-2 text-center">{{ optional($c->tarifa)->categoria }}</x-table.td>
                                    <x-table.td
                                        class="px-4 py-2 text-center">{{ optional($c->consumoSinMedidor)->categoria }}
                                    </x-table.td>
                                    <x-table.td class="px-4 py-2 text-center space-x-2">
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
                                    </x-table.td>
                                </x-table.tr>
                            @endforeach
                        </x-table.tbody>
                    </x-table>
                </div>
            @endif
        </x-html.box>
    </div>
</x-app-layout>
