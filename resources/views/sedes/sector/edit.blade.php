<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black dark:text-black leading-tight">
            {{ __('Editar Sector') }}
        </h2>
    </x-slot>


    <div class="p-6 space-y-4">
      <form action="{{ route('sector.update',$sector) }}"
            method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
          <label for="sector" class="block text-gray-200">Sector</label>
          <input type="text" name="sector" id="sector"
                 class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2"
                 value="{{ old('sector',$sector->sector) }}">
          @error('sector')<p class="text-red-400 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="id_reservorio" class="block text-gray-200">Reservorio</label>
          <select name="id_reservorio" id="id_reservorio"
                  class="mt-1 block w-full bg-gray-800 text-white rounded border-gray-600 px-3 py-2">
            @foreach($reservorios as $r)
              <option value="{{ $r->id }}"
                {{ old('id_reservorio',$sector->id_reservorio)==$r->id?'selected':'' }}>
                {{ $r->reservorio }}
              </option>
            @endforeach
          </select>
          @error('id_reservorio')<p class="text-red-400 text-sm">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
                class="px-4 py-2 bg-yellow-600 text-white rounded">
          Actualizar
        </button>
      </form>
    </div>
  </x-app-layout>
