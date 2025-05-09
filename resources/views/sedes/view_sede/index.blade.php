<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black dark:text-black leading-tight">
            {{ __('Sectores') }}
        </h2>
    </x-slot>

    <div class="p-6">
        {{-- Botones para crear nuevos registros --}}
        <div class="flex flex-col items-start space-y-4 mb-6
                    md:flex-row md:space-x-4 md:space-y-0 md:items-center">
            <a href="{{ route('sector.index') }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                Crear Sector
            </a>
            <a href="{{ route('reservorio.index') }}"
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                Crear Reservorio
            </a>
            <a href="{{ route('bomba-agua.index') }}"
               class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded">
                Crear Bomba
            </a>
        </div>

        {{-- Tabla con nuevo estilo --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-blue-100 dark:text-blue-100">
                <thead class="text-xs text-white uppercase bg-blue-600 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">Sector</th>
                        <th scope="col" class="px-6 py-3">Reservorio</th>
                        <th scope="col" class="px-6 py-3">Bomba de Agua</th>
                        <th scope="col" class="px-6 py-3">Ciudad</th>
                        <th scope="col" class="px-6 py-3">Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sectores as $sector)
                        <tr class="bg-blue-500 border-b border-blue-400">
                            <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                                <div class="flex items-center space-x-2">
                                    <span>{{ $sector->sector }}</span>
                                    <a href="{{ route('manzana.index', ['sector_id' => $sector->id]) }}"
                                       class="px-2 py-1 bg-blue-700 hover:bg-blue-800 text-white rounded text-sm">
                                        Manzanas
                                    </a>
                                </div>
                            </th>
                            <td class="px-6 py-4">{{ $sector->reservorio->reservorio }}</td>
                            <td class="px-6 py-4">{{ $sector->reservorio->bomba->bomba }}</td>
                            <td class="px-6 py-4">{{ $sector->reservorio->bomba->ciudad->nombre }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('sector.show', $sector) }}"
                                   class="font-medium text-white hover:underline">
                                    Ver Sector
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400 whitespace-nowrap">
                                No hay sectores registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
