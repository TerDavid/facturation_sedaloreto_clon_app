<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Sedes') }}
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



      {{-- Envolvemos la tabla para permitir scroll horizontal en pantallas pequeñas --}}
      <div class="w-full overflow-x-auto">
        <table class="w-full table-auto bg-gray-800 text-white rounded mb-6 whitespace-nowrap">
          <thead>
            <tr>
              <th class="px-4 py-2 text-center">Sector</th>
              <th class="px-4 py-2 text-center">Reservorio</th>
              <th class="px-4 py-2 text-center">Bomba de Agua</th>
              <th class="px-4 py-2 text-center">Ciudad</th>
              <th class="px-4 py-2 text-center">Detalles</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sectores as $sector)
              <tr class="border-b border-gray-700">
                <td class="px-4 py-2">
                  <div class="flex items-center justify-center space-x-2">
                    <span>{{ $sector->sector }}</span>
                    <a href="{{ route('manzana.index', ['sector_id' => $sector->id]) }}"
                        class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm">
                       Manzanas
                     </a>
                  </div>
                </td>
                <td class="px-4 py-2 text-center">{{ $sector->reservorio->reservorio }}</td>
                <td class="px-4 py-2 text-center">{{ $sector->reservorio->bomba->bomba }}</td>
                <td class="px-4 py-2 text-center">{{ $sector->reservorio->bomba->ciudad->nombre }}</td>
                <td class="px-4 py-2 space-x-2 text-center">
                  <a href="{{ route('sector.show', $sector) }}"
                     class="text-blue-400 hover:underline">Ver Sector</a>
                  
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-gray-400">
                  No hay sectores registrados.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{-- /overflow-x-auto wrapper --}}
    </div>
</x-app-layout>
