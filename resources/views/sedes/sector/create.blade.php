<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Crear Sector') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white">
        <form action="{{ route('sector.store') }}" method="POST" class="max-w-md mx-auto">
            @csrf

            {{-- Campo: Nombre del sector --}}
            <div class="mb-5">
                <label for="sector" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Sector</label>
                <input
                    type="text"
                    name="sector"
                    id="sector"
                    value="{{ old('sector') }}"
                    class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500"
                >
                @error('sector')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo: Selección de reservorio --}}
            <div class="mb-5">
                <label for="id_reservorio" class="block mb-2 text-sm font-medium text-gray-900">Reservorio</label>
                <select
                    name="id_reservorio"
                    id="id_reservorio"
                    class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">-- Selecciona reservorio --</option>
                    @foreach($reservorios as $r)
                        <option value="{{ $r->id }}" {{ old('id_reservorio') == $r->id ? 'selected' : '' }}>
                            {{ $r->reservorio }} — {{ $r->bomba->bomba }} ({{ $r->bomba->ciudad->nombre }})
                        </option>
                    @endforeach
                </select>
                @error('id_reservorio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón --}}
            <div class="mt-6">
                <button
                    type="submit"
                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition"
                >
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
