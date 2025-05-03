{{-- resources/views/clientes/gestion_facturacion/sectores.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-white">
        Facturación · {{ $ciudad->nombre }}
      </h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto">
      <p class="mb-4 text-gray-300">Selecciona un sector para ver sus clientes y emitir facturas:</p>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($sectores as $sector)
          <a href="{{ route('facturacion.clientes', [$ciudad, $sector]) }}"
             class="block bg-gray-800 hover:bg-gray-700 text-white p-4 rounded shadow">
            {{ $sector->sector }}
          </a>
        @endforeach
      </div>
    </div>
  </x-app-layout>
