<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Detalle de Bomba</h2>
    </x-slot>

    <div class="p-6 space-y-4 text-white">
      <p><strong>ID:</strong> {{ $bombaAgua->id }}</p>
      <p><strong>Bomba:</strong> {{ $bombaAgua->bomba }}</p>
      <p><strong>Ciudad:</strong> {{ $bombaAgua->ciudad->nombre }}</p>

      <a href="{{ route('bomba-agua.index') }}"
         class="inline-block mt-4 px-4 py-2 bg-blue-600 rounded text-white">
        Volver al listado
      </a>
    </div>
  </x-app-layout>
