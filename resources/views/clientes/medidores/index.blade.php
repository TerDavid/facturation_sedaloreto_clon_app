{{-- resources/views/clientes/medidores/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Medidores en') }} {{ $ciudad->nombre }}
        </h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('medidores.create', [$ciudad, $sector]) }}"
           class="mb-4 inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
            + Nuevo medidor
        </a>

        @if($medidores->isEmpty())
            <div class="text-gray-400">
                {{ __('No hay medidores registrados.') }}
            </div>
        @else
            <div class="w-full overflow-x-auto">
                <table class="w-full table-auto bg-gray-800 text-white rounded mb-6 whitespace-nowrap">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">Código</th>
                            <th class="px-4 py-2 text-center">Estado</th>
                            <th class="px-4 py-2 text-center">Manzana</th>
                            <th class="px-4 py-2 text-center">Sector</th>
                            <th class="px-4 py-2 text-center">Ciudad</th>
                            <th class="px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medidores as $m)
                            <tr class="border-b border-gray-700">
                                <td class="px-4 py-2 text-center">{{ $m->codigo_medidor }}</td>
                                <td class="px-4 py-2 text-center">
                                    {{ ['Inactivo','Activo','En revisión'][$m->estado_medidor] }}
                                </td>
                                <td class="px-4 py-2 text-center">{{ $m->manzana->manzana }}</td>
                                <td class="px-4 py-2 text-center">{{ $m->sector->sector }}</td>
                                <td class="px-4 py-2 text-center">{{ $m->ciudad->nombre }}</td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('medidores.edit', [$ciudad, $sector, $m]) }}"
                                       class="text-blue-400 hover:underline">
                                        Editar
                                    </a>
                                    <form method="POST"
                                          action="{{ route('medidores.destroy', [$ciudad, $sector, $m]) }}"
                                          class="inline"
                                          onsubmit="return confirm('{{ __('¿Eliminar medidor?') }}')">
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
</x-app-layout>
