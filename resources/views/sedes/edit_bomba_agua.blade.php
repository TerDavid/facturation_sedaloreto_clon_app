<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Editar Bomba de Agua') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white">
        <form action="{{ route('bomba-agua.update', $bombaAgua) }}"
              method="POST" class="max-w-md mx-auto">
            @csrf
            @method('PUT')

            {{-- Campo: Bomba --}}
            <div class="mb-5">
                <label for="bomba" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la Bomba</label>
                <input type="text" name="bomba" id="bomba"
                       value="{{ old('bomba', $bombaAgua->bomba) }}"
                       class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500">
                @error('bomba')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo: Ciudad --}}
            <div class="mb-5">
                <label for="id_ciudades" class="block mb-2 text-sm font-medium text-gray-900">Ciudad</label>
                <select name="id_ciudades" id="id_ciudades"
                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($ciudades as $c)
                        <option value="{{ $c->id }}"
                            {{ old('id_ciudades', $bombaAgua->id_ciudades) == $c->id ? 'selected' : '' }}>
                            {{ $c->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_ciudades')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón --}}
            <div class="mt-6">
                <button type="submit"
                        class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-semibold rounded-lg transition">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
