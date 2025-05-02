{{-- resources/views/clientes/medidores/sectores.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-white leading-tight">
        Sectores en {{ $ciudad->nombre }}
      </h2>
    </x-slot>

    <div class="p-6">


      {{-- Tabla responsiva --}}
      <div class="w-full overflow-x-auto">
        <table class="w-full table-auto bg-gray-800 text-white rounded mb-6 whitespace-nowrap">
          <thead>
            <tr>
              <th class="px-4 py-2 text-center">Sector</th>
              <th class="px-4 py-2 text-center">Reservorio</th>
              <th class="px-4 py-2 text-center">Bomba de Agua</th>

              <th class="px-4 py-2 text-center">Medidores</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sectores as $sector)
              <tr class="border-b border-gray-700">
                <td class="px-4 py-2 text-center">{{ $sector->sector }}</td>
                <td class="px-4 py-2 text-center">{{ $sector->reservorio->reservorio }}</td>
                <td class="px-4 py-2 text-center">{{ $sector->reservorio->bomba->bomba }}</td>
             
                <td class="px-4 py-2 text-center">
                  <a href="{{ route('medidores.index', [$ciudad, $sector]) }}"
                     class="text-blue-400 hover:underline">
                    Ver Medidores
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-gray-400">
                  No hay sectores registrados para esta ciudad.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
</x-app-layout>
