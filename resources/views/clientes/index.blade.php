<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Seleccione una ciudad') }}
        </h2>
    </x-slot>

    <div class="py-[5vh] px-[5vw]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8
                    grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($ciudades as $ciudad)
                <a href="{{ route('clientes.show', $ciudad) }}" class="block">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
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
