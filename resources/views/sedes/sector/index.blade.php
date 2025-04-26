<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Listado de Sectores</h2>
    </x-slot>

    <div class="p-6">
      @if(session('success'))
        <div class="mb-4 p-3 bg-green-800 text-green-200 rounded">
          {{ session('success') }}
        </div>
      @endif

      <a href="{{ route('sector.create') }}"
         class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
        Nuevo Sector
      </a>

      <table class="w-full table-auto bg-gray-800 text-white rounded">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Sector</th>
            <th class="px-4 py-2">Reservorio</th>
            <th class="px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @foreach($sectores as $s)
          <tr class="border-b border-gray-700">
            <td class="px-4 py-2">{{ $s->id }}</td>
            <td class="px-4 py-2">{{ $s->sector }}</td>
            <td class="px-4 py-2">{{ $s->reservorio->reservorio }}</td>
            <td class="px-4 py-2 space-x-2">
              <a href="{{ route('sector.show',$s) }}"
                 class="text-blue-400 hover:underline">Ver</a>
              <a href="{{ route('sector.edit',$s) }}"
                 class="text-yellow-400 hover:underline">Editar</a>
              <form action="{{ route('sector.destroy',$s) }}"
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

      <div class="mt-4">
        {{ $sectores->links() }}
      </div>
    </div>
  </x-app-layout>
