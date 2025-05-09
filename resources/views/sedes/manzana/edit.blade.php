<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Editar Manzana') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white">
        <form action="{{ route('manzana.update', $manzana) }}" method="POST" class="max-w-md mx-auto">
            @csrf
            @method('PUT')

            {{-- Campo: Nombre de Manzana --}}
            <div class="mb-5">
                <label for="manzana" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la Manzana</label>
                <input type="text" name="manzana" id="manzana"
                       value="{{ old('manzana', $manzana->manzana) }}"
                       class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500"
                       required>
                @error('manzana')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Sector (oculto) --}}
            <input type="hidden" name="id_sector" value="{{ $sector->id }}">

            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900">Sector</label>
                <div class="block w-full p-3 bg-gray-100 text-gray-800 border border-gray-300 rounded-lg text-base">
                    {{ $sector->sector }}
                </div>
            </div>

            {{-- Campos ocultos --}}
            <input type="hidden" name="id_reservorio" value="{{ $reservorio->id }}">
            <input type="hidden" name="id_bomba_agua" value="{{ $bomba->id }}">
            <input type="hidden" name="id_ciudad" value="{{ $ciudad->id }}">

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
