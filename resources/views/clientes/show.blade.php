<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ciudad:') }} {{ $ciudad->nombre }}
        </h2>
    </x-slot>

    <div class="py-[5vh] px-[5vw]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8
                    grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="#" class="block">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                            hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                        {{ __('Registrar clientes') }}
                    </div>
                </div>
            </a>

            <a href="{{ route('medidores.sectores', $ciudad) }}" class="block">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                            hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                        {{ __('Gestionar medidores') }}
                    </div>
                </div>
            </a>

            <a href="#" class="block">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                            hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                        {{ __('Gestionar facturación') }}
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
