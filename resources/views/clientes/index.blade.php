<x-app-layout>
    <div class="mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Seleccionar ciudad</h2>
    </div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Seleccione una ciudad') }}
        </h2>
    </x-slot>

    <div class="py-[5vh] px-[5vw]">
        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8
                    grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($ciudades as $ciudad)
                @if ($mode == 'default')
                    <a href="{{ route('clientes.show', $ciudad) }}" class="block">
                    @else
                        <a href="{{ route('gestion_clientes.create', $ciudad) }}" class="block">
                @endif
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                                hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                        {{ $ciudad->nombre }}
                    </div>
                </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
