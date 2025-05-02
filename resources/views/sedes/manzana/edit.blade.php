<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Editar Manzana') }}
      </h2>
    </x-slot>

    <div class="p-6">
      <form action="{{ route('manzana.update', $manzana) }}"
            method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-white">Nombre de Manzana</label>
          <input type="text" name="manzana"
                 value="{{ old('manzana', $manzana->manzana) }}"
                 class="w-full px-3 py-2 rounded bg-gray-700 text-white"
                 required>
          @error('manzana')
            <span class="text-red-400 text-sm">{{ $message }}</span>
          @enderror
        </div>

        <div>
          <label class="block text-white">Sector</label>
          <select name="id_sector"
                  class="w-full px-3 py-2 rounded bg-gray-700 text-white"
                  required>
            <option value="">-- Seleccionar --</option>
            @foreach($sectores as $sector)
              <option value="{{ $sector->id }}"
                {{ old('id_sector', $manzana->id_sector) == $sector->id ? 'selected' : '' }}>
                {{ $sector->sector }}
              </option>
            @endforeach
          </select>
          @error('id_sector')
            <span class="text-red-400 text-sm">{{ $message }}</span>
          @enderror
        </div>

        <div>
          <button type="submit"
                  class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
            Actualizar
          </button>
        </div>
      </form>
    </div>
  </x-app-layout>
