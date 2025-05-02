<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Detalle de Sector</h2>
    </x-slot>

    <div class="p-6 space-y-4 text-white">
      <p><strong>ID:</strong> {{ $sector->id }}</p>
      <p><strong>Sector:</strong> {{ $sector->sector }}</p>
      <p><strong>Reservorio:</strong> {{ $sector->reservorio->reservorio }}</p>

      <a href="{{ route('sector.index') }}"
         class="inline-block mt-4 px-4 py-2 bg-blue-600 rounded text-white">
        Volver al listado
      </a>
    </div>
  </x-app-layout>
