<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Crear Reservorio</h2>
    </x-slot>

    <div class="p-6 space-y-4">
      <form action="{{ route('reservorio.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Nombre del reservorio --}}
        <div>
          <label for="reservorio" class="block text-gray-200">Reservorio</label>
          <input
            type="text"
            name="reservorio"
            id="reservorio"
            class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2"
            value="{{ old('reservorio') }}"
          >
          @error('reservorio')
            <p class="text-red-400 text-sm">{{ $message }}</p>
          @enderror
        </div>

        {{-- Selección de bomba con ciudad incluida --}}
        <div>
          <label for="id_bomba_agua" class="block text-gray-200">Bomba de Agua</label>
          <select
            name="id_bomba_agua"
            id="id_bomba_agua"
            class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2"
          >
            <option value="">-- Selecciona bomba --</option>
            @foreach($bombas as $b)
              <option
                value="{{ $b->id }}"
                {{ old('id_bomba_agua') == $b->id ? 'selected' : '' }}
              >
                {{ $b->bomba }} — {{ $b->ciudad->nombre }}
              </option>
            @endforeach
          </select>
          @error('id_bomba_agua')
            <p class="text-red-400 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <button
          type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
        >
          Guardar
        </button>
      </form>
    </div>
</x-app-layout>
