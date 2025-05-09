<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Editar Sector') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white">
        <form action="{{ route('sector.update', $sector) }}" method="POST" class="max-w-md mx-auto">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-5">
                <label for="sector" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Sector</label>
                <input type="text" name="sector" id="sector" value="{{ old('sector', $sector->sector) }}"
                       class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 text-base focus:ring-blue-500 focus:border-blue-500">
                @error('sector')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Reservorio --}}
            <div class="mb-5">
                <label for="id_reservorio" class="block mb-2 text-sm font-medium text-gray-900">Reservorio</label>
                <select name="id_reservorio" id="id_reservorio"
                        class="block w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($reservorios as $r)
                        <option value="{{ $r->id }}"
                                {{ old('id_reservorio', $sector->id_reservorio) == $r->id ? 'selected' : '' }}>
                            {{ $r->reservorio }} — {{ $r->bomba->bomba }} ({{ $r->bomba->ciudad->nombre }})
                        </option>
                    @endforeach
                </select>
                @error('id_reservorio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bomba de agua (oculta) --}}
            <input type="hidden" name="id_bomba_agua" value="{{ $sector->id_bomba_agua }}">

            {{-- Ciudad (oculta) --}}
            <input type="hidden" name="id_ciudad" value="{{ $sector->id_ciudad }}">

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
