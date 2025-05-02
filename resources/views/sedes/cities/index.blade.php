<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Seleccione Ciudad</h2>
    </x-slot>

    <div class="p-6 space-y-4">
      <a href="{{ route('sector.index') }}"
         class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
        Ver Todos los Sectores
      </a>

      <div class="w-full overflow-x-auto">
        <table class="w-full table-auto bg-gray-800 text-white rounded whitespace-nowrap">
          <thead>
            <tr>
              <th class="px-4 py-2 text-center">ID</th>
              <th class="px-4 py-2 text-center">Ciudad</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ciudades as $ciudad)
              <tr class="border-b border-gray-700">
                <td class="px-4 py-2 text-center">{{ $ciudad->id }}</td>
                <td class="px-4 py-2 text-center">{{ $ciudad->nombre }}</td>
                <td class="px-4 py-2 text-center">
                  <a href="{{ route('sector.index', ['ciudad_id' => $ciudad->id]) }}"
                     class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                    Ver Sectores
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </x-app-layout>
