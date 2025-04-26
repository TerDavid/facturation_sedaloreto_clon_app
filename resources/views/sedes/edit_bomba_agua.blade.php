<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl text-white">Editar Bomba de Agua</h2>
    </x-slot>

    <div class="p-6">
      <form action="{{ route('bomba-agua.update',$bombaAgua) }}"
            method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
          <label for="bomba" class="block text-gray-200">Bomba</label>
          <input type="text" name="bomba" id="bomba"
                 class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2"
                 value="{{ old('bomba',$bombaAgua->bomba) }}">
          @error('bomba')<p class="text-red-400 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="id_ciudades" class="block text-gray-200">Ciudad</label>
          <select name="id_ciudades" id="id_ciudades"
                  class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2">
            @foreach($ciudades as $c)
              <option value="{{ $c->id }}"
                {{ old('id_ciudades',$bombaAgua->id_ciudades)==$c->id?'selected':'' }}>
                {{ $c->nombre }}
              </option>
            @endforeach
          </select>
          @error('id_ciudades')<p class="text-red-400 text-sm">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
                class="px-4 py-2 bg-yellow-600 text-white rounded">
          Actualizar
        </button>
      </form>
    </div>
  </x-app-layout>
