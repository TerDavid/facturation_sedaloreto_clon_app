<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Crear Planta de Tratamiento') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-800 text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('planta-tratamiento.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Sector -->
            <div>
                <label for="sector" class="block text-gray-200 font-medium mb-1">Sector</label>
                <input
                    type="text"
                    name="sector"
                    id="sector"
                    value="{{ old('sector') }}"
                    placeholder="Ingresa el sector"
                    class="mt-1 block w-full bg-gray-800 text-white placeholder-gray-500 border border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 @error('sector') border-red-500 @enderror"
                >
                @error('sector')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reservorio -->
            <div>
                <label for="reservorio" class="block text-gray-200 font-medium mb-1">Reservorio</label>
                <input
                    type="text"
                    name="reservorio"
                    id="reservorio"
                    value="{{ old('reservorio') }}"
                    placeholder="Ingresa el reservorio"
                    class="mt-1 block w-full bg-gray-800 text-white placeholder-gray-500 border border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 @error('reservorio') border-red-500 @enderror"
                >
                @error('reservorio')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bomba de Agua -->
            <div>
                <label for="bomba_agua" class="block text-gray-200 font-medium mb-1">Bomba de Agua</label>
                <input
                    type="text"
                    name="bomba_agua"
                    id="bomba_agua"
                    value="{{ old('bomba_agua') }}"
                    placeholder="Ingresa la bomba de agua"
                    class="mt-1 block w-full bg-gray-800 text-white placeholder-gray-500 border border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 @error('bomba_agua') border-red-500 @enderror"
                >
                @error('bomba_agua')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ciudad -->
            <div>
                <label for="id_ciudades" class="block text-gray-200 font-medium mb-1">Ciudad</label>
                <select
                    name="id_ciudades"
                    id="id_ciudades"
                    class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 @error('id_ciudades') border-red-500 @enderror"
                >
                    <option value="" class="text-gray-500">-- Selecciona una ciudad --</option>
                    @foreach($ciudades as $ciudad)
                        <option value="{{ $ciudad->id }}"
                            {{ old('id_ciudades') == $ciudad->id ? 'selected' : '' }}
                            class="bg-gray-800 text-white"
                        >
                            {{ $ciudad->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_ciudades')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón Guardar -->
            <div>
                <button
                    type="submit"
                    class="w-full inline-flex justify-center py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                >
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
