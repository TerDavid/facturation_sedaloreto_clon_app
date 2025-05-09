<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Crear Manzana') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white">
        <form action="{{ route('manzana.store') }}" method="POST" class="max-w-md mx-auto">
            @csrf

            {{-- Campo: Nombre de Manzana --}}
            <div class="mb-5">
                <label for="manzana" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la Manzana</label>
                <input type="text" name="manzana" id="manzana"
                       value="{{ old('manzana') }}"
                       class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500"
                       required>
                @error('manzana')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo oculto: ID del sector --}}
            <input type="hidden" name="id_sector" value="{{ $sector->id }}">

            {{-- Mostrar nombre del sector en texto plano --}}
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900">Sector</label>
                <div class="block w-full p-3 bg-gray-100 text-gray-800 border border-gray-300 rounded-lg text-base">
                    {{ $sector->sector }}
                </div>
            </div>

            {{-- Campos ocultos con relaciones automáticas --}}
            <input type="hidden" name="id_reservorio" value="{{ $reservorio->id }}">
            <input type="hidden" name="id_bomba_agua" value="{{ $bomba->id }}">
            <input type="hidden" name="id_ciudad" value="{{ $ciudad->id }}">

            {{-- Botón --}}
            <div class="mt-6">
                <button type="submit"
                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
