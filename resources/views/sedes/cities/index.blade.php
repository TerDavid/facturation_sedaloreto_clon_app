<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black dark:text-black leading-tight">
            {{ __('Seleccione ciudad') }}
        </h2>
    </x-slot>

    <div class="p-6 space-y-4">
         {{-- <a href="{{ route('sector.index') }}"
         class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
        Ver Todos los Sectores
      </a> --}}

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-blue-100 dark:text-blue-100">
          <thead class="text-xs text-white uppercase bg-blue-600 dark:text-white">
            <tr>
              <th scope="col" class="px-6 py-3">
                ID
              </th>
              <th scope="col" class="px-6 py-3">
                Ciudad
              </th>
              <th scope="col" class="px-6 py-3">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($ciudades as $ciudad)
              <tr class="bg-blue-500 border-b border-blue-400">
                <th scope="row"
                    class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                  {{ $ciudad->id }}
                </th>
                <td class="px-6 py-4">
                  {{ $ciudad->nombre }}
                </td>
                <td class="px-6 py-4">
                  <a href="{{ route('sector.index', ['ciudad_id' => $ciudad->id]) }}"
                     class="font-medium text-white hover:underline">
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
