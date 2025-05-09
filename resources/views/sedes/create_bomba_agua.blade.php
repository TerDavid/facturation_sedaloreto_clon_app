<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black dark:text-black leading-tight">
            {{ __('Crear Bomba de Agua') }}
        </h2>
    </x-slot>

    <div class="p-6">
      <form action="{{ route('bomba-agua.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
          <label for="bomba" class="block text-gray-200">Bomba</label>
          <input type="text" name="bomba" id="bomba"
                 class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2"
                 value="{{ old('bomba') }}">
          @error('bomba')<p class="text-red-400 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="id_ciudades" class="block text-gray-200">Ciudad</label>
          <select name="id_ciudades" id="id_ciudades"
                  class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2">
            <option value="">-- Selecciona ciudad --</option>
            @foreach($ciudades as $c)
              <option value="{{ $c->id }}"
                {{ old('id_ciudades')==$c->id?'selected':'' }}>
                {{ $c->nombre }}
              </option>
            @endforeach
          </select>
          @error('id_ciudades')<p class="text-red-400 text-sm">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded">
          Guardar
        </button>
      </form>
    </div>
  </x-app-layout>
