<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Editar Reservorio') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white">
        <form action="{{ route('reservorio.update', $reservorio) }}" method="POST" class="max-w-md mx-auto">
            @csrf
            @method('PUT')

            {{-- Campo: Nombre del reservorio --}}
            <div class="mb-5">
                <label for="reservorio" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Reservorio</label>
                <input type="text" name="reservorio" id="reservorio"
                       value="{{ old('reservorio', $reservorio->reservorio) }}"
                       class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500">
                @error('reservorio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo oculto ciudad --}}
            <input type="hidden" name="id_ciudad" value="{{ $reservorio->id_ciudad }}">

            {{-- Campo: Selección de bomba según ciudad --}}
            <div class="mb-5">
                <label for="id_bomba_agua" class="block mb-2 text-sm font-medium text-gray-900">Bomba de Agua</label>
                <select name="id_bomba_agua" id="id_bomba_agua"
                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($bombas->where('id_ciudades', $reservorio->id_ciudad) as $b)
                        <option value="{{ $b->id }}"
                            {{ old('id_bomba_agua', $reservorio->id_bomba_agua) == $b->id ? 'selected' : '' }}>
                            {{ $b->bomba }} — {{ $b->ciudad->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_bomba_agua')
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
