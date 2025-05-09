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

            {{-- Campo: Sector --}}
            <div class="mb-5">
                <label for="id_sector" class="block mb-2 text-sm font-medium text-gray-900">Sector</label>
                <select name="id_sector" id="id_sector"
                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($sectores as $sector)
                        <option value="{{ $sector->id }}" {{ old('id_sector') == $sector->id ? 'selected' : '' }}>
                            {{ $sector->sector }}
                        </option>
                    @endforeach
                </select>
                @error('id_sector')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

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
