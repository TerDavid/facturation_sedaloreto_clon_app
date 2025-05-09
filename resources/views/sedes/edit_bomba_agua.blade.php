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

            {{-- Campo: Ciudad (fijo y oculto) --}}
            <input type="hidden" name="id_ciudades" value="{{ $bombaAgua->id_ciudades }}">
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900">Ciudad</label>
                <div class="p-3 bg-gray-100 border rounded-lg text-gray-800">
                    {{ $bombaAgua->ciudad->nombre ?? '—' }}
                </div>
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
