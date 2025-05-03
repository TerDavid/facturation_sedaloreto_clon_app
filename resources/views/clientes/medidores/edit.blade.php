<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar medidor') }}
            <span class="font-normal"> {{ $medidor->codigo_medidor }}</span>
        </h2>
    </x-slot>

    <div class="py-[5vh] px-[5vw] max-w-3xl mx-auto">
        <form method="POST"
              action="{{ route('medidores.update', [$ciudad, $sector, $medidor]) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_sector"  value="{{ $sector->id }}">
            <input type="hidden" name="ciudad_id" value="{{ $ciudad->id }}">

            {{-- Código del medidor --}}
            <div class="mb-4">
                <label class="block mb-1 text-gray-700 dark:text-gray-300">Código del medidor</label>
                <input type="text"
                       name="codigo_medidor"
                       value="{{ old('codigo_medidor', $medidor->codigo_medidor) }}"
                       class="w-full border rounded px-3 py-2 @error('codigo_medidor') border-red-500 @enderror" />
                @error('codigo_medidor')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Manzana --}}
            <div class="mb-4">
                <label class="block mb-1 text-gray-700 dark:text-gray-300">Manzana</label>
                <select name="id_manzana"
                        class="w-full border rounded px-3 py-2 @error('id_manzana') border-red-500 @enderror">
                    <option value="">{{ __('-- Seleccione --') }}</option>
                    @foreach($manzanas as $m)
                        <option value="{{ $m->id }}"
                            {{ old('id_manzana', $medidor->id_manzana) == $m->id ? 'selected' : '' }}>
                            {{ $m->manzana }}
                        </option>
                    @endforeach
                </select>
                @error('id_manzana')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Estado --}}
            <div class="mb-6">
                <label class="block mb-1 text-gray-700 dark:text-gray-300">Estado</label>
                <select name="estado_medidor"
                        class="w-full border rounded px-3 py-2 @error('estado_medidor') border-red-500 @enderror">
                    <option value="1" {{ old('estado_medidor', $medidor->estado_medidor)==1?'selected':'' }}>Activo</option>
                    <option value="0" {{ old('estado_medidor', $medidor->estado_medidor)==0?'selected':'' }}>Inactivo</option>
                    <option value="2" {{ old('estado_medidor', $medidor->estado_medidor)==2?'selected':'' }}>En revisión</option>
                </select>
                @error('estado_medidor')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex space-x-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    {{ __('Actualizar') }}
                </button>
                <a href="{{ route('medidores.index', [$ciudad, $sector]) }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    {{ __('Cancelar') }}
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
