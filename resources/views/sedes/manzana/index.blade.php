<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Manzanas') }}
      </h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('manzana.create', ['sector_id' => request('sector_id')]) }}"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
        Crear Manzana
        </a>

      <div class="w-full overflow-x-auto mt-4">
        <table class="w-full table-auto bg-gray-800 text-white rounded mb-6 whitespace-nowrap">
          <thead>
            <tr>
              <th class="px-4 py-2 text-center">ID</th>
              <th class="px-4 py-2 text-center">Manzana</th>
              <th class="px-4 py-2 text-center">Sector</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($manzanas as $manzana)
              <tr class="border-b border-gray-700">
                <td class="px-4 py-2 text-center">{{ $manzana->id }}</td>
                <td class="px-4 py-2 text-center">{{ $manzana->manzana }}</td>
                <td class="px-4 py-2 text-center">{{ $manzana->sector->sector }}</td>
                <td class="px-4 py-2 text-center space-x-2">
                  <a href="{{ route('manzana.edit', $manzana) }}"
                     class="text-yellow-400 hover:underline">Editar</a>
                  <form action="{{ route('manzana.destroy', $manzana) }}"
                        method="POST" class="inline-block"
                        onsubmit="return confirm('¿Eliminar esta manzana?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-red-500 hover:underline">
                      Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4"
                    class="text-center py-4 text-gray-400">
                  No hay manzanas creadas.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </x-app-layout>
