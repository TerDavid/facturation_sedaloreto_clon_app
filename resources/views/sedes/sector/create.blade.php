<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Crear Sector</h2>
    </x-slot>

    <div class="p-6 space-y-4">
      <form action="{{ route('sector.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Nombre del sector --}}
        <div>
          <label for="sector" class="block text-gray-200">Sector</label>
          <input
            type="text"
            name="sector"
            id="sector"
            class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2"
            value="{{ old('sector') }}"
          >
          @error('sector')
            <p class="text-red-400 text-sm">{{ $message }}</p>
          @enderror
        </div>

        {{-- Selección de reservorio con su bomba y ciudad --}}
        <div>
          <label for="id_reservorio" class="block text-gray-200">Reservorio</label>
          <select
            name="id_reservorio"
            id="id_reservorio"
            class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2"
          >
            <option value="">-- Selecciona reservorio --</option>
            @foreach($reservorios as $r)
              <option
                value="{{ $r->id }}"
                {{ old('id_reservorio') == $r->id ? 'selected' : '' }}
              >
                {{-- Texto compuesto mostrando reservorio, bomba y ciudad --}}
                {{ $r->reservorio }}
                &mdash; {{ $r->bomba->bomba }}
                ({{ $r->bomba->ciudad->nombre }})
              </option>
            @endforeach
          </select>
          @error('id_reservorio')
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
