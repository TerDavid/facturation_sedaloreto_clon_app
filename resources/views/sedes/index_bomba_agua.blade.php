<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Listado de Bombas de Agua</h2>
    </x-slot>

    <div class="p-6">
      @if(session('success'))
        <div class="mb-4 p-3 bg-green-800 text-green-200 rounded">
          {{ session('success') }}
        </div>
      @endif

      <a href="{{ route('bomba-agua.create') }}"
         class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
        Nueva Bomba
      </a>

      <div class="w-full overflow-x-auto">
        <table class="w-full table-auto bg-gray-800 text-white rounded mb-6 whitespace-nowrap">
        <thead>
          <tr>
            <th class="px-4 py-2 text-center">ID</th>
            <th class="px-4 py-2 text-center">Bomba</th>
            <th class="px-4 py-2 text-center">Ciudad</th>
            <th class="px-4 py-2 text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @foreach($bombas as $b)
          <tr class="border-b border-gray-700">
            <td class="px-4 py-2 text-center">{{ $b->id }}</td>
            <td class="px-4 py-2 text-center">{{ $b->bomba }}</td>
            <td class="px-4 py-2 text-center">{{ $b->ciudad->nombre }}</td>
            <td class="px-4 py-2 text-center space-x-2">
              <a href="{{ route('bomba-agua.show',$b) }}"
                 class="text-blue-400 hover:underline">Ver</a>
              <a href="{{ route('bomba-agua.edit',$b) }}"
                 class="text-yellow-400 hover:underline">Editar</a>
              <form action="{{ route('bomba-agua.destroy',$b) }}"
                    method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="text-red-400 hover:underline"
                        onclick="return confirm('¿Seguro?')">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

      <div class="mt-4">
        {{ $bombas->links() }}
      </div>
    </div>
  </x-app-layout>
