{{-- resources/views/clientes/gestion_facturacion/clientes.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-white">
        Clientes · Sector {{ $sector->sector }}
      </h2>
    </x-slot>

    <div class="p-6 max-w-5xl mx-auto">
      <div class="flex justify-end mb-4">
        <a href="{{ route('facturacion.create', [$sector->reservorio->bomba->ciudad, $sector]) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
          + Emitir factura
        </a>
      </div>

      <div class="w-full overflow-x-auto">
        <table class="w-full table-auto bg-gray-800 text-white rounded mb-6 whitespace-nowrap">
          <thead>
            <tr>
              <th class="px-4 py-2">Cliente</th>
              <th class="px-4 py-2">DNI</th>
              <th class="px-4 py-2">Código Sum.</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clientes as $c)
              <tr class="border-b border-gray-700">
                <td class="px-4 py-2">{{ $c->nombre }} {{ $c->apellido }}</td>
                <td class="px-4 py-2">{{ $c->dni }}</td>
                <td class="px-4 py-2">{{ $c->codigo_suministro }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </x-app-layout>
