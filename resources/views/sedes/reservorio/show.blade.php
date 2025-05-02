<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Detalle de Reservorio</h2>
    </x-slot>

    <div class="p-6 space-y-4 text-white">
      <p><strong>ID:</strong> {{ $reservorio->id }}</p>
      <p><strong>Reservorio:</strong> {{ $reservorio->reservorio }}</p>
      <p><strong>Bomba:</strong> {{ $reservorio->bomba->bomba }}</p>

      <a href="{{ route('reservorio.index') }}"
         class="inline-block mt-4 px-4 py-2 bg-blue-600 rounded text-white">
        Volver al listado
      </a>
    </div>
  </x-app-layout>
