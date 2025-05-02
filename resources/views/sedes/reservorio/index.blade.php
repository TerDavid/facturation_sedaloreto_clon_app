<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Listado de Reservorios</h2>
    </x-slot>

    <div class="p-6">
      @if(session('success'))
        <div class="mb-4 p-3 bg-green-800 text-green-200 rounded">
          {{ session('success') }}
        </div>
      @endif

      <a href="{{ route('reservorio.create') }}"
         class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
        Nuevo Reservorio
      </a>

      <div class="w-full overflow-x-auto">
        <table class="w-full table-auto bg-gray-800 text-white rounded mb-6 whitespace-nowrap">
        <thead>
          <tr>
            <th class="px-4 py-2 text-center">ID</th>
            <th class="px-4 py-2 text-center">Reservorio</th>
            <th class="px-4 py-2 text-center">Bomba</th>
            <th class="px-4 py-2 text-center">Ciudad</th>
            <th class="px-4 py-2 text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @foreach($reservorios as $r)
          <tr class="border-b border-gray-700">
            <td class="px-4 py-2 text-center">{{ $r->id }}</td>
            <td class="px-4 py-2 text-center">{{ $r->reservorio }}</td>
            <td class="px-4 py-2 text-center">{{ $r->bomba->bomba }}</td>
            <td class="px-4 py-2 text-center">
                {{ $r->bomba->ciudad->nombre ?? '—' }}
              </td>
            <td class="px-4 py-2 text-center space-x-2">
              <a href="{{ route('reservorio.show',$r) }}"
                 class="text-blue-400 hover:underline">Ver</a>
              <a href="{{ route('reservorio.edit',$r) }}"
                 class="text-yellow-400 hover:underline">Editar</a>
              <form action="{{ route('reservorio.destroy',$r) }}"
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
        {{ $reservorios->links() }}
      </div>
    </div>
  </x-app-layout>
