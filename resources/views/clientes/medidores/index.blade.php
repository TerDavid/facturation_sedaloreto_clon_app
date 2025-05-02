<x-app-layout>
    <x-slot name="header">
      <h2>Medidores en {{ $ciudad->nombre }}</h2>
    </x-slot>

    <div class="p-6">
      <a href="{{ route('medidores.create', [$ciudad, $sector]) }}"
         class="mb-4 inline-block bg-green-500 text-white px-4 py-2 rounded">
        + Nuevo medidor
      </a>

      @if($medidores->isEmpty())
        <div class="text-gray-500">No hay medidores registrados.</div>
      @else
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="px-4 py-2">Código</th>
              <th class="px-4 py-2">Estado</th>
              <th class="px-4 py-2">Manzana</th>
              <th class="px-4 py-2">Sector</th>
              <th class="px-4 py-2">Ciudad</th>
              <th class="px-4 py-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($medidores as $m)
              <tr class="border-t">
                <td class="px-4 py-2">{{ $m->codigo_medidor }}</td>
                <td class="px-4 py-2">{{ ['Inactivo','Activo','En revisión'][$m->estado_medidor] }}</td>
                <td class="px-4 py-2">{{ $m->manzana->manzana }}</td>
                <td class="px-4 py-2">{{ $m->sector->sector }}</td>
                <td class="px-4 py-2">{{ $m->ciudad->nombre }}</td>
                <td class="px-4 py-2 space-x-2">
                  <a href="{{ route('medidores.edit',   [$ciudad, $sector, $m]) }}"
                     class="text-blue-600">Editar</a>
                  <form method="POST"
                        action="{{ route('medidores.destroy', [$ciudad, $sector, $m]) }}"
                        class="inline"
                        onsubmit="return confirm('¿Eliminar medidor?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600">Eliminar</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </x-app-layout>
