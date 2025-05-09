<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Crear Bomba de Agua') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white">
        <form action="{{ route('bomba-agua.store') }}" method="POST" class="max-w-md mx-auto">
            @csrf

            {{-- Campo: Bomba --}}
            <div class="mb-5">
                <label for="bomba" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la Bomba</label>
                <input type="text" name="bomba" id="bomba"
                       value="{{ old('bomba') }}"
                       class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500">
                @error('bomba')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo: Ciudad (oculto + texto fijo) --}}
            <input type="hidden" name="id_ciudades" value="{{ $ciudadId }}">
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900">Ciudad</label>
                <div class="p-3 bg-gray-100 border rounded-lg text-gray-800">
                    {{ \App\Models\Ciudad::find($ciudadId)->nombre ?? '—' }}
                </div>
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
